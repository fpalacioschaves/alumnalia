<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$examen_id = $_POST['examen_id'] ?? null;
$preguntas = $_POST['preguntas'] ?? [];

if (!$examen_id || empty($preguntas)) {
    header('Location: examenes.php');
    exit;
}

$stmt = $pdo->prepare("INSERT IGNORE INTO banco_preguntas_en_examen (examen_id, pregunta_id) VALUES (?, ?)");
foreach ($preguntas as $pregunta_id) {
    $stmt->execute([$examen_id, $pregunta_id]);
}

header("Location: examen_editar.php?id=$examen_id");
exit;