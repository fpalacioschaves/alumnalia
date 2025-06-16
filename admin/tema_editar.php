<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: temas.php");
    exit;
}

// Obtener el tema actual
$stmt = $pdo->prepare("SELECT * FROM temas WHERE id = ?");
$stmt->execute([$id]);
$tema = $stmt->fetch();

if (!$tema) {
    header("Location: temas.php");
    exit;
}

$asignaturas = $pdo->query("SELECT id, nombre FROM asignaturas ORDER BY nombre")->fetchAll();
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $asignatura_id = $_POST['asignatura_id'] ?? null;

    if ($nombre && $asignatura_id) {
        try {
            $stmt = $pdo->prepare("UPDATE temas SET nombre = ?, asignatura_id = ? WHERE id = ?");
            $stmt->execute([$nombre, $asignatura_id, $id]);
            header("Location: temas.php");
            exit;
        } catch (PDOException $e) {
            $mensaje = "Error al guardar: puede que el tema ya exista para esa asignatura.";
        }
    } else {
        $mensaje = "Todos los campos son obligatorios.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Editar Tema</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>

<form method="POST" class="mt-3">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre del tema:</label>
        <input type="text" name="nombre" id="nombre" class="form-control"
               value="<?= htmlspecialchars($tema['nombre']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="asignatura_id" class="form-label">Asignatura:</label>
        <select name="asignatura_id" id="asignatura_id" class="form-select" required>
            <?php foreach ($asignaturas as $a): ?>
                <option value="<?= $a['id'] ?>" <?= $a['id'] == $tema['asignatura_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($a['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="btn btn-primary">Guardar cambios</button>
    <a href="temas.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
