<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: banco_preguntas.php');
    exit;
}

// Obtener datos actuales
$stmt = $pdo->prepare("SELECT * FROM banco_preguntas WHERE id = ?");
$stmt->execute([$id]);
$pregunta = $stmt->fetch();

if (!$pregunta) {
    header('Location: banco_preguntas.php');
    exit;
}

$temas = $pdo->query("SELECT id, nombre FROM temas ORDER BY nombre")->fetchAll();
$etiquetas = $pdo->query("SELECT id, nombre FROM etiquetas ORDER BY nombre")->fetchAll();

// Obtener opciones
$stmt = $pdo->prepare("SELECT * FROM opciones_banco_pregunta WHERE pregunta_id = ? ORDER BY id");
$stmt->execute([$id]);
$opciones = $stmt->fetchAll();

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enunciado = $_POST['enunciado'] ?? '';
    $dificultad = $_POST['dificultad'] ?? 'media';
    $tema_id = $_POST['tema_id'] ?? null;
    $etiqueta_id = $_POST['etiqueta_id'] ?? null;
    $nuevas_opciones = $_POST['opciones'] ?? [];
    $correcta = $_POST['correcta'] ?? '';

    if ($enunciado && count($nuevas_opciones) >= 2 && $correcta !== '') {
        // Actualizar pregunta
        $stmt = $pdo->prepare("UPDATE banco_preguntas SET enunciado = ?, dificultad = ?, tema_id = ?, etiqueta_id = ? WHERE id = ?");
        $stmt->execute([$enunciado, $dificultad, $tema_id, $etiqueta_id, $id]);

        // Eliminar opciones anteriores
        $pdo->prepare("DELETE FROM opciones_banco_pregunta WHERE pregunta_id = ?")->execute([$id]);

        // Insertar nuevas opciones
        foreach ($nuevas_opciones as $i => $texto) {
            $stmt = $pdo->prepare("INSERT INTO opciones_banco_pregunta (pregunta_id, texto, es_correcta) VALUES (?, ?, ?)");
            $stmt->execute([$id, $texto, ($correcta == $i ? 1 : 0)]);
        }

        header("Location: banco_preguntas.php");
        exit;
    } else {
        $mensaje = "Debes completar el enunciado, al menos 2 opciones y marcar la correcta.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Editar Pregunta</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">Enunciado:</label>
        <textarea name="enunciado" class="form-control" required><?= htmlspecialchars($pregunta['enunciado']) ?></textarea>
    </div>

    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Dificultad:</label>
            <select name="dificultad" class="form-select">
                <option value="baja" <?= $pregunta['dificultad'] === 'baja' ? 'selected' : '' ?>>Baja</option>
                <option value="media" <?= $pregunta['dificultad'] === 'media' ? 'selected' : '' ?>>Media</option>
                <option value="alta" <?= $pregunta['dificultad'] === 'alta' ? 'selected' : '' ?>>Alta</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tema:</label>
            <select name="tema_id" class="form-select">
                <option value="">Ninguno</option>
                <?php foreach ($temas as $t): ?>
                    <option value="<?= $t['id'] ?>" <?= $pregunta['tema_id'] == $t['id'] ? 'selected' : '' ?>><?= htmlspecialchars($t['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Etiqueta:</label>
            <select name="etiqueta_id" class="form-select">
                <option value="">Ninguna</option>
                <?php foreach ($etiquetas as $e): ?>
                    <option value="<?= $e['id'] ?>" <?= $pregunta['etiqueta_id'] == $e['id'] ? 'selected' : '' ?>><?= htmlspecialchars($e['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <hr>
    <h5>Opciones de respuesta</h5>
    <?php foreach ($opciones as $i => $op): ?>
        <div class="input-group mb-2">
            <div class="input-group-text">
                <input class="form-check-input mt-0" type="radio" name="correcta" value="<?= $i ?>" <?= $op['es_correcta'] ? 'checked' : '' ?>>
            </div>
            <input type="text" class="form-control" name="opciones[]" value="<?= htmlspecialchars($op['texto']) ?>">
        </div>
    <?php endforeach; ?>

    <button class="btn btn-success mt-3">
        <i class="bi bi-check-circle"></i> Guardar Cambios
    </button>
    <a href="banco_preguntas.php" class="btn btn-secondary mt-3">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
