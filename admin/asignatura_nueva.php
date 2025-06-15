<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$mensaje = '';

// Obtener lista de cursos
$cursos = $pdo->query("SELECT id, nombre FROM cursos ORDER BY nombre")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $curso_id = $_POST['curso_id'] ?? null;
    $descripcion = $_POST['descripcion'] ?? '';

    if ($nombre && $curso_id) {
        $stmt = $pdo->prepare("INSERT INTO asignaturas (nombre, curso_id, descripcion) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $curso_id, $descripcion]);

        header("Location: asignaturas.php");
        exit;
    } else {
        $mensaje = "El nombre y el curso son obligatorios.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Nueva Asignatura</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= $mensaje ?></div>
<?php endif; ?>

<form method="POST" class="mt-4">
    <div class="mb-3">
        <label>Nombre:</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Curso:</label>
        <select name="curso_id" class="form-select" required>
            <option value="">-- Selecciona curso --</option>
            <?php foreach ($cursos as $curso): ?>
                <option value="<?= $curso['id'] ?>"><?= htmlspecialchars($curso['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Descripción:</label>
        <textarea name="descripcion" class="form-control" rows="3"></textarea>
    </div>
    <button class="btn btn-primary">Guardar</button>
    <a href="asignaturas.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
