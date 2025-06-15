<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    header("Location: etiquetas.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM etiquetas WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: etiquetas.php");
    exit;
} catch (PDOException $e) {
    die("Error al eliminar la etiqueta: " . $e->getMessage());
}
