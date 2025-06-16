<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$alumnos = $_POST['alumnos'] ?? [];
$ejercicios = $_POST['ejercicios'] ?? [];

if (empty($alumnos) || empty($ejercicios)) {
    header("Location: asignacion_manual.php?error=1");
    exit;
}

foreach ($alumnos as $alumno_id) {
    foreach ($ejercicios as $ejercicio_id) {
        // Verificar que no esté ya asignado
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tareas_asignadas WHERE alumno_id = ? AND ejercicio_id = ?");
        $stmt->execute([$alumno_id, $ejercicio_id]);
        if ($stmt->fetchColumn() == 0) {
            $stmt = $pdo->prepare("INSERT INTO tareas_asignadas (alumno_id, ejercicio_id, estado) VALUES (?, ?, 'sin_enviar')");
            $stmt->execute([$alumno_id, $ejercicio_id]);
        }
    }
}

header("Location: asignacion_manual.php?alumno_id=" . $alumnos[0] . "&success=1");
exit;
