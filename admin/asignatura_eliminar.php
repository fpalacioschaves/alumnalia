<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$asignatura_id = $_GET['id'] ?? null;

if (!$asignatura_id || !is_numeric($asignatura_id)) {
    header("Location: asignaturas.php");
    exit;
}

try {
    $pdo->beginTransaction();

    // Eliminar relaciones con profesores (si existen)
    $stmt = $pdo->prepare("DELETE FROM profesor_asignatura WHERE asignatura_id = ?");
    $stmt->execute([$asignatura_id]);

    // Eliminar de matrícula de alumnos (si se usa)
    $stmt = $pdo->prepare("DELETE FROM matricula WHERE asignatura_id = ?");
    $stmt->execute([$asignatura_id]);

    // Eliminar la asignatura
    $stmt = $pdo->prepare("DELETE FROM asignaturas WHERE id = ?");
    $stmt->execute([$asignatura_id]);

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    die("Error al eliminar asignatura: " . $e->getMessage());
}

header("Location: asignaturas.php");
exit;
