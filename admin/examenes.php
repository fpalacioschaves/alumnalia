<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';

// Obtener todos los exámenes con nombre de asignatura
$stmt = $pdo->query("
    SELECT e.id, e.titulo, e.tipo, e.fecha, a.nombre AS asignatura
    FROM examenes e
    LEFT JOIN asignaturas a ON e.asignatura_id = a.id
    ORDER BY e.fecha DESC, e.titulo
");
$examenes = $stmt->fetchAll();
?>

<h1 class="mb-4">Gestión de Exámenes</h1>

<a href="examen_nuevo.php" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Nuevo examen
</a>
<?php if (isset($_GET['eliminado'])): ?>
    <div class="alert alert-success">
        Examen eliminado correctamente.
    </div>
<?php endif; ?>
<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>Título</th>
            <th>Asignatura</th>
            <th>Tipo</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($examenes as $ex): ?>
        <tr>
            <td><?= htmlspecialchars($ex['titulo']) ?></td>
            <td><?= htmlspecialchars($ex['asignatura']) ?></td>
            <td><?= htmlspecialchars($ex['tipo']) ?></td>
            <td><?= htmlspecialchars($ex['fecha']) ?></td>
            <td>
                <a href="examen_editar.php?id=<?= $ex['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a href="examen_eliminar.php?id=<?= $ex['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este examen y todos sus ejercicios?');">
                    <i class="bi bi-trash"></i>
                </a>
                <a href="ejercicios.php?examen_id=<?= $ex['id'] ?>" class="btn btn-info btn-sm">
                    <i class="bi bi-list-task"></i> Ejercicios
                </a>
                <a href="calificaciones.php?examen_id=<?= $ex['id'] ?>" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-clipboard-check"></i> Calificaciones
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>
