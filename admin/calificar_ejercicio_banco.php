<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$alumno_id = $_POST['alumno_id'] ?? null;
$ejercicio_id = $_POST['ejercicio_id'] ?? null;
$nota = $_POST['nota'] ?? null;
$examen_id = $_POST['examen_id'] ?? null;




if (
    !$alumno_id || !is_numeric($alumno_id) ||
    !$ejercicio_id || !is_numeric($ejercicio_id) ||
    $nota === null || !is_numeric($nota)
) {
   // header("Location: examenes.php");
   // exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Verificar si ya existe una resolución
$stmt = $pdo->prepare("SELECT id FROM resoluciones_banco_preguntas WHERE alumno_id = ? AND ejercicio_id = ?");
$stmt->execute([$alumno_id, $ejercicio_id]);
$existe = $stmt->fetchColumn();

if ($existe) {
    // Actualizar nota
    $stmt = $pdo->prepare("UPDATE resoluciones_banco_preguntas SET puntuacion_obtenida = ?, fecha_respuesta = CURRENT_TIMESTAMP WHERE alumno_id = ? AND ejercicio_id = ?");
    $stmt->execute([$nota, $alumno_id, $ejercicio_id]);
} else {
    // Insertar nueva resolución
    $stmt = $pdo->prepare("INSERT INTO resoluciones_banco_preguntas (alumno_id, ejercicio_id, puntuacion_obtenida) VALUES (?, ?, ?)");
    $stmt->execute([$alumno_id, $ejercicio_id, $nota]);
}

// Redirigir de nuevo al panel de calificaciones
//$stmt = $pdo->prepare("SELECT examen_id FROM ejercicios WHERE id = ?");
//$stmt->execute([$ejercicio_id]);
//$examen_id = $stmt->fetchColumn();

header("Location: calificaciones.php?examen_id=" . $examen_id);
exit;
