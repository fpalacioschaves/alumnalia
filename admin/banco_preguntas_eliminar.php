<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: banco_preguntas.php');
    exit;
}

// Eliminar opciones primero por integridad
$stmt = $pdo->prepare("DELETE FROM opciones_banco_pregunta WHERE pregunta_id = ?");
$stmt->execute([$id]);

// Eliminar pregunta del banco
$stmt = $pdo->prepare("DELETE FROM banco_preguntas WHERE id = ?");
$stmt->execute([$id]);

header('Location: banco_preguntas.php');
exit;
