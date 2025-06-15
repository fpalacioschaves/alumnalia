<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$asignatura_id = $_GET['id'] ?? null;

if (!$asignatura_id || !is_numeric($asignatura_id)) {
    header("Location: asignaturas.php");
    exit;
}

// Obtener datos de la asignatura
$stmt = $pdo->prepare("SELECT * FROM asignaturas WHERE id = ?");
$stmt->execute([$asignatura_id]);
$asignatura = $stmt->fetch();

if (!$asignatura) {
    header("Location: asignaturas.php");
    exit;
}

// Obtener cursos
$cursos = $pdo->query("SELECT id, nombre FROM cursos ORDER BY nombre")->fetchAll();

// Guardar cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $curso_id = $_POST['curso_id'] ?? null;
    $descripcion = $_POST['descripcion'] ?? '';

    if ($nombre && $curso_id) {
        $stmt = $pdo->prepare("UPDATE asignaturas SET nombre = ?, curso_id = ?, descripcion = ? WHERE id = ?");
        $stmt->execute([$nombre, $curso_id, $descripcion, $asignatura_id]);

        header("Location: asignaturas.php");
        exit;
    } else {
        $mensaje = "El nombre y el curso son obligatorios.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Editar Asignatura</h2>

<?php if (!empty($mensaje)): ?>
    <div class="alert alert-danger"><?= $mensaje ?></div>
<?php endif; ?>

<form method="POST" class="mt-4">
    <div class="mb-3">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($asignatura['nombre']) ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Curso:</label>
        <select name="curso_id" class="form-select" required>
            <option value="">-- Selecciona curso --</option>
            <?php foreach ($cursos as $curso): ?>
                <option value="<?= $curso['id'] ?>" <?= $curso['id'] == $asignatura['curso_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($curso['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Descripción:</label>
        <textarea name="descripcion" class="form-control" rows="3"><?= htmlspecialchars($asignatura['descripcion']) ?></textarea>
    </div>
    <button class="btn btn-primary">Guardar cambios</button>
    <a href="asignaturas.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
