<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$ejercicio_id = $_GET['ejercicio_id'] ?? null;
if (!$ejercicio_id || !is_numeric($ejercicio_id)) {
    header("Location: examenes.php");
    exit;
}

// Verificar que el ejercicio existe y es tipo test o multi
$stmt = $pdo->prepare("SELECT * FROM ejercicios WHERE id = ?");
$stmt->execute([$ejercicio_id]);
$ejercicio = $stmt->fetch();

if (!$ejercicio || !in_array($ejercicio['tipo'], ['test', 'multi'])) {
    header("Location: examenes.php");
    exit;
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $texto = trim($_POST['texto_respuesta'] ?? '');
    $es_correcta = isset($_POST['es_correcta']) ? 1 : 0;

    if ($texto) {
        $stmt = $pdo->prepare("INSERT INTO respuestas (ejercicio_id, texto_respuesta, es_correcta) VALUES (?, ?, ?)");
        $stmt->execute([$ejercicio_id, $texto, $es_correcta]);

        header("Location: respuestas.php?ejercicio_id=" . $ejercicio_id);
        exit;
    } else {
        $mensaje = "El texto de la respuesta es obligatorio.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Nueva respuesta para el ejercicio #<?= $ejercicio['id'] ?></h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= $mensaje ?></div>
<?php endif; ?>

<form method="POST" class="mt-4">
    <div class="mb-3">
        <label>Texto de la respuesta:</label>
        <textarea name="texto_respuesta" class="form-control" rows="2" required></textarea>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="es_correcta" id="es_correcta">
        <label class="form-check-label" for="es_correcta">Es correcta</label>
    </div>
    <button class="btn btn-primary">Guardar respuesta</button>
    <a href="respuestas.php?ejercicio_id=<?= $ejercicio_id ?>" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
