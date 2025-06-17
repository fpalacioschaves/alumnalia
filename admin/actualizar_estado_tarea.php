<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();
var_dump($_POST);

$tarea_id = $_POST['tarea_id'] ?? null;
$alumno_id = $_POST['alumno_id'] ?? null;
$estado = $_POST['estado'] ?? null;
$enunciado = $_POST['enunciado'] ?? null;
$fecha_limite_entrega = $_POST['fecha_limite_entrega'] ?? null;


if (!$alumno_id || !$enunciado) {
    die("Parámetros inválidos.");
}

// Buscar el ejercicio en ejercicios_propuestos
$stmt = $pdo->prepare("SELECT id FROM ejercicios_propuestos WHERE enunciado = ?");
$stmt->execute([$enunciado]);
$ejercicio = $stmt->fetch();

if (!$ejercicio) {
    die("Ejercicio no encontrado.");
}

// Actualizar estado
$stmt = $pdo->prepare("UPDATE tareas_asignadas SET estado = ?, fecha_limite_entrega = ? WHERE id = ? AND alumno_id = ?");
$stmt->execute([$estado, $fecha_limite_entrega, $tarea_id, $alumno_id]);

header("Location: asignacion_manual.php?alumno_id=$alumno_id");
exit;
