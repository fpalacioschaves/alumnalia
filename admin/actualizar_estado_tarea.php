<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$alumno_id = $_POST['alumno_id'] ?? null;
$enunciado = $_POST['enunciado'] ?? '';
$nuevo_estado = $_POST['estado'] ?? 'sin_enviar';

if (!$alumno_id || !$enunciado) {
    die("Parámetros inválidos.");
}

// Obtener ID del ejercicio por enunciado exacto (seguro si es único)
$stmt = $pdo->prepare("SELECT id FROM ejercicios WHERE enunciado = ?");
$stmt->execute([$enunciado]);
$ejercicio = $stmt->fetch();

if (!$ejercicio) {
    die("Ejercicio no encontrado.");
}

// Actualizar estado
$stmt = $pdo->prepare("
    UPDATE tareas_asignadas
    SET estado = ?
    WHERE alumno_id = ? AND ejercicio_id = ?
");
$stmt->execute([$nuevo_estado, $alumno_id, $ejercicio['id']]);

header("Location: asignacion_manual.php?alumno_id=$alumno_id");
exit;
