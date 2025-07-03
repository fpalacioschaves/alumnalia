<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $fecha = $_POST['fecha'] ?? null;

    if ($id && $fecha) {
        $stmt = $pdo->prepare("UPDATE tareas_asignadas SET fecha_limite_entrega = ? WHERE id = ?");
        $stmt->execute([$fecha, $id]);
    }
}
