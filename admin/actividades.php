<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';

// Obtener actividades con datos de curso y asignatura
$stmt = $pdo->query("SELECT act.id, act.titulo, act.fecha_entrega, act.ponderacion, c.nombre AS curso, a.nombre AS asignatura
                      FROM actividades act
                      JOIN cursos c ON act.curso_id = c.id
                      JOIN asignaturas a ON act.asignatura_id = a.id
                      ORDER BY act.fecha_entrega DESC");
$actividades = $stmt->fetchAll();
?>

<h1 class="mt-4">Gestión de Actividades</h1>
<a href="actividad_nueva.php" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Nueva actividad
</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Título</th>
            <th>Curso</th>
            <th>Asignatura</th>
            <th>Fecha de Entrega</th>
            <th>Ponderación</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($actividades as $act): ?>
        <tr>
            <td><?= htmlspecialchars($act['titulo']) ?></td>
            <td><?= htmlspecialchars($act['curso']) ?></td>
            <td><?= htmlspecialchars($act['asignatura']) ?></td>
            <td><?= htmlspecialchars($act['fecha_entrega']) ?></td>
            <td><?= htmlspecialchars($act['ponderacion']) ?></td>
            <td>
                <a href="actividad_editar.php?id=<?= $act['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a href="actividad_eliminar.php?id=<?= $act['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta actividad?');">
                    <i class="bi bi-trash"></i>
                </a>
                <a href="actividad_calificar.php?id=<?= $act['id'] ?>" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-clipboard-check"></i> Calificar
                </a>
                <a href="importar_notas_actividad.php?id=<?= $act['id'] ?>" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-upload"></i> Importar notas
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>