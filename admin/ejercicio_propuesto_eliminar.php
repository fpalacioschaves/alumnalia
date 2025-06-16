<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    header("Location: ejercicios_propuestos.php");
    exit;
}

// Verificar si el ejercicio existe
$stmt = $pdo->prepare("SELECT id FROM ejercicios_propuestos WHERE id = ?");
$stmt->execute([$id]);
$ejercicio = $stmt->fetch();

if (!$ejercicio) {
    header("Location: ejercicios_propuestos.php");
    exit;
}

// Eliminar el ejercicio
$stmt = $pdo->prepare("DELETE FROM ejercicios_propuestos WHERE id = ?");
$stmt->execute([$id]);

header("Location: ejercicios_propuestos.php");
exit;
