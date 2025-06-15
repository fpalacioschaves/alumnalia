<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: etiquetas.php");
    exit;
}

// Obtener la etiqueta actual
$stmt = $pdo->prepare("SELECT * FROM etiquetas WHERE id = ?");
$stmt->execute([$id]);
$etiqueta = $stmt->fetch();

if (!$etiqueta) {
    header("Location: etiquetas.php");
    exit;
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');

    if ($nombre) {
        try {
            $stmt = $pdo->prepare("UPDATE etiquetas SET nombre = ? WHERE id = ?");
            $stmt->execute([$nombre, $id]);
            header("Location: etiquetas.php");
            exit;
        } catch (PDOException $e) {
            $mensaje = "Error al guardar: puede que la etiqueta ya exista.";
        }
    } else {
        $mensaje = "El nombre de la etiqueta es obligatorio.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Editar etiqueta</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>

<form method="POST" class="mt-3">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($etiqueta['nombre']) ?>" required>
    </div>
    <button class="btn btn-primary">Guardar cambios</button>
    <a href="etiquetas.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
