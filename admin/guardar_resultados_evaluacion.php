<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$evaluacion_id = $_POST['evaluacion_id'] ?? null;
if (!$evaluacion_id || !is_numeric($evaluacion_id)) {
    header("Location: evaluaciones.php");
    exit;
}

// Obtener datos de la evaluación
$stmt = $pdo->prepare("SELECT * FROM evaluaciones WHERE id = ?");
$stmt->execute([$evaluacion_id]);
$evaluacion = $stmt->fetch();

if (!$evaluacion) {
    header("Location: evaluaciones.php");
    exit;
}

$curso_id = $evaluacion['curso_id'];
$asignatura_id = $evaluacion['asignatura_id'];
$numero_evaluacion = $evaluacion['numero_evaluacion'];
$pond_examen = $evaluacion['ponderacion_examenes'];
$pond_activ = $evaluacion['ponderacion_actividades'];
$pond_asist = $evaluacion['ponderacion_asistencia'];

// Obtener alumnos del curso
$stmt = $pdo->prepare("SELECT u.id FROM alumnos al JOIN usuarios u ON al.id = u.id WHERE al.curso_id = ?");
$stmt->execute([$curso_id]);
$alumnos = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Obtener exámenes
$stmt = $pdo->prepare("SELECT id FROM examenes WHERE asignatura_id = ? AND evaluacion = ?");
$stmt->execute([$asignatura_id, $numero_evaluacion]);
$examenes = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Obtener actividades
$stmt = $pdo->prepare("SELECT id FROM actividades WHERE asignatura_id = ? AND curso_id = ? AND evaluacion = ?");
$stmt->execute([$asignatura_id, $curso_id, $numero_evaluacion]);
$actividades = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Obtener asistencias
$stmt = $pdo->prepare("SELECT alumno_id FROM asistencia WHERE asignatura_id = ?  AND evaluacion = ?");
$stmt->execute([$asignatura_id, $numero_evaluacion]);
$asistencias = $stmt->fetchAll(PDO::FETCH_COLUMN);

foreach ($alumnos as $alumno_id) { 
    // Calcular nota exámenes
    $totalEx = 0; $countEx = 0;
    foreach ($examenes as $examen_id) {
        $stmt = $pdo->prepare("SELECT nota_total FROM notas_examen_alumno WHERE examen_id = ? AND alumno_id = ?");
        $stmt->execute([$examen_id, $alumno_id]);
        $nota = $stmt->fetchColumn();
        if ($nota !== false) {
            $totalEx += $nota;
            $countEx++;
        }
    }
    $mediaEx = $countEx > 0 ? round($totalEx / $countEx, 2) : 0;
    $pondEx = round($mediaEx * $pond_examen, 2);

    // Calcular nota actividades
    $totalAct = 0; $countAct = 0;
    foreach ($actividades as $actividad_id) {
        $stmt = $pdo->prepare("SELECT nota FROM actividades_alumnos WHERE actividad_id = ? AND alumno_id = ?");
        $stmt->execute([$actividad_id, $alumno_id]);
        $nota = $stmt->fetchColumn();
        if ($nota !== false) {
            $totalAct += $nota;
            $countAct++;
        }
    }
    $mediaAct = $countAct > 0 ? round($totalAct / $countAct, 2) : 0;
    $pondAct = round($mediaAct * $pond_activ, 2);

    // Calcular asistencia
    $asistencia = $asistencias[$alumno_id] ?? 0;
    $pondAsist = round(($asistencia * $pond_asist) / 100, 2);

    // Nota final
    $notaFinal = round($pondEx + $pondAct + $pondAsist, 2);

    // Guardar en tabla
    $stmt = $pdo->prepare("INSERT INTO notas_finales_evaluacion (alumno_id, curso_id, asignatura_id, evaluacion_id, nota_examenes, nota_actividades, asistencia, nota_final)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE nota_examenes = VALUES(nota_examenes), nota_actividades = VALUES(nota_actividades), asistencia = VALUES(asistencia), nota_final = VALUES(nota_final)");

    $stmt->execute([$alumno_id, $curso_id, $asignatura_id, $evaluacion_id, $mediaEx, $mediaAct, $asistencia, $notaFinal]);
}

header("Location: evaluacion_resultados.php?evaluacion_id=$evaluacion_id&guardado=1");
exit;
