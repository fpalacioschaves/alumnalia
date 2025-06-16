<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

require_once '../includes/header.php';

// Obtener filtros
$tema_id = $_GET['tema_id'] ?? '';
$etiqueta_id = $_GET['etiqueta_id'] ?? '';
$dificultad = $_GET['dificultad'] ?? '';

// Obtener listas para los select
$temas = $pdo->query("SELECT t.id, t.nombre, a.nombre AS asignatura FROM temas t JOIN asignaturas a ON t.asignatura_id = a.id ORDER BY a.nombre, t.nombre")->fetchAll();
$etiquetas = $pdo->query("SELECT id, nombre FROM etiquetas ORDER BY nombre")->fetchAll();

// Preparar consulta de ejercicios
$sql = "SELECT ep.*, t.nombre AS tema, e.nombre AS etiqueta
        FROM ejercicios_propuestos ep
        JOIN temas t ON ep.tema_id = t.id
        JOIN etiquetas e ON ep.etiqueta_id = e.id
        WHERE 1";
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

$sql .= " ORDER BY ep.creado_en DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$ejercicios = $stmt->fetchAll();
?>

<h2 class="mt-4">Ejercicios Propuestos</h2>
<a href="ejercicio_propuesto_nuevo.php" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Nuevo ejercicio
</a>

<form method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
        <label class="form-label">Tema</label>
        <select name="tema_id" class="form-select">
            <option value="">Todos</option>
            <?php foreach ($temas as $t): ?>
                <option value="<?= $t['id'] ?>" <?= $t['id'] == $tema_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['asignatura'] . ' - ' . $t['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Etiqueta</label>
        <select name="etiqueta_id" class="form-select">
            <option value="">Todas</option>
            <?php foreach ($etiquetas as $e): ?>
                <option value="<?= $e['id'] ?>" <?= $e['id'] == $etiqueta_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($e['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Dificultad</label>
        <select name="dificultad" class="form-select">
            <option value="">Todas</option>
            <option value="baja" <?= $dificultad == 'baja' ? 'selected' : '' ?>>Baja</option>
            <option value="media" <?= $dificultad == 'media' ? 'selected' : '' ?>>Media</option>
            <option value="alta" <?= $dificultad == 'alta' ? 'selected' : '' ?>>Alta</option>
        </select>
    </div>
    <div class="col-md-1 d-flex align-items-end">
        <button class="btn btn-primary w-100"><i class="bi bi-filter"></i></button>
    </div>
</form>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>Tema</th>
            <th>Etiqueta</th>
            <th>Tipo</th>
            <th>Dificultad</th>
            <th>Enunciado</th>
            <th style="width: 130px;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ejercicios as $ej): ?>
        <tr>
            <td><?= htmlspecialchars($ej['tema']) ?></td>
            <td><?= htmlspecialchars($ej['etiqueta']) ?></td>
            <td><?= ucfirst($ej['tipo']) ?></td>
            <td><?= ucfirst($ej['dificultad']) ?></td>
            <td><?= nl2br(htmlspecialchars(substr($ej['enunciado'], 0, 100))) ?>...</td>
            <td>
                <a href="ejercicio_propuesto_editar.php?id=<?= $ej['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i>
                </a>
                <a href="ejercicio_propuesto_eliminar.php?id=<?= $ej['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este ejercicio?');">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="dashboard.php" class="btn btn-secondary">← Volver al panel</a>

<?php require_once '../includes/footer.php'; ?>
