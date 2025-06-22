<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';

// Obtener todas las evaluaciones
$evaluaciones = $pdo->query("SELECT ev.*, c.nombre AS curso_nombre, a.nombre AS asignatura_nombre FROM evaluaciones ev JOIN cursos c ON ev.curso_id = c.id JOIN asignaturas a ON ev.asignatura_id = a.id ORDER BY c.nombre, a.nombre, ev.numero_evaluacion")->fetchAll();
?>

<h1 class="mt-4">Gestión de Evaluaciones</h1>

<a href="evaluacion_nueva.php" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Nueva evaluación
</a>

<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>Curso</th>
            <th>Asignatura</th>
            <th>Evaluación</th>
            <th>Pond. Exámenes</th>
            <th>Pond. Actividades</th>
            <th>Pond. Asistencia</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($evaluaciones as $ev): ?>
        <tr>
            <td><?= htmlspecialchars($ev['curso_nombre']) ?></td>
            <td><?= htmlspecialchars($ev['asignatura_nombre']) ?></td>
            <td><?= $ev['numero_evaluacion'] ?></td>
            <td><?= $ev['ponderacion_examenes'] ?></td>
            <td><?= $ev['ponderacion_actividades'] ?></td>
            <td><?= $ev['ponderacion_asistencia'] ?></td>
            <td>
                <a href="evaluacion_editar.php?id=<?= $ev['id'] ?>" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil-square"></i> Editar
                </a>
                <a href="evaluacion_eliminar.php?id=<?= $ev['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta evaluación?');">
                    <i class="bi bi-trash"></i>
                </a>
                <a href="evaluacion_resultados.php?evaluacion_id=<?= $ev['id'] ?>" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-bar-chart-line"></i> Ver resultados
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="importar_asistencia.php" class="btn btn-outline-primary mb-3">
  <i class="bi bi-person-check"></i> Importar asistencia
</a>

<?php require_once '../includes/footer.php'; ?>
