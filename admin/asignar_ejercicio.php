<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

require_once '../includes/header.php';

$ejercicio_id = $_GET['ejercicio_id'] ?? null;
if (!$ejercicio_id || !is_numeric($ejercicio_id)) {
    header('Location: ejercicios_propuestos.php');
    exit;
}

// Obtener cursos
$cursos = $pdo->query("SELECT id, nombre FROM cursos ORDER BY nombre")->fetchAll();

// Obtener alumnos si se ha seleccionado curso
$curso_id = $_GET['curso_id'] ?? null;
$alumnos = [];
if ($curso_id && is_numeric($curso_id)) {
    $stmt = $pdo->prepare("SELECT u.id, u.nombre, u.apellido FROM alumnos a JOIN usuarios u ON a.id = u.id WHERE a.curso_id = ?");
    $stmt->execute([$curso_id]);
    $alumnos = $stmt->fetchAll();
}

// Asignar tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alumno_id = $_POST['alumno_id'] ?? null;
    $fecha_limite = $_POST['fecha_limite'] ?? null;

    // Verificar si ya está asignado
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tareas_asignadas WHERE alumno_id = ? AND ejercicio_id = ?");
    $stmt->execute([$alumno_id, $ejercicio_id]);
    $ya_asignado = $stmt->fetchColumn();

    if (!$ya_asignado) {
        $stmt = $pdo->prepare("
            INSERT INTO tareas_asignadas (alumno_id, ejercicio_id, estado, fecha_asignacion, fecha_limite_entrega)
            VALUES (?, ?, 'enviado', NOW(), ?)
        ");
        $stmt->execute([$alumno_id, $ejercicio_id, $fecha_limite ?: null]);

        echo '<div class="alert alert-success container mt-4">✅ Ejercicio asignado correctamente.</div>';
    } else {
        echo '<div class="alert alert-warning container mt-4">ℹ️ Este ejercicio ya está asignado a este alumno.</div>';
    }
}
?>

<div class="container mt-4">
    <h2>Asignar ejercicio propuesto</h2>

    <form method="GET" class="row g-3 mb-4">
        <input type="hidden" name="ejercicio_id" value="<?= $ejercicio_id ?>">
        <div class="col-md-6">
            <label class="form-label">Seleccionar curso:</label>
            <select name="curso_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Seleccionar --</option>
                <?php foreach ($cursos as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $c['id'] == $curso_id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <?php if ($curso_id && $alumnos): ?>
    <form method="POST" class="row g-3">
        <input type="hidden" name="ejercicio_id" value="<?= $ejercicio_id ?>">
        <div class="col-md-6">
            <label class="form-label">Alumno</label>
            <select name="alumno_id" class="form-select" required>
                <?php foreach ($alumnos as $a): ?>
                    <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nombre'] . ' ' . $a['apellido']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Fecha límite (opcional)</label>
            <input type="date" name="fecha_limite" class="form-control">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">Asignar</button>
        </div>
    </form>
    <?php elseif ($curso_id): ?>
        <div class="alert alert-warning mt-3">Este curso no tiene alumnos registrados.</div>
    <?php endif; ?>

    <a href="ejercicios_propuestos.php" class="btn btn-outline-secondary mt-4">&larr; Volver</a>
</div>

<?php require_once '../includes/footer.php'; ?>
