<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

require_once '../includes/Parsedown.php';
$Parsedown = new Parsedown();

require_once '../includes/header.php';

// Obtener filtros
$tema_id = $_GET['tema_id'] ?? '';
$etiqueta_id = $_GET['etiqueta_id'] ?? '';
$dificultad = $_GET['dificultad'] ?? '';

// Obtener listas para los select
$temas = $pdo->query("
    SELECT t.id, t.nombre, a.nombre AS asignatura
    FROM temas t
    JOIN asignaturas a ON t.asignatura_id = a.id
    ORDER BY a.nombre, t.nombre
")->fetchAll();

$etiquetas = $pdo->query("SELECT id, nombre FROM etiquetas ORDER BY nombre")->fetchAll();

// Preparar consulta de ejercicios
$sql = "SELECT ep.*, t.nombre AS tema, e.nombre AS etiqueta
        FROM ejercicios_propuestos ep
        LEFT JOIN temas t ON ep.tema_id = t.id
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
        <tr class="fila-ejercicio"
            style="cursor: pointer;"
            data-enunciado="<?= htmlspecialchars($Parsedown->text($ej['enunciado']), ENT_QUOTES) ?>">
            <td><?= htmlspecialchars($ej['tema'] ?? 'Sin tema') ?></td>
            <td><?= htmlspecialchars($ej['etiqueta']) ?></td>
            <td><?= ucfirst($ej['tipo']) ?></td>
            <td><?= ucfirst($ej['dificultad']) ?></td>
            <td><?= $Parsedown->text(substr($ej['enunciado'], 0, 100)) . '...' ?></td>
            <td class="text-nowrap">
                <a href="ejercicio_propuesto_editar.php?id=<?= $ej['id'] ?>" class="btn btn-warning btn-sm" title="Editar">
                    <i class="bi bi-pencil"></i>
                </a>
                <a href="ejercicio_propuesto_eliminar.php?id=<?= $ej['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este ejercicio?');" title="Eliminar">
                    <i class="bi bi-trash"></i>
                </a>
                <a href="asignar_ejercicio.php?ejercicio_id=<?= $ej['id'] ?>" class="btn btn-outline-primary btn-sm" title="Asignar a alumno">
                    <i class="bi bi-person-plus"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal para mostrar el enunciado completo -->
<div class="modal fade" id="modalEnunciado" tabindex="-1" aria-labelledby="modalEnunciadoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEnunciadoLabel">Ejercicio completo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="modalEnunciadoCuerpo"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.fila-ejercicio').forEach(row => {
    row.addEventListener('click', function () {
        const html = this.dataset.enunciado;
        document.getElementById('modalEnunciadoCuerpo').innerHTML = html;
        const modal = new bootstrap.Modal(document.getElementById('modalEnunciado'));
        modal.show();
    });
});
</script>

<a href="dashboard.php" class="btn btn-secondary">← Volver al panel</a>

<?php require_once '../includes/footer.php'; ?>
