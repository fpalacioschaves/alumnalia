<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$cursos = $pdo->query("SELECT id, nombre FROM cursos ORDER BY nombre")->fetchAll();
$asignaturas = $pdo->query("SELECT id, nombre FROM asignaturas ORDER BY nombre")->fetchAll();

$curso_id = $_GET['curso_id'] ?? null;
$asignatura_id = $_GET['asignatura_id'] ?? null;
$evaluacion = $_GET['evaluacion'] ?? 1;

$alumnos = [];
$asistencias = [];

if ($curso_id && $asignatura_id) {
    // Alumnos del curso
    $stmt = $pdo->prepare("
        SELECT u.id, u.nombre, u.apellido, u.email
        FROM alumnos a
        JOIN usuarios u ON a.id = u.id
        WHERE a.curso_id = ?
        ORDER BY u.apellido, u.nombre
    ");
    $stmt->execute([$curso_id]);
    $alumnos = $stmt->fetchAll();

    // Asistencias
    $stmt = $pdo->prepare("
        SELECT alumno_id, porcentaje_asistencia
        FROM asistencia
        WHERE asignatura_id = ? AND evaluacion = ?
    ");
    $stmt->execute([$asignatura_id, $evaluacion]);
    $rows = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    $asistencias = $rows;
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">📋 Ver Asistencia por Curso y Asignatura</h2>

<form method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
        <label class="form-label">Curso:</label>
        <select name="curso_id" class="form-select" required>
            <option value="">-- Selecciona curso --</option>
            <?php foreach ($cursos as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $curso_id == $c['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Asignatura:</label>
        <select name="asignatura_id" class="form-select" required>
            <option value="">-- Selecciona asignatura --</option>
            <?php foreach ($asignaturas as $a): ?>
                <option value="<?= $a['id'] ?>" <?= $asignatura_id == $a['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($a['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2">
        <label class="form-label">Evaluación:</label>
        <select name="evaluacion" class="form-select">
            <option value="1" <?= $evaluacion == 1 ? 'selected' : '' ?>>1ª</option>
            <option value="2" <?= $evaluacion == 2 ? 'selected' : '' ?>>2ª</option>
            <option value="3" <?= $evaluacion == 3 ? 'selected' : '' ?>>3ª</option>
        </select>
    </div>
    <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-primary w-100">
            <i class="bi bi-search"></i> Ver asistencia
        </button>
    </div>
</form>

<?php if ($curso_id && $asignatura_id): ?>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Alumno</th>
                <th>Email</th>
                <th>Asistencia (%)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alumnos as $al): ?>
                <tr>
                    <td><?= htmlspecialchars($al['apellido'] . ', ' . $al['nombre']) ?></td>
                    <td><?= htmlspecialchars($al['email']) ?></td>
                    <td><?= $asistencias[$al['id']] ?? '—' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<a href="dashboard.php" class="btn btn-secondary mt-4">← Volver al panel</a>

<?php require_once '../includes/footer.php'; ?>
