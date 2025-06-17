<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
header('Content-Type: application/json');

//redirigir_si_no_autenticado();


$alumno_id = $_SESSION['usuario_id'];
$eventos = [];

// Obtener exámenes del curso del alumno
$stmt = $pdo->prepare("SELECT e.id, e.titulo, e.fecha
                       FROM examenes e
                       JOIN asignaturas a ON e.asignatura_id = a.id
                       JOIN cursos c ON a.curso_id = c.id
                       JOIN alumnos al ON al.curso_id = c.id
                       WHERE al.id = ? AND e.fecha IS NOT NULL");
$stmt->execute([$alumno_id]);
foreach ($stmt->fetchAll() as $examen) {
    $eventos[] = [
        'title' => 'Examen: ' . $examen['titulo'],
        'start' => $examen['fecha'],
        'color' => '#e63946',
       // 'url' => "../admin/examen_editar.php?id=" . $examen['id']
    ];
}

// Obtener tareas asignadas al alumno
$stmt = $pdo->prepare("SELECT ta.id, ep.enunciado, ta.fecha_limite_entrega
                       FROM tareas_asignadas ta
                       JOIN ejercicios_propuestos ep ON ta.ejercicio_id = ep.id
                       WHERE ta.alumno_id = ? AND ta.fecha_limite_entrega IS NOT NULL");
$stmt->execute([$alumno_id]);
foreach ($stmt->fetchAll() as $tarea) {
    $eventos[] = [
        'title' => 'Entrega: ' . mb_strimwidth($tarea['enunciado'], 0, 30, '...'),
        'start' => $tarea['fecha_limite_entrega'],
        'color' => '#1d3557',
    ];
}

echo json_encode($eventos);