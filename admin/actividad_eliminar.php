<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$actividad_id = $_GET['id'] ?? null;

if (!$actividad_id || !is_numeric($actividad_id)) {
    header("Location: actividades.php");
    exit;
}

// Eliminar la actividad
$stmt = $pdo->prepare("DELETE FROM actividades WHERE id = ?");
$stmt->execute([$actividad_id]);

header("Location: actividades.php?eliminado=1");
exit;
?>