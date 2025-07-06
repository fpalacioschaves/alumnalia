<?php
require_once '../includes/Parsedown.php';
$Parsedown = new Parsedown();

$pregunta = trim($_POST['pregunta'] ?? '');

if (!$pregunta) {
    echo "<div class='alert alert-danger'>❌ La pregunta no es válida.</div>";
    exit;
}

// Prompt personalizado para el contexto educativo
$prompt = "Eres un tutor virtual para alumnos de Formación Profesional en Desarrollo de Aplicaciones.
Responde con claridad, usando ejemplos si es necesario, y adapta el lenguaje al nivel del alumno.
Evita explicaciones excesivamente técnicas.

Pregunta del alumno: \"$pregunta\"";

// Llamada al modelo local (Ollama en localhost)
$ch = curl_init('http://localhost:11434/api/generate');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode([
        "model" => "llama3",
        "prompt" => $prompt,
        "stream" => false
    ])
]);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Mostrar respuesta
if ($http_code !== 200) {
    echo "<div class='alert alert-danger'>❌ Error al contactar con la IA. ¿Está Ollama ejecutándose?</div>";
} else {
    $data = json_decode($response, true);
    $texto = trim($data['response'] ?? '');
    echo $Parsedown->text($texto ?: '⚠️ No se obtuvo una respuesta útil.');
}
