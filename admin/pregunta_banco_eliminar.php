<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$examen_id = $_GET['examen_id'] ?? null;
$pregunta_id = $_GET['pregunta_id'] ?? null;

if (!$examen_id || !$pregunta_id) {
    header('Location: examenes.php');
    exit;
}

$stmt = $pdo->prepare("DELETE FROM banco_preguntas_en_examen WHERE examen_id = ? AND pregunta_id = ?");
$stmt->execute([$examen_id, $pregunta_id]);

header("Location: ejercicios.php?examen_id=$examen_id");
exit;