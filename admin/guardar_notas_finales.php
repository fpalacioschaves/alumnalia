<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';



redirigir_si_no_autenticado();
solo_admin();

$examen_id = $_POST['examen_id'] ?? null;

if (!$examen_id) {
    header("Location: examenes.php");
    exit;
}

// 1. Obtener el curso asociado al examen, a través de su asignatura
$stmt = $pdo->prepare("
    SELECT c.id AS curso_id
    FROM examenes e
    JOIN asignaturas a ON e.asignatura_id = a.id
    JOIN cursos c ON a.curso_id = c.id
    WHERE e.id = ?
");
$stmt->execute([$examen_id]);
$curso = $stmt->fetch();

if (!$curso) {
    echo "No se encontró el curso asociado al examen.";
    exit;
}

// 2. Obtener todos los alumnos del curso
$stmt = $pdo->prepare("SELECT id FROM alumnos WHERE curso_id = ?");
$stmt->execute([$curso['curso_id']]);
$alumnos = $stmt->fetchAll(PDO::FETCH_COLUMN);


foreach ($alumnos as $alumno_id) {
    // Notas de ejercicios manuales
    $stmt1 = $pdo->prepare("
        SELECT SUM(r.puntuacion_obtenida)
        FROM resoluciones r
        JOIN ejercicios e ON r.ejercicio_id = e.id
        WHERE e.examen_id = ? AND r.alumno_id = ?
    ");
    $stmt1->execute([$examen_id, $alumno_id]);
    $nota_manual = $stmt1->fetchColumn() ?? 0;

    // Notas de banco de preguntas
    $stmt2 = $pdo->prepare("
        SELECT SUM(rb.puntuacion_obtenida)
        FROM resoluciones_banco_preguntas rb
        JOIN banco_preguntas_en_examen bpe ON rb.ejercicio_id = bpe.pregunta_id AND bpe.examen_id = ?
        WHERE rb.alumno_id = ?
    ");
    $stmt2->execute([$examen_id, $alumno_id]);
    $nota_banco = $stmt2->fetchColumn() ?? 0;

    $nota_total = $nota_manual + $nota_banco;

    // Insertar o actualizar
    $stmt = $pdo->prepare("
        INSERT INTO notas_examen_alumno (examen_id, alumno_id, nota_total)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE nota_total = VALUES(nota_total)
    ");
    $stmt->execute([$examen_id, $alumno_id, $nota_total]);
}

header("Location: calificaciones.php?examen_id=$examen_id&notas_guardadas=1");
exit;