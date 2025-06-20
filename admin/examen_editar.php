<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$examen_id = $_GET['id'] ?? null;
if (!$examen_id || !is_numeric($examen_id)) {
    header("Location: examenes.php");
    exit;
}

// Obtener datos del examen
$stmt = $pdo->prepare("SELECT * FROM examenes WHERE id = ?");
$stmt->execute([$examen_id]);
$examen = $stmt->fetch();

if (!$examen) {
    header("Location: examenes.php");
    exit;
}

// Obtener asignaturas disponibles
$asignaturas = $pdo->query("SELECT id, nombre FROM asignaturas ORDER BY nombre")->fetchAll();

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $asignatura_id = $_POST['asignatura_id'] ?? null;
    $tipo = $_POST['tipo'] ?? '';
    $fecha = $_POST['fecha'] ?? null;
    $hora = $_POST['hora'] ?? null;
    $descripcion = trim($_POST['descripcion'] ?? '');
    $evaluacion = $_POST['evaluacion'] ?? 1;


    if ($titulo && $asignatura_id && $tipo && $fecha && $hora) {
        $stmt = $pdo->prepare("UPDATE examenes SET titulo = ?, asignatura_id = ?, tipo = ?, fecha = ?, hora = ?, descripcion = ?, evaluacion = ? WHERE id = ?");
        $stmt->execute([$titulo, $asignatura_id, $tipo, $fecha, $hora, $descripcion, $evaluacion, $examen_id]);
        header("Location: examenes.php");
        exit;
    } else {
        $mensaje = "Todos los campos excepto la descripción son obligatorios.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Editar Examen</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= $mensaje ?></div>
<?php endif; ?>

<form method="POST" class="mt-4">
    <div class="mb-3">
        <label>Título:</label>
        <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($examen['titulo']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Asignatura:</label>
        <select name="asignatura_id" class="form-select" required>
            <option value="">-- Selecciona asignatura --</option>
            <?php foreach ($asignaturas as $a): ?>
                <option value="<?= $a['id'] ?>" <?= $a['id'] == $examen['asignatura_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($a['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Tipo de examen:</label>
        <select name="tipo" class="form-select" required>
            <option value="">-- Selecciona tipo --</option>
            <?php foreach (['diagnóstico', 'evaluación', 'recuperación', 'final'] as $tipo): ?>
                <option value="<?= $tipo ?>" <?= $examen['tipo'] === $tipo ? 'selected' : '' ?>>
                    <?= ucfirst($tipo) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label>Fecha:</label>
            <input type="date" name="fecha" class="form-control"
                value="<?= date('Y-m-d', strtotime($examen['fecha'])) ?>" required>
        </div>
        <div class="col-md-6">
            <label>Hora:</label>
            <input type="time" name="hora" class="form-control"
                value="<?= date('H:i', strtotime($examen['hora'])) ?>">
        </div>
    </div>
        <div class="mb-3">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control" rows="3"><?= htmlspecialchars($examen['descripcion']) ?></textarea>
    </div>


<div class="mb-3">
    <label>Evaluación:</label>
    <select name="evaluacion" class="form-select" required>
        <option value="1" <?= ($examen['evaluacion'] ?? 1) == 1 ? 'selected' : '' ?>>Evaluación 1</option>
        <option value="2" <?= ($examen['evaluacion'] ?? 1) == 2 ? 'selected' : '' ?>>Evaluación 2</option>
        <option value="3" <?= ($examen['evaluacion'] ?? 1) == 3 ? 'selected' : '' ?>>Evaluación 3</option>
    </select>
</div>

    <button class="btn btn-primary">Guardar cambios</button>
    <a href="examenes.php" class="btn btn-secondary">Cancelar</a>
    <a href="ejercicios.php?examen_id=<?= $examen_id ?>" class="btn btn-info float-end">
        <i class="bi bi-list-task"></i> Ver ejercicios
    </a>
</form>

<?php require_once '../includes/footer.php'; ?>
