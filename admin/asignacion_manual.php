<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$etiquetas = $pdo->query("SELECT id, nombre FROM etiquetas ORDER BY nombre")->fetchAll();
$cursos = $pdo->query("SELECT id, nombre FROM cursos ORDER BY nombre")->fetchAll();

$etiqueta_id = $_GET['etiqueta_id'] ?? null;
$curso_id = $_GET['curso_id'] ?? null;
$alumno_id_directo = $_GET['alumno_id'] ?? null;

$ejercicios = [];
$alumnos = [];
$ejercicios_asignados = [];

$ejercicios_ya_asignados = [];
if ($alumno_id_directo && $etiqueta_id) {
    $stmt = $pdo->prepare("
        SELECT ejercicio_id FROM tareas_asignadas ta
        JOIN ejercicios e ON ta.ejercicio_id = e.id
        WHERE ta.alumno_id = ? AND e.etiqueta_id = ?
    ");
    $stmt->execute([$alumno_id_directo, $etiqueta_id]);
    $ejercicios_ya_asignados = array_column($stmt->fetchAll(), 'ejercicio_id');
}

if ($etiqueta_id) {
    $sql = "SELECT * FROM ejercicios WHERE etiqueta_id = ?";
    if ($alumno_id_directo && $ejercicios_ya_asignados) {
        $placeholders = rtrim(str_repeat('?,', count($ejercicios_ya_asignados)), ',');
        $sql .= " AND id NOT IN ($placeholders)";
        $params = array_merge([$etiqueta_id], $ejercicios_ya_asignados);
    } else {
        $params = [$etiqueta_id];
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $ejercicios = $stmt->fetchAll();
}

if ($alumno_id_directo) {
    $stmt = $pdo->prepare("SELECT u.id, u.nombre, u.apellido FROM usuarios u WHERE u.id = ?");
    $stmt->execute([$alumno_id_directo]);
    $alumnos = $stmt->fetchAll();
} elseif ($curso_id) {
    $stmt = $pdo->prepare("
        SELECT u.id, u.nombre, u.apellido
        FROM alumnos a
        JOIN usuarios u ON a.id = u.id
        WHERE a.curso_id = ?
        ORDER BY u.apellido, u.nombre
    ");
    $stmt->execute([$curso_id]);
    $alumnos = $stmt->fetchAll();
}

if ($alumno_id_directo) {
    $stmt = $pdo->prepare("
        SELECT ta.estado, e.enunciado, et.nombre AS etiqueta
        FROM tareas_asignadas ta
        JOIN ejercicios e ON ta.ejercicio_id = e.id
        LEFT JOIN etiquetas et ON e.etiqueta_id = et.id
        WHERE ta.alumno_id = ?
        ORDER BY et.nombre, e.enunciado
    ");
    $stmt->execute([$alumno_id_directo]);
    $ejercicios_asignados = $stmt->fetchAll();
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Asignación manual de ejercicios</h2>

<?php if (!empty($ejercicios_asignados)): ?>
    <h4 class="mt-5">Ejercicios ya asignados al alumno</h4>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Etiqueta</th>
                <th>Enunciado</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ejercicios_asignados as $asig): ?>
                <tr>
                    <td><?= htmlspecialchars($asig['etiqueta'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($asig['enunciado']) ?></td>
                    <td>
                        <form method="POST" action="actualizar_estado_tarea.php" class="d-flex align-items-center gap-2">
                            <input type="hidden" name="alumno_id" value="<?= $alumno_id_directo ?>">
                            <input type="hidden" name="enunciado" value="<?= htmlspecialchars($asig['enunciado']) ?>">
                            <select name="estado" class="form-select form-select-sm">
                                <option value="sin_enviar" <?= $asig['estado'] === 'sin_enviar' ? 'selected' : '' ?>>Sin enviar</option>
                                <option value="enviado" <?= $asig['estado'] === 'enviado' ? 'selected' : '' ?>>Enviado</option>
                                <option value="resuelto" <?= $asig['estado'] === 'resuelto' ? 'selected' : '' ?>>Resuelto</option>
                            </select>
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
