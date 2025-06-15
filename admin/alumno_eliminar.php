<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$alumno_id = $_GET['id'] ?? null;

if (!$alumno_id || !is_numeric($alumno_id)) {
    header("Location: alumnos.php");
    exit;
}

try {
    $pdo->beginTransaction();

    // Eliminar de alumnos
    $stmt = $pdo->prepare("DELETE FROM alumnos WHERE id = ?");
    $stmt->execute([$alumno_id]);

    // Eliminar de usuarios
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$alumno_id]);

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    die("Error al eliminar alumno: " . $e->getMessage());
}

header("Location: alumnos.php");
exit;
