<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once '../includes/SimpleXLSXGen.php';


use Shuchkin\SimpleXLSXGen;

$evaluacion_id = $_GET['evaluacion_id'] ?? null;
if (!$evaluacion_id || !is_numeric($evaluacion_id)) {
    die("Evaluación no válida");
}

// Obtener datos de la evaluación
$stmt = $pdo->prepare("SELECT e.*, c.nombre AS curso_nombre, a.nombre AS asignatura_nombre 
    FROM evaluaciones e 
    JOIN cursos c ON e.curso_id = c.id 
    JOIN asignaturas a ON e.asignatura_id = a.id 
    WHERE e.id = ?");
$stmt->execute([$evaluacion_id]);
$evaluacion = $stmt->fetch();

if (!$evaluacion) {
    die("Evaluación no encontrada");
}

$curso_id = $evaluacion['curso_id'];
$asignatura_id = $evaluacion['asignatura_id'];
$numero_evaluacion = $evaluacion['numero_evaluacion'];
$pond_examen = $evaluacion['ponderacion_examenes'];
$pond_activ = $evaluacion['ponderacion_actividades'];
$pond_asist = $evaluacion['ponderacion_asistencia'];

// Alumnos del curso
$stmt = $pdo->prepare("SELECT u.id, u.nombre, u.apellido, u.email 
    FROM alumnos al JOIN usuarios u ON al.id = u.id 
    WHERE al.curso_id = ? 
    ORDER BY u.apellido, u.nombre");
$stmt->execute([$curso_id]);
$alumnos = $stmt->fetchAll();

// Exámenes
$stmt = $pdo->prepare("SELECT id, titulo FROM examenes 
    WHERE asignatura_id = ? AND evaluacion = ?");
$stmt->execute([$asignatura_id, $numero_evaluacion]);
$examenes = $stmt->fetchAll();

// Actividades
$stmt = $pdo->prepare("SELECT id, titulo FROM actividades 
    WHERE asignatura_id = ? AND curso_id = ? AND evaluacion = ?");
$stmt->execute([$asignatura_id, $curso_id, $numero_evaluacion]);
$actividades = $stmt->fetchAll();

// Asistencias
$stmt = $pdo->prepare("SELECT alumno_id, porcentaje_asistencia 
    FROM asistencia 
    WHERE asignatura_id = ? AND evaluacion = ?");
$stmt->execute([$asignatura_id, $numero_evaluacion]);
$asistencias = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Cabecera
$header = ['Alumno', 'Email'];
foreach ($examenes as $ex) {
    $header[] = $ex['titulo'];
}
$header[] = 'Media Ex.';
$header[] = 'Pond. Ex.';
foreach ($actividades as $act) {
    $header[] = $act['titulo'];
}
$header[] = 'Media Act.';
$header[] = 'Pond. Act.';
$header[] = '% Asist.';
$header[] = 'Pond. Asist.';
$header[] = 'Nota Final';

$data = [$header];

// Cuerpo
foreach ($alumnos as $al) {
    $eid = $al['id'];
    $row = [$al['apellido'] . ', ' . $al['nombre'], $al['email']];

    // Exámenes
    $totalEx = 0; $countEx = 0;
    foreach ($examenes as $ex) {
        $stmt = $pdo->prepare("SELECT nota_total FROM notas_examen_alumno 
            WHERE examen_id = ? AND alumno_id = ?");
        $stmt->execute([$ex['id'], $eid]);
        $nota = $stmt->fetchColumn();
        if ($nota !== false) {
            $totalEx += $nota;
            $countEx++;
            $row[] = number_format($nota, 2);
        } else {
            $row[] = '—';
        }
    }
    $mediaEx = $countEx > 0 ? round($totalEx / $countEx, 2) : 0;
    $ponderadaEx = round($mediaEx * $pond_examen, 2);
    $row[] = number_format($mediaEx, 2);
    $row[] = number_format($ponderadaEx, 2);

    // Actividades
    $totalAct = 0; $countAct = 0;
    foreach ($actividades as $act) {
        $stmt = $pdo->prepare("SELECT nota FROM actividades_alumnos 
            WHERE actividad_id = ? AND alumno_id = ?");
        $stmt->execute([$act['id'], $eid]);
        $nota = $stmt->fetchColumn();
        if ($nota !== false) {
            $totalAct += $nota;
            $countAct++;
            $row[] = number_format($nota, 2);
        } else {
            $row[] = '—';
        }
    }
    $mediaAct = $countAct > 0 ? round($totalAct / $countAct, 2) : 0;
    $ponderadaAct = round($mediaAct * $pond_activ, 2);
    $row[] = number_format($mediaAct, 2);
    $row[] = number_format($ponderadaAct, 2);

    // Asistencia
    $asistencia = $asistencias[$eid] ?? 0;
    $ponderadaAsist = round($asistencia * $pond_asist / 100, 2);
    $row[] = number_format($asistencia, 1) . '%';
    $row[] = number_format($ponderadaAsist, 2);

    // Nota final
    $notaFinal = round($ponderadaEx + $ponderadaAct + $ponderadaAsist, 2);
    $row[] = number_format($notaFinal, 2);

    $data[] = $row;
}

// Exportar Excel
$xlsx = SimpleXLSXGen::fromArray($data);
$filename = "resultados_evaluacion_{$numero_evaluacion}_" . date('Ymd_His') . ".xlsx";
$xlsx->downloadAs($filename);
exit;