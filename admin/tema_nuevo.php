<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$mensaje = '';
$asignaturas = $pdo->query("SELECT id, nombre FROM asignaturas ORDER BY nombre")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $asignatura_id = $_POST['asignatura_id'] ?? null;

    if ($nombre && $asignatura_id) {
        try {
            $stmt = $pdo->prepare("INSERT INTO temas (nombre, asignatura_id) VALUES (?, ?)");
            $stmt->execute([$nombre, $asignatura_id]);
            header("Location: temas.php");
            exit;
        } catch (PDOException $e) {
            $mensaje = "Error: el tema ya existe para esa asignatura.";
        }
    } else {
        $mensaje = "Todos los campos son obligatorios.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Nuevo Tema</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>

<form method="POST" class="mt-3">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre del tema:</label>
        <input type="text" name="nombre" id="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="asignatura_id" class="form-label">Asignatura:</label>
        <select name="asignatura_id" id="asignatura_id" class="form-select" required>
            <option value="">Selecciona asignatura</option>
            <?php foreach ($asignaturas as $a): ?>
                <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="btn btn-primary">Guardar</button>
    <a href="temas.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
