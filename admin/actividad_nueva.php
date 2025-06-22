<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

// Obtener cursos y asignaturas
$cursos = $pdo->query("SELECT id, nombre FROM cursos ORDER BY nombre")->fetchAll();
$asignaturas = $pdo->query("SELECT id, nombre FROM asignaturas ORDER BY nombre")->fetchAll();

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $curso_id = $_POST['curso_id'] ?? null;
    $asignatura_id = $_POST['asignatura_id'] ?? null;
    $fecha_entrega = $_POST['fecha_entrega'] ?? null;
    $ponderacion = $_POST['ponderacion'] ?? 1.00;
    $descripcion = trim($_POST['descripcion'] ?? '');
    $evaluacion = $_POST['evaluacion'] ?? 1;

    if ($titulo && $curso_id && $asignatura_id && $fecha_entrega && $ponderacion !== '') {
        $stmt = $pdo->prepare("INSERT INTO actividades (titulo, curso_id, asignatura_id, fecha_entrega, ponderacion, descripcion, evaluacion) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $curso_id, $asignatura_id, $fecha_entrega, $ponderacion, $descripcion, $evaluacion]);
        header("Location: actividades.php");
        exit;
    } else {
        $mensaje = "Todos los campos son obligatorios.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Nueva Actividad</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= $mensaje ?></div>
<?php endif; ?>

<form method="POST" class="mt-4">
    <div class="mb-3">
        <label>Título:</label>
        <input type="text" name="titulo" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Curso:</label>
        <select name="curso_id" class="form-select" required>
            <option value="">-- Selecciona curso --</option>
            <?php foreach ($cursos as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Asignatura:</label>
        <select name="asignatura_id" class="form-select" required>
            <option value="">-- Selecciona asignatura --</option>
            <?php foreach ($asignaturas as $a): ?>
                <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Evaluación:</label>
        <select name="evaluacion" class="form-select" required>
            <option value="1">Evaluación 1</option>
            <option value="2">Evaluación 2</option>
            <option value="3">Evaluación 3</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Fecha de entrega:</label>
        <input type="date" name="fecha_entrega" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Ponderación (entre 0 y 1):</label>
        <input type="number" name="ponderacion" step="0.01" min="0" max="1" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Descripción:</label>
        <textarea name="descripcion" class="form-control" rows="4"></textarea>
    </div>
    <button class="btn btn-primary">Guardar actividad</button>
    <a href="actividades.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
