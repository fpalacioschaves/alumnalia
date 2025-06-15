<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$respuesta_id = $_GET['id'] ?? null;

if (!$respuesta_id || !is_numeric($respuesta_id)) {
    header("Location: examenes.php");
    exit;
}

// Obtener respuesta y ejercicio asociado
$stmt = $pdo->prepare("SELECT * FROM respuestas WHERE id = ?");
$stmt->execute([$respuesta_id]);
$respuesta = $stmt->fetch();

if (!$respuesta) {
    header("Location: examenes.php");
    exit;
}

$ejercicio_id = $respuesta['ejercicio_id'];

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $texto = trim($_POST['texto_respuesta'] ?? '');
    $es_correcta = isset($_POST['es_correcta']) ? 1 : 0;

    if ($texto) {
        $stmt = $pdo->prepare("UPDATE respuestas SET texto_respuesta = ?, es_correcta = ? WHERE id = ?");
        $stmt->execute([$texto, $es_correcta, $respuesta_id]);

        header("Location: respuestas.php?ejercicio_id=" . $ejercicio_id);
        exit;
    } else {
        $mensaje = "El texto de la respuesta no puede estar vacío.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Editar respuesta #<?= $respuesta['id'] ?></h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= $mensaje ?></div>
<?php endif; ?>

<form method="POST" class="mt-4">
    <div class="mb-3">
        <label>Texto de la respuesta:</label>
        <textarea name="texto_respuesta" class="form-control" rows="2" required><?= htmlspecialchars($respuesta['texto_respuesta']) ?></textarea>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="es_correcta" id="es_correcta" <?= $respuesta['es_correcta'] ? 'checked' : '' ?>>
        <label class="form-check-label" for="es_correcta">Es correcta</label>
    </div>
    <button class="btn btn-primary">Guardar cambios</button>
    <a href="respuestas.php?ejercicio_id=<?= $ejercicio_id ?>" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
