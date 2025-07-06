<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$alumno_id = $_POST['alumno_id'];
$empresa_id = $_POST['empresa_id'] ?? null;
$ra_ids = $_POST['ra_ids'] ?? [];

if (!$empresa_id) {
    die("❌ No se ha proporcionado empresa.");
}

// Eliminar RA anteriores de ese alumno y empresa
$stmt = $pdo->prepare("DELETE FROM ra_empresa_alumno WHERE alumno_id = ? AND empresa_id = ?");
$stmt->execute([$alumno_id, $empresa_id]);

// Insertar nuevos RA
$stmt = $pdo->prepare("INSERT INTO ra_empresa_alumno (alumno_id, empresa_id, ra_id) VALUES (?, ?, ?)");
foreach ($ra_ids as $ra_id) {
    $stmt->execute([$alumno_id, $empresa_id, $ra_id]);
}

header("Location: alumno_editar.php?id=" . $alumno_id);
exit;
?>
