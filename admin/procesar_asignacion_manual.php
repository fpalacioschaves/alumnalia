<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();


// Recogida de datos del formulario
$alumnos = $_POST['alumnos'] ?? [];
$ejercicios = $_POST['ejercicios'] ?? [];

if (empty($alumnos) || empty($ejercicios)) {
    die("No se han seleccionado alumnos o ejercicios.");
}

foreach ($alumnos as $alumno_id) {
    foreach ($ejercicios as $ejercicio_id) {

        // Verificar si ya está asignado
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tareas_asignadas WHERE alumno_id = ? AND ejercicio_id = ?");
        $stmt->execute([$alumno_id, $ejercicio_id]);

        if ($stmt->fetchColumn() == 0) {
            // Insertar nueva tarea
            $stmt = $pdo->prepare("INSERT INTO tareas_asignadas (alumno_id, ejercicio_id, estado, fecha_asignacion) VALUES (?, ?, 'sin_enviar', NOW())");
            $stmt->execute([$alumno_id, $ejercicio_id]);
        }
    }
}

// Redirigir de vuelta con mensaje de éxito
header("Location: asignacion_manual.php?alumno_id=" . $alumnos[0] . "&success=1");
exit;
