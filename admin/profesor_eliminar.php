<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$profesor_id = $_GET['id'] ?? null;

if (!$profesor_id || !is_numeric($profesor_id)) {
    header("Location: profesores.php");
    exit;
}

try {
    // Iniciar transacción para garantizar integridad
    $pdo->beginTransaction();

    // Eliminar asignaciones
    $stmt = $pdo->prepare("DELETE FROM profesor_asignatura WHERE profesor_id = ?");
    $stmt->execute([$profesor_id]);

    // Eliminar profesor
    $stmt = $pdo->prepare("DELETE FROM profesores WHERE id = ?");
    $stmt->execute([$profesor_id]);

    // Eliminar usuario
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$profesor_id]);

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    die("Error al eliminar profesor: " . $e->getMessage());
}

header("Location: profesores.php");
exit;
