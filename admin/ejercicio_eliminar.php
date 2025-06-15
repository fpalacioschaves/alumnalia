<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$ejercicio_id = $_GET['id'] ?? null;
$examen_id = $_GET['examen_id'] ?? null;

if (!$ejercicio_id || !$examen_id || !is_numeric($ejercicio_id) || !is_numeric($examen_id)) {
    header("Location: examenes.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM ejercicios WHERE id = ?");
    $stmt->execute([$ejercicio_id]);

    header("Location: ejercicios.php?examen_id=" . $examen_id);
    exit;
} catch (Exception $e) {
    die("Error al eliminar el ejercicio: " . $e->getMessage());
}
