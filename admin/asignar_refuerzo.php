<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$alumno_id = $_POST['alumno_id'] ?? null;
$ejercicio_id = $_POST['ejercicio_id'] ?? null;

if (!$alumno_id || !$ejercicio_id || !is_numeric($alumno_id) || !is_numeric($ejercicio_id)) {
    header("Location: alumnos.php");
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT IGNORE INTO tareas_asignadas (alumno_id, ejercicio_id)
        VALUES (?, ?)
    ");
    $stmt->execute([$alumno_id, $ejercicio_id]);

    header("Location: alumno_refuerzo.php?id=" . $alumno_id);
    exit;
} catch (PDOException $e) {
    die("Error al asignar ejercicio: " . $e->getMessage());
}
