<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$ejercicio_id = $_GET['id'] ?? null;
if (!$ejercicio_id || !is_numeric($ejercicio_id)) {
    header("Location: examenes.php");
    exit;
}

// Obtener ejercicio actual
$stmt = $pdo->prepare("SELECT * FROM ejercicios WHERE id = ?");
$stmt->execute([$ejercicio_id]);
$ejercicio = $stmt->fetch();

if (!$ejercicio) {
    header("Location: examenes.php");
    exit;
}

$examen_id = $ejercicio['examen_id'];

// Obtener etiquetas disponibles
$etiquetas = $pdo->query("SELECT id, nombre FROM etiquetas ORDER BY nombre")->fetchAll();

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enunciado = trim($_POST['enunciado'] ?? '');
    $tipo = $_POST['tipo'] ?? '';
    $puntuacion = floatval($_POST['puntuacion'] ?? 1.0);
    $orden = intval($_POST['orden'] ?? 1);
    $etiqueta_id = $_POST['etiqueta_id'] ?? null;

    if ($enunciado && in_array($tipo, ['abierta', 'test', 'multi'])) {
        $stmt = $pdo->prepare("
            UPDATE ejercicios
            SET enunciado = ?, tipo = ?, puntuacion = ?, orden = ?, etiqueta_id = ?
            WHERE id = ?
        ");
        $stmt->execute([$enunciado, $tipo, $puntuacion, $orden, $etiqueta_id ?: null, $ejercicio_id]);

        header("Location: ejercicios.php?examen_id=" . $examen_id);
        exit;
    } else {
        $mensaje = "Todos los campos excepto la etiqueta son obligatorios.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Editar ejercicio</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= $mensaje ?></div>
<?php endif; ?>

<form method="POST" class="mt-4">
    <div class="mb-3">
        <label>Enunciado:</label>
        <textarea name="enunciado" class="form-control" rows="4" required><?= htmlspecialchars($ejercicio['enunciado']) ?></textarea>
    </div>
    <div class="mb-3">
        <label>Tipo:</label>
        <select name="tipo" class="form-select" required>
            <?php foreach (['abierta', 'test', 'multi'] as $tipo): ?>
                <option value="<?= $tipo ?>" <?= $ejercicio['tipo'] === $tipo ? 'selected' : '' ?>>
                    <?= ucfirst($tipo) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Puntuación:</label>
        <input type="number" name="puntuacion" step="0.1" min="0" value="<?= $ejercicio['puntuacion'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Orden:</label>
        <input type="number" name="orden" value="<?= $ejercicio['orden'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Etiqueta:</label>
        <select name="etiqueta_id" class="form-select">
            <option value="">-- Sin etiqueta --</option>
            <?php foreach ($etiquetas as $et): ?>
                <option value="<?= $et['id'] ?>" <?= $et['id'] == $ejercicio['etiqueta_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($et['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button class="btn btn-primary">Guardar cambios</button>
    <a href="ejercicios.php?examen_id=<?= $examen_id ?>" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
