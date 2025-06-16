<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: temas.php");
    exit;
}

// Verificar si el tema existe
$stmt = $pdo->prepare("SELECT * FROM temas WHERE id = ?");
$stmt->execute([$id]);
$tema = $stmt->fetch();

if (!$tema) {
    header("Location: temas.php");
    exit;
}

// Eliminar el tema
$stmt = $pdo->prepare("DELETE FROM temas WHERE id = ?");
$stmt->execute([$id]);

header("Location: temas.php");
exit;
