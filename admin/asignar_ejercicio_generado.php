<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once '../includes/Parsedown.php';
$Parsedown = new Parsedown();

redirigir_si_no_autenticado();
solo_admin();

$alumno_id = $_GET['alumno_id'] ?? $_POST['alumno_id'] ?? null;
$ejercicio_id = $_GET['ejercicio_id'] ?? $_POST['ejercicio_id'] ?? null;

if (!$alumno_id || !$ejercicio_id || !is_numeric($alumno_id) || !is_numeric($ejercicio_id)) {
    header("Location: alumnos.php");
    exit;
}

// Obtener datos del ejercicio
$stmt = $pdo->prepare("SELECT enunciado FROM ejercicios_propuestos WHERE id = ?");
$stmt->execute([$ejercicio_id]);
$ejercicio = $stmt->fetch();

// Obtener nombre del alumno
$stmt = $pdo->prepare("SELECT u.nombre, u.apellido FROM alumnos a JOIN usuarios u ON a.id = u.id WHERE a.id = ?");
$stmt->execute([$alumno_id]);
$alumno = $stmt->fetch();

if (!$ejercicio || !$alumno) {
    echo "<div class='alert alert-danger'>❌ Datos no válidos.</div>";
    exit;
}

// Procesar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fecha_limite'])) {
    $fecha_limite = $_POST['fecha_limite'] ?: null;

    // Verificar si ya estaba asignado
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tareas_asignadas WHERE alumno_id = ? AND ejercicio_id = ?");
    $stmt->execute([$alumno_id, $ejercicio_id]);
    $ya_asignado = $stmt->fetchColumn();

    if (!$ya_asignado) {
        $stmt = $pdo->prepare("
            INSERT INTO tareas_asignadas (alumno_id, ejercicio_id, estado, fecha_asignacion, fecha_limite_entrega)
            VALUES (?, ?, 'enviado', NOW(), ?)
        ");
        $stmt->execute([$alumno_id, $ejercicio_id, $fecha_limite]);

        header("Location: alumno_refuerzo.php?id=$alumno_id&asignado=1");
        exit;
    } else {
        echo "<div class='alert alert-warning text-center mt-4'>ℹ️ Este ejercicio ya está asignado a este alumno.</div>";
    }
}

require_once '../includes/header.php';
?>

<div class="container mt-4">
    <h3>Asignar ejercicio al alumno</h3>

    <p><strong>Alumno:</strong> <?= htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']) ?></p>

    <div class="card mb-4">
        <div class="card-body">
            <?= $Parsedown->text($ejercicio['enunciado']) ?>
        </div>
    </div>

    <form method="POST" class="row g-3">
        <input type="hidden" name="alumno_id" value="<?= $alumno_id ?>">
        <input type="hidden" name="ejercicio_id" value="<?= $ejercicio_id ?>">

        <div class="col-md-4">
            <label for="fecha_limite" class="form-label">Fecha límite de entrega</label>
            <input type="date" name="fecha_limite" class="form-control" required>
        </div>

        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Asignar ejercicio
            </button>
        </div>
    </form>

    <a href="alumno_refuerzo.php?id=<?= $alumno_id ?>" class="btn btn-secondary mt-4">&larr; Volver al plan de refuerzo</a>
</div>

<?php require_once '../includes/footer.php'; ?>
