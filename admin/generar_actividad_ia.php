<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once '../includes/Parsedown.php';
$Parsedown = new Parsedown();

redirigir_si_no_autenticado();
solo_admin();

// Recoger datos
$alumno_id = $_POST['alumno_id'] ?? $_GET['alumno_id'] ?? null;
$etiqueta_id = $_POST['etiqueta_id'] ?? $_GET['etiqueta_id'] ?? null;
$etiqueta_nombre = $_POST['etiqueta_nombre'] ?? $_GET['etiqueta_nombre'] ?? '';
$asignatura = $_POST['asignatura'] ?? $_GET['asignatura'] ?? '';
$tema_id = $_POST['tema_id'] ?? $_GET['tema_id'] ?? '';

if (!$alumno_id || !$etiqueta_id) {
    header("Location: alumnos.php");
    exit;
}

// Generar prompt para la IA
$prompt = "Genera una actividad de refuerzo para un alumno de Formación Profesional de Grado Superior de Desarrollo de Aplicaciones Multiplataforma y Desarrollo de Aplicaciones Web
que necesita mejorar sobre: \"$etiqueta_nombre\" de la asignatura \"$asignatura\".
Los ejercicios deben ser prácticos y breves, adecuados para un nivel de dificultad medio. No van a contener preguntas de opción múltiple ni de verdadero/falso, ni tampoco necesitará archivos adjuntos.
La actividad debe incluir un ejercicio que refuerce el conocimiento de la etiqueta $etiqueta_nombre de la asignatura $asignatura.
El ejercicio debe ser práctico y breve, enfocado a reforzar ese conocimiento.
La actividad debe incluir:
- 📌 Un enunciado claro
- No debes dar pistas ni soluciones, solo el enunciado.";

// Llamar a IA local (Ollama)
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
        // Guardar en ejercicios_propuestos
        $stmt = $pdo->prepare("
            INSERT INTO ejercicios_propuestos (enunciado, etiqueta_id, tema_id, dificultad, activo)
            VALUES (:enunciado, :etiqueta_id, :tema_id, 'media', 1)
        ");
        $stmt->execute([
            'enunciado' => $enunciado,
            'etiqueta_id' => $etiqueta_id,
            'tema_id' => $tema_id ?: null
        ]);
        $ejercicio_id = $pdo->lastInsertId();
        ?>

        <div class="card mb-4">
            <div class="card-body">
                <?= $Parsedown->text($enunciado) ?>
            </div>
        </div>

        <form method="POST" action="asignar_ejercicio_generado.php" class="d-inline">
            <input type="hidden" name="alumno_id" value="<?= $alumno_id ?>">
            <input type="hidden" name="ejercicio_id" value="<?= $ejercicio_id ?>">
            <button class="btn btn-primary">
                <i class="bi bi-check2-circle"></i> Asignar al alumno
            </button>
        </form>

        <form method="POST" action="generar_actividad_ia.php" class="d-inline">
            <input type="hidden" name="alumno_id" value="<?= $alumno_id ?>">
            <input type="hidden" name="etiqueta_id" value="<?= $etiqueta_id ?>">
            <input type="hidden" name="etiqueta_nombre" value="<?= htmlspecialchars($etiqueta_nombre) ?>">
            <input type="hidden" name="asignatura" value="<?= htmlspecialchars($asignatura) ?>">
            <input type="hidden" name="tema_id" value="<?= htmlspecialchars($tema_id) ?>">
            <button class="btn btn-outline-secondary">
                <i class="bi bi-arrow-clockwise"></i> Generar otra actividad
            </button>
        </form>

    <?php } else { ?>
        <div class="alert alert-warning">⚠️ No se pudo generar una respuesta válida desde la IA.</div>
    <?php } ?>
<?php endif; ?>
<br>
<a href="alumno_refuerzo.php?id=<?= $alumno_id ?>" class="btn btn-secondary mt-3">← Volver al plan de refuerzo</a>

<?php require_once '../includes/footer.php'; ?>
