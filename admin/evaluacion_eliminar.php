<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$evaluacion_id = $_GET['id'] ?? null;
if (!$evaluacion_id || !is_numeric($evaluacion_id)) {
    header("Location: evaluaciones.php");
    exit;
}

$stmt = $pdo->prepare("DELETE FROM evaluaciones WHERE id = ?");
$stmt->execute([$evaluacion_id]);

header("Location: evaluaciones.php?eliminado=1");
exit;
