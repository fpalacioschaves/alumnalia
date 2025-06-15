<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');

    if ($nombre) {
        // Comprobar duplicado
        $stmt = $pdo->prepare("SELECT id FROM cursos WHERE nombre = ?");
        $stmt->execute([$nombre]);
        if ($stmt->fetch()) {
            $mensaje = "Ya existe un curso con ese nombre.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO cursos (nombre, descripcion) VALUES (?, ?)");
            $stmt->execute([$nombre, $descripcion]);
            header("Location: cursos.php");
            exit;
        }
    } else {
        $mensaje = "El nombre del curso es obligatorio.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Nuevo Curso</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= $mensaje ?></div>
<?php endif; ?>

<form method="POST" class="mt-4">
    <div class="mb-3">
        <label>Nombre:</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Descripción:</label>
        <textarea name="descripcion" class="form-control" rows="3"></textarea>
    </div>
    <button class="btn btn-primary">Guardar</button>
    <a href="cursos.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
