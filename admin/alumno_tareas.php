<?php
require_once '../includes/Parsedown.php';
$Parsedown = new Parsedown();


require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();



require_once '../includes/header.php';

$alumno_id = $_GET['id'] ?? null;
if (!$alumno_id || !is_numeric($alumno_id)) {
    header("Location: alumnos.php");
    exit;
}

// Obtener datos del alumno
$stmt = $pdo->prepare("SELECT u.nombre, u.apellido FROM alumnos a JOIN usuarios u ON a.id = u.id WHERE a.id = ?");
$stmt->execute([$alumno_id]);
$alumno = $stmt->fetch();
if (!$alumno) {
    header("Location: alumnos.php");
    exit;
}

// Obtener tareas asignadas
$stmt = $pdo->prepare("
    SELECT ta.id, ep.enunciado, ta.fecha_asignacion, ta.fecha_limite_entrega
    FROM tareas_asignadas ta
    JOIN ejercicios_propuestos ep ON ta.ejercicio_id = ep.id
    WHERE ta.alumno_id = ?
    ORDER BY ta.fecha_asignacion DESC
");
$stmt->execute([$alumno_id]);
$tareas = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2 class="mb-4">Tareas asignadas a <?= htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']) ?></h2>

    <?php if ($tareas): ?>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Enunciado</th>
                    <th>Fecha asignación</th>
                    <th>Fecha límite</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tareas as $t): ?>
                    <tr class="tarea-fila" style="cursor: pointer;"
                    data-enunciado-html="<?= htmlspecialchars($Parsedown->text($t['enunciado']), ENT_QUOTES) ?>">
                        <td><?= $Parsedown->text(substr($t['enunciado'], 0, 100)) . '...'; ?></td>
                        <td><?= date('d/m/Y', strtotime($t['fecha_asignacion'])) ?></td>
                        <td>
                            <input type="date"
                                   class="form-control form-control-sm fecha-limite"
                                   value="<?= htmlspecialchars($t['fecha_limite_entrega']) ?>"
                                   data-tarea-id="<?= $t['id'] ?>"
                                   onclick="event.stopPropagation();">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Este alumno no tiene tareas asignadas actualmente.</div>
    <?php endif; ?>

    <a href="alumnos.php" class="btn btn-outline-secondary mt-4">&larr; Volver a alumnos</a>
</div>

<!-- Modal para mostrar el enunciado completo -->
<div class="modal fade" id="modalEnunciado" tabindex="-1" aria-labelledby="modalEnunciadoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEnunciadoLabel">Contenido del ejercicio</h5>
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
document.querySelectorAll('.fecha-limite').forEach(input => {
    input.addEventListener('change', function () {
        const tareaId = this.dataset.tareaId;
        const nuevaFecha = this.value;

        fetch('actualizar_fecha_limite.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${tareaId}&fecha=${nuevaFecha}`
        })
        .then(res => res.ok ? console.log("Fecha actualizada") : alert("Error al actualizar"))
        .catch(err => alert("Error de red al guardar la fecha"));
    });
});

document.querySelectorAll('.tarea-fila').forEach(row => {
    row.addEventListener('click', function () {
        const html = this.dataset.enunciadoHtml;
        document.getElementById('modalEnunciadoCuerpo').innerHTML = html;
       
        const modal = new bootstrap.Modal(document.getElementById('modalEnunciado'));
        modal.show();
    });
});
</script>

<?php require_once '../includes/footer.php'; ?>
