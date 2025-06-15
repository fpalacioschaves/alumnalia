<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$examen_id = $_GET['examen_id'] ?? null;

if (!$examen_id || !is_numeric($examen_id)) {
    header("Location: examenes.php");
    exit;
}

// Comprobar que el examen existe
$stmt = $pdo->prepare("SELECT id, titulo FROM examenes WHERE id = ?");
$stmt->execute([$examen_id]);
$examen = $stmt->fetch();
if (!$examen) {
    header("Location: examenes.php");
    exit;
}

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
            INSERT INTO ejercicios (examen_id, enunciado, tipo, puntuacion, orden, etiqueta_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$examen_id, $enunciado, $tipo, $puntuacion, $orden, $etiqueta_id ?: null]);

        header("Location: ejercicios.php?examen_id=" . $examen_id);
        exit;
    } else {
        $mensaje = "Debes rellenar correctamente todos los campos obligatorios.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Nuevo ejercicio para: <?= htmlspecialchars($examen['titulo']) ?></h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= $mensaje ?></div>
<?php endif; ?>

<form method="POST" class="mt-4">
    <div class="mb-3">
        <label>Enunciado:</label>
        <textarea name="enunciado" class="form-control" rows="4" required></textarea>
    </div>
    <div class="mb-3">
        <label>Tipo:</label>
        <select name="tipo" class="form-select" required>
            <option value="">-- Selecciona tipo --</option>
            <option value="abierta">Abierta</option>
            <option value="test">Test (1 correcta)</option>
            <option value="multi">Multi (varias correctas)</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Puntuación:</label>
        <input type="number" name="puntuacion" class="form-control" step="0.1" min="0" value="1.0" required>
    </div>
    <div class="mb-3">
        <label>Orden:</label>
        <input type="number" name="orden" class="form-control" value="1" min="1" required>
    </div>
    <div class="mb-3">
        <label>Etiqueta:</label>
        <select name="etiqueta_id" class="form-select">
            <option value="">-- Sin etiqueta --</option>
            <?php foreach ($etiquetas as $et): ?>
                <option value="<?= $et['id'] ?>"><?= htmlspecialchars($et['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="btn btn-primary">Guardar ejercicio</button>
    <a href="ejercicios.php?examen_id=<?= $examen_id ?>" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
