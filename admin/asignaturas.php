<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';

// Obtener asignaturas con nombre de curso
$stmt = $pdo->query("SELECT a.id, a.nombre, a.descripcion, c.nombre AS curso
                     FROM asignaturas a
                     LEFT JOIN cursos c ON a.curso_id = c.id
                     ORDER BY c.nombre, a.nombre");
$asignaturas = $stmt->fetchAll();
?>

<h1 class="mb-4">Gestión de Asignaturas</h1>

<a href="asignatura_nueva.php" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Nueva asignatura
</a>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>Nombre</th>
            <th>Curso</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($asignaturas as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a['nombre']) ?></td>
            <td><?= htmlspecialchars($a['curso'] ?? '—') ?></td>
            <td><?= htmlspecialchars($a['descripcion']) ?></td>
            <td>
                <a href="asignatura_editar.php?id=<?= $a['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a href="asignatura_eliminar.php?id=<?= $a['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta asignatura?');">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>
