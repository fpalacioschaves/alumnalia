<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

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
$stmt = $pdo->prepare("SELECT pregunta_id FROM banco_preguntas_en_examen WHERE  pregunta_id = ? AND examen_id = ?");
$stmt->execute([$ejercicio_id, $examen_id]);
$existe = $stmt->fetchColumn();

if ($existe) {
    // Actualizar nota
    $stmt = $pdo->prepare("UPDATE banco_preguntas_en_examen SET puntuacion = ? WHERE pregunta_id = ? AND examen_id = ?");
    $stmt->execute([$nota, $ejercicio_id, $examen_id]);
} else {
    // Insertar nueva resolución
    $stmt = $pdo->prepare("INSERT INTO banco_preguntas_en_examen (examen_id, pregunta_id, puntuacion) VALUES (?, ?, ?)");
    $stmt->execute([$$examen_id, $ejercicio_id, $nota]);
}


// Redirigir de nuevo al panel de calificaciones
//$stmt = $pdo->prepare("SELECT examen_id FROM ejercicios WHERE id = ?");
//$stmt->execute([$ejercicio_id]);
//$examen_id = $stmt->fetchColumn();

header("Location: ejercicios.php?examen_id=" . $examen_id);
exit;
