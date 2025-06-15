<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$respuesta_id = $_GET['id'] ?? null;
$ejercicio_id = $_GET['ejercicio_id'] ?? null;

if (!$respuesta_id || !$ejercicio_id || !is_numeric($respuesta_id) || !is_numeric($ejercicio_id)) {
    header("Location: examenes.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM respuestas WHERE id = ?");
    $stmt->execute([$respuesta_id]);

    header("Location: respuestas.php?ejercicio_id=" . $ejercicio_id);
    exit;
} catch (Exception $e) {
    die("Error al eliminar la respuesta: " . $e->getMessage());
}
