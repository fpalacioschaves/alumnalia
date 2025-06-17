<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$preguntas = $_SESSION['preguntas_generadas'] ?? [];
if (empty($preguntas)) {
    header("Location: generar_examen.php");
    exit;
}

$asignaturas = $pdo->query("SELECT id, nombre FROM asignaturas ORDER BY nombre")->fetchAll();
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $asignatura_id = $_POST['asignatura_id'] ?? null;
    $tipo = $_POST['tipo'] ?? '';
    $fecha = $_POST['fecha'] ?? null;
    $hora = $_POST['hora'] ?? null;
    $descripcion = trim($_POST['descripcion'] ?? '');

    if ($titulo && $asignatura_id && $tipo && $fecha && $hora) {
        $stmt = $pdo->prepare("INSERT INTO examenes (titulo, asignatura_id, tipo, fecha, hora, descripcion) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $asignatura_id, $tipo, $fecha, $hora, $descripcion]);
        $examen_id = $pdo->lastInsertId();

        $orden = 1;
        foreach ($preguntas as $preg) {
            $stmt = $pdo->prepare("INSERT INTO banco_preguntas_en_examen (examen_id, pregunta_id) VALUES (?, ?)");
            $stmt->execute([$examen_id, $preg['id']]);

        }

        unset($_SESSION['preguntas_generadas']);
        header("Location: examenes.php?generado=1");
        exit;
    } else {
        $mensaje = "Todos los campos son obligatorios excepto la descripción.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Confirmar Generación de Examen</h2>
<p>Revise las preguntas seleccionadas aleatoriamente y complete los datos del nuevo examen.</p>

<?php if ($mensaje): ?>
  <div class="alert alert-danger"> <?= htmlspecialchars($mensaje) ?> </div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">Título del examen:</label>
        <input type="text" name="titulo" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Asignatura:</label>
        <select name="asignatura_id" class="form-select" required>
            <option value="">-- Selecciona asignatura --</option>
            <?php foreach ($asignaturas as $a): ?>
                <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Tipo:</label>
        <select name="tipo" class="form-select" required>
            <?php foreach (["diagnóstico", "evaluación", "recuperación", "final"] as $t): ?>
                <option value="<?= $t ?>"><?= ucfirst($t) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Fecha:</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Hora:</label>
            <input type="time" name="hora" class="form-control" required>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Descripción (opcional):</label>
        <textarea name="descripcion" class="form-control" rows="3"></textarea>
    </div>
    <h5>Preguntas seleccionadas:</h5>
    <ul class="list-group mb-4">
        <?php foreach ($preguntas as $preg): ?>
            <li class="list-group-item">
                <?= htmlspecialchars($preg['enunciado']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <button class="btn btn-success">
        <i class="bi bi-check-circle"></i> Confirmar y crear examen
    </button>
</form>

<?php require_once '../includes/footer.php'; ?>
