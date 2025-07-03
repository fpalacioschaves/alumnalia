<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

require_once '../includes/Parsedown.php';
$Parsedown = new Parsedown();

redirigir_si_no_autenticado();
solo_admin();

$alumno_id = $_POST['alumno_id'];
$etiqueta_id = $_POST['etiqueta_id'];
$etiqueta_nombre = $_POST['etiqueta_nombre'];
$asignatura = $_POST['asignatura'] ?? '';
$tema_id = $_POST['tema_id'] ?? '';


// Generar prompt
$prompt = "Genera una actividad de refuerzo para un alumno de Formación Profesional de Grado Superior de Desarrollo de Aplicaciones Multiplataforma y Desarrollo de Aplicaciones Web
que necesita mejorar sobre: \"$etiqueta_nombre\" de la asignatura \"$asignatura\".
Los ejercicios deben ser prácticos y breves, adecuados para un nivel de dificultad medio. No van a contener preguntas de opción múltiple ni de verdadero/falso, ni tampoco necesitará archivos adjuntos.
La actividad debe incluir un ejercicio que refuerce el conocimiento de la etiqueta $etiqueta_nombre de la asignatura $asignatura.
El ejercicio debe ser práctico y breve, enfocado a reforzar ese conocimiento.
La actividad debe incluir:
- 📌 Un enunciado claro
- No debes dar pistas ni soluciones, solo el enunciado.";

// Llamada a la IA local (Ollama)
$ch = curl_init('http://localhost:11434/api/generate');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "model" => "llama3",
    "prompt" => $prompt,
    "stream" => false
]));
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

require_once '../includes/header.php';
?>

<h3>Actividad generada con IA</h3>

<?php if ($http_code !== 200): ?>
    <div class="alert alert-danger">❌ Error al conectar con el servidor IA. ¿Está Ollama ejecutándose?</div>
<?php else: ?>
    <?php
    $data = json_decode($response, true);
    $enunciado = trim($data['response'] ?? '');

    if ($enunciado) {
        // Guardar el ejercicio en ejercicios_propuestos
        $stmt = $pdo->prepare("
            INSERT INTO ejercicios_propuestos (enunciado, etiqueta_id, tema_id, dificultad, activo)
            VALUES (:enunciado, :etiqueta_id, :tema_id, :dificultad, 1)
        ");
        $stmt->execute([
            'enunciado' => $enunciado,
            'etiqueta_id' => $etiqueta_id,
            'tema_id' => $tema_id ?: null,
            'dificultad' => 'media'
        ]);
        $ejercicio_id = $pdo->lastInsertId();

        // Comprobar si ya está asignado
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM tareas_asignadas
            WHERE alumno_id = ? AND ejercicio_id = ?
        ");
        $stmt->execute([$alumno_id, $ejercicio_id]);
        $ya_asignado = $stmt->fetchColumn();

        if (!$ya_asignado) {
            $stmt = $pdo->prepare("
                INSERT INTO tareas_asignadas (alumno_id, ejercicio_id, estado, fecha_asignacion)
                VALUES (:alumno_id, :ejercicio_id, 'enviado', NOW())
            ");
            $stmt->execute([
                'alumno_id' => $alumno_id,
                'ejercicio_id' => $ejercicio_id
            ]);
            echo '<div class="alert alert-success">✅ Actividad asignada correctamente al alumno.</div>';
        } else {
            echo '<div class="alert alert-info">ℹ️ Esta actividad ya estaba asignada a este alumno.</div>';
        }
        ?>
        <div class="card mb-4">
            <div class="card-body">
                <?= $Parsedown->text($enunciado) ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning">⚠️ No se pudo generar una respuesta válida desde la IA.</div>
    <?php } ?>
<?php endif; ?>

<a href="alumno_refuerzo.php?id=<?= $alumno_id ?>" class="btn btn-secondary">← Volver al plan de refuerzo</a>

<?php require_once '../includes/footer.php'; ?>
