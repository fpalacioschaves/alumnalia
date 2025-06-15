<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$examen_id = $_GET['id'] ?? null;

if (!$examen_id || !is_numeric($examen_id)) {
    header("Location: examenes.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM examenes WHERE id = ?");
    $stmt->execute([$examen_id]);

    header("Location: examenes.php?eliminado=1");
    exit;
} catch (Exception $e) {
    die("Error al eliminar el examen: " . $e->getMessage());
}
