<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$curso_id = $_GET['id'] ?? null;

if (!$curso_id || !is_numeric($curso_id)) {
    header("Location: cursos.php");
    exit;
}

// Verificar relaciones
$stmt = $pdo->prepare("SELECT COUNT(*) FROM alumnos WHERE curso_id = ?");
$stmt->execute([$curso_id]);
$alumnos_count = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM asignaturas WHERE curso_id = ?");
$stmt->execute([$curso_id]);
$asignaturas_count = $stmt->fetchColumn();

if ($alumnos_count > 0 || $asignaturas_count > 0) {
    // No se puede eliminar si hay alumnos o asignaturas
    header("Location: cursos.php?error=relaciones");
    exit;
}

// Eliminar curso
$stmt = $pdo->prepare("DELETE FROM cursos WHERE id = ?");
$stmt->execute([$curso_id]);

header("Location: cursos.php?eliminado=1");
exit;
