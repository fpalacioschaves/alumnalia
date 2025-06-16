<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$temas = $pdo->query("SELECT t.id, t.nombre, a.nombre AS asignatura FROM temas t JOIN asignaturas a ON t.asignatura_id = a.id ORDER BY a.nombre, t.nombre")->fetchAll();
$etiquetas = $pdo->query("SELECT id, nombre FROM etiquetas ORDER BY nombre")->fetchAll();
$dificultades = ['baja', 'media', 'alta'];

$tema_id = $_GET['tema_id'] ?? null;
$etiqueta_id = $_GET['etiqueta_id'] ?? null;
$dificultad = $_GET['dificultad'] ?? null;
$alumno_id = $_GET['alumno_id'] ?? null;

$ejercicios_disponibles = [];
$ejercicios_asignados = [];

// Obtener datos del alumno
$stmt = $pdo->prepare("
    SELECT u.nombre, u.apellido, c.nombre AS curso
    FROM alumnos a
    JOIN usuarios u ON a.id = u.id
    JOIN cursos c ON a.curso_id = c.id
    WHERE a.id = ?
");
$stmt->execute([$alumno_id]);
$alumno = $stmt->fetch();
if (!$alumno) {
    header("Location: alumnos.php");
    exit;
}

// Obtener datos del alumno
$stmt = $pdo->prepare("
    SELECT u.nombre, u.apellido, c.nombre AS curso
    FROM alumnos a
    JOIN usuarios u ON a.id = u.id
    JOIN cursos c ON a.curso_id = c.id
    WHERE a.id = ?
");
$stmt->execute([$alumno_id]);
$alumno = $stmt->fetch();
if (!$alumno) {
    header("Location: alumnos.php");
    exit;
}

if ($alumno_id) {
    $sql = "SELECT ep.id, ep.enunciado FROM ejercicios_propuestos ep WHERE 1";
    $params = [];

    if ($tema_id) {
        $sql .= " AND ep.tema_id = ?";
        $params[] = $tema_id;
    }
    if ($etiqueta_id) {
        $sql .= " AND ep.etiqueta_id = ?";
        $params[] = $etiqueta_id;
    }
    if ($dificultad) {
        $sql .= " AND ep.dificultad = ?";
        $params[] = $dificultad;
    }

    // excluir ejercicios ya asignados
    $sql .= " AND ep.id NOT IN (
        SELECT ejercicio_id FROM tareas_asignadas WHERE alumno_id = ?
    )";
    $params[] = $alumno_id;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $ejercicios_disponibles = $stmt->fetchAll();

    // obtener ya asignados
    $stmt = $pdo->prepare("SELECT ta.*, ep.enunciado FROM tareas_asignadas ta JOIN ejercicios_propuestos ep ON ta.ejercicio_id = ep.id WHERE ta.alumno_id = ?");
    $stmt->execute([$alumno_id]);
    $ejercicios_asignados = $stmt->fetchAll();
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Asignar Ejercicios a <?= $alumno['apellido'] ?>, <?= $alumno['nombre'] ?></h2>

<form method="GET" class="row g-3 mb-4">
    <input type="hidden" name="alumno_id" value="<?= $alumno_id ?>">

    <div class="col-md-4">
        <label class="form-label">Tema:</label>
        <select name="tema_id" class="form-select">
            <option value="">Todos</option>
            <?php foreach ($temas as $t): ?>
                <option value="<?= $t['id'] ?>" <?= $tema_id == $t['id'] ? 'selected' : '' ?>><?= htmlspecialchars($t['asignatura'] . ' - ' . $t['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Etiqueta:</label>
        <select name="etiqueta_id" class="form-select">
            <option value="">Todas</option>
            <?php foreach ($etiquetas as $e): ?>
                <option value="<?= $e['id'] ?>" <?= $etiqueta_id == $e['id'] ? 'selected' : '' ?>><?= htmlspecialchars($e['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Dificultad:</label>
        <select name="dificultad" class="form-select">
            <option value="">Todas</option>
            <?php foreach ($dificultades as $dif): ?>
                <option value="<?= $dif ?>" <?= $dificultad == $dif ? 'selected' : '' ?>><?= ucfirst($dif) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-1 d-flex align-items-end">
        <button class="btn btn-primary w-100"><i class="bi bi-search"></i></button>
    </div>
</form>

<?php if (!empty($ejercicios_disponibles)): ?>
    <form method="POST" action="procesar_asignacion_manual.php">
        <input type="hidden" name="alumnos[]" value="<?= $alumno_id ?>">

        <h5>Ejercicios disponibles</h5>
        <?php foreach ($ejercicios_disponibles as $ej): ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="ejercicios[]" value="<?= $ej['id'] ?>" id="ej<?= $ej['id'] ?>">
                <label class="form-check-label" for="ej<?= $ej['id'] ?>">
                    <?= htmlspecialchars($ej['enunciado']) ?>
                </label>
            </div>
        <?php endforeach; ?>

        <button class="btn btn-success mt-3">
            <i class="bi bi-check-circle"></i> Asignar ejercicios
        </button>
    </form>
<?php endif; ?>

<?php if (!empty($ejercicios_asignados)): ?>
    <h4 class="mt-5">Ejercicios ya asignados</h4>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Enunciado</th>
                <th>Estado</th>
                <th>Actualizar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ejercicios_asignados as $asig): ?>
                <tr>
                    <td><?= htmlspecialchars($asig['enunciado']) ?></td>
                    <td>
                        <form method="POST" action="actualizar_estado_tarea.php" class="d-flex align-items-center gap-2">
                            <input type="hidden" name="alumno_id" value="<?= $alumno_id ?>">
                            <input type="hidden" name="enunciado" value="<?= htmlspecialchars($asig['enunciado']) ?>">
                            <select name="estado" class="form-select form-select-sm">
                                <option value="sin_enviar" <?= $asig['estado'] === 'sin_enviar' ? 'selected' : '' ?>>Sin enviar</option>
                                <option value="enviado" <?= $asig['estado'] === 'enviado' ? 'selected' : '' ?>>Enviado</option>
                                <option value="resuelto" <?= $asig['estado'] === 'resuelto' ? 'selected' : '' ?>>Resuelto</option>
                            </select>
                    </td>
                    <td>
                            <button class="btn btn-sm btn-outline-primary" title="Actualizar estado">
                                <i class="bi bi-check-circle"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<a href="dashboard.php" class="btn btn-secondary mt-4">← Volver al panel</a>

<?php require_once '../includes/footer.php'; ?>
