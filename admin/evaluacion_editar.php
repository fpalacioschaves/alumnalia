<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$evaluacion_id = $_GET['id'] ?? null;
if (!$evaluacion_id || !is_numeric($evaluacion_id)) {
    header("Location: evaluaciones.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM evaluaciones WHERE id = ?");
$stmt->execute([$evaluacion_id]);
$evaluacion = $stmt->fetch();

if (!$evaluacion) {
    header("Location: evaluaciones.php");
    exit;
}

// Obtener cursos y asignaturas
$cursos = $pdo->query("SELECT id, nombre FROM cursos ORDER BY nombre")->fetchAll();
$asignaturas = $pdo->query("SELECT id, nombre FROM asignaturas ORDER BY nombre")->fetchAll();

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $curso_id = $_POST['curso_id'] ?? null;
    $asignatura_id = $_POST['asignatura_id'] ?? null;
    $numero_evaluacion = $_POST['numero_evaluacion'] ?? null;
    $ponderacion_examenes = str_replace(',', '.', $_POST['ponderacion_examenes'] ?? '');
    $ponderacion_actividades = str_replace(',', '.', $_POST['ponderacion_actividades'] ?? '');
    $ponderacion_asistencia = str_replace(',', '.', $_POST['ponderacion_asistencia'] ?? '');

    if ($curso_id && $asignatura_id && $numero_evaluacion) {
        $stmt = $pdo->prepare("UPDATE evaluaciones SET curso_id = ?, asignatura_id = ?, numero_evaluacion = ?, ponderacion_examenes = ?, ponderacion_actividades = ?, ponderacion_asistencia = ? WHERE id = ?");
        $stmt->execute([
            $curso_id,
            $asignatura_id,
            $numero_evaluacion,
            $ponderacion_examenes,
            $ponderacion_actividades,
            $ponderacion_asistencia,
            $evaluacion_id
        ]);

        header("Location: evaluaciones.php");
        exit;
    } else {
        $mensaje = "Todos los campos son obligatorios.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Editar Evaluación</h2>
<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>

<form method="POST" class="mt-4">
    <div class="mb-3">
        <label>Curso:</label>
        <select name="curso_id" class="form-select" required>
            <option value="">-- Selecciona curso --</option>
            <?php foreach ($cursos as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $c['id'] == $evaluacion['curso_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Asignatura:</label>
        <select name="asignatura_id" class="form-select" required>
            <option value="">-- Selecciona asignatura --</option>
            <?php foreach ($asignaturas as $a): ?>
                <option value="<?= $a['id'] ?>" <?= $a['id'] == $evaluacion['asignatura_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($a['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Número de evaluación:</label>
        <select name="numero_evaluacion" class="form-select" required>
            <option value="">-- Selecciona --</option>
            <?php for ($i = 1; $i <= 3; $i++): ?>
                <option value="<?= $i ?>" <?= $i == $evaluacion['numero_evaluacion'] ? 'selected' : '' ?>>Evaluación <?= $i ?></option>
            <?php endfor; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Ponderación Exámenes (0-1):</label>
        <input type="number" step="0.01" name="ponderacion_examenes" class="form-control" value="<?= $evaluacion['ponderacion_examenes'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Ponderación Actividades (0-1):</label>
        <input type="number" step="0.01" name="ponderacion_actividades" class="form-control" value="<?= $evaluacion['ponderacion_actividades'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Ponderación Asistencia (0-1):</label>
        <input type="number" step="0.01" name="ponderacion_asistencia" class="form-control" value="<?= $evaluacion['ponderacion_asistencia'] ?>" required>
    </div>

    <button class="btn btn-primary">Guardar cambios</button>
    <a href="evaluaciones.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
