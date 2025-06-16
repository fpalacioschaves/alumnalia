<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: ejercicios_propuestos.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM ejercicios_propuestos WHERE id = ?");
$stmt->execute([$id]);
$ejercicio = $stmt->fetch();

if (!$ejercicio) {
    header("Location: ejercicios_propuestos.php");
    exit;
}

$temas = $pdo->query("SELECT t.id, t.nombre, a.nombre AS asignatura FROM temas t JOIN asignaturas a ON t.asignatura_id = a.id ORDER BY a.nombre, t.nombre")->fetchAll();
$etiquetas = $pdo->query("SELECT id, nombre FROM etiquetas ORDER BY nombre")->fetchAll();
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tema_id = $_POST['tema_id'] ?? null;
    $etiqueta_id = $_POST['etiqueta_id'] ?? null;
    $tipo = $_POST['tipo'] ?? 'desarrollo';
    $dificultad = $_POST['dificultad'] ?? 'media';
    $enunciado = trim($_POST['enunciado'] ?? '');
    $solucion = trim($_POST['solucion'] ?? '');

    if ($tema_id && $etiqueta_id && $enunciado) {
        $stmt = $pdo->prepare("UPDATE ejercicios_propuestos SET tema_id = ?, etiqueta_id = ?, tipo = ?, dificultad = ?, enunciado = ?, solucion = ? WHERE id = ?");
        $stmt->execute([$tema_id, $etiqueta_id, $tipo, $dificultad, $enunciado, $solucion, $id]);
        header("Location: ejercicios_propuestos.php");
        exit;
    } else {
        $mensaje = "Todos los campos obligatorios deben estar completos.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Editar Ejercicio Propuesto</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">Tema:</label>
        <select name="tema_id" class="form-select" required>
            <?php foreach ($temas as $t): ?>
                <option value="<?= $t['id'] ?>" <?= $t['id'] == $ejercicio['tema_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['asignatura'] . ' - ' . $t['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Etiqueta:</label>
        <select name="etiqueta_id" class="form-select" required>
            <?php foreach ($etiquetas as $e): ?>
                <option value="<?= $e['id'] ?>" <?= $e['id'] == $ejercicio['etiqueta_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($e['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Tipo:</label>
        <select name="tipo" class="form-select">
            <option value="desarrollo" <?= $ejercicio['tipo'] == 'desarrollo' ? 'selected' : '' ?>>Desarrollo</option>
            <option value="test" <?= $ejercicio['tipo'] == 'test' ? 'selected' : '' ?>>Test</option>
            <option value="codigo" <?= $ejercicio['tipo'] == 'codigo' ? 'selected' : '' ?>>Código</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Dificultad:</label>
        <select name="dificultad" class="form-select">
            <option value="baja" <?= $ejercicio['dificultad'] == 'baja' ? 'selected' : '' ?>>Baja</option>
            <option value="media" <?= $ejercicio['dificultad'] == 'media' ? 'selected' : '' ?>>Media</option>
            <option value="alta" <?= $ejercicio['dificultad'] == 'alta' ? 'selected' : '' ?>>Alta</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Enunciado:</label>
        <textarea name="enunciado" class="form-control" rows="4" required><?= htmlspecialchars($ejercicio['enunciado']) ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Solución (opcional):</label>
        <textarea name="solucion" class="form-control" rows="3"><?= htmlspecialchars($ejercicio['solucion']) ?></textarea>
    </div>

    <button class="btn btn-primary">Guardar cambios</button>
    <a href="ejercicios_propuestos.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
