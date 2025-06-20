<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$mensaje = '';

// Obtener asignaturas
$asignaturas = $pdo->query("SELECT id, nombre FROM asignaturas ORDER BY nombre")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $asignatura_id = $_POST['asignatura_id'] ?? null;
    $tipo = $_POST['tipo'] ?? '';
    $fecha = $_POST['fecha'] ?? null;
    $hora = $_POST['hora'] ?? null;
    $descripcion = trim($_POST['descripcion'] ?? '');

    $evaluacion = $_POST['evaluacion'] ?? 1;

    if ($titulo && $asignatura_id && $tipo && $fecha) {
        $stmt = $pdo->prepare("INSERT INTO examenes (titulo, asignatura_id, tipo, fecha, hora, descripcion, evaluacion) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $asignatura_id, $tipo, $fecha, $hora, $descripcion, $evaluacion]);
        header("Location: examenes.php");
        exit;
    } else {
        $mensaje = "Todos los campos excepto la descripción son obligatorios.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Nuevo Examen</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= $mensaje ?></div>
<?php endif; ?>

<form method="POST" class="mt-4">
    <div class="mb-3">
        <label>Título:</label>
        <input type="text" name="titulo" class="form-control" required>
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
        <label>Tipo de examen:</label>
        <select name="tipo" class="form-select" required>
            <option value="">-- Selecciona tipo --</option>
            <option value="diagnóstico">Diagnóstico</option>
            <option value="evaluación">Evaluación</option>
            <option value="recuperación">Recuperación</option>
            <option value="final">Final</option>
        </select>
    </div>
     <div class="row mb-3">
        <div class="col-md-6">
            <label>Fecha:</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Hora:</label>
            <input type="time" name="hora" class="form-control" required>
        </div>
    </div>
    <div class="mb-3">
        <label>Descripción (opcional):</label>
        <textarea name="descripcion" class="form-control" rows="3"></textarea>
    </div>



    <div class="mb-3">
        <label>Evaluación:</label>
        <select name="evaluacion" class="form-select" required>
            <option value="1">Evaluación 1</option>
            <option value="2">Evaluación 2</option>
            <option value="3">Evaluación 3</option>
        </select>
    </div>
    <button class="btn btn-primary">Guardar</button>
    <a href="examenes.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
