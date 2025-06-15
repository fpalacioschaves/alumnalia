<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';

// Obtener lista de cursos
$stmt = $pdo->query("SELECT * FROM cursos ORDER BY nombre");
$cursos = $stmt->fetchAll();
?>

<h1 class="mb-4">Gestión de Cursos</h1>

<a href="curso_nuevo.php" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Nuevo curso
</a>
<?php if (isset($_GET['error']) && $_GET['error'] === 'relaciones'): ?>
    <div class="alert alert-warning">
        No se puede eliminar el curso porque tiene alumnos o asignaturas asociadas.
    </div>
<?php endif; ?>

<?php if (isset($_GET['eliminado'])): ?>
    <div class="alert alert-success">
        Curso eliminado correctamente.
    </div>
<?php endif; ?>
<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cursos as $curso): ?>
        <tr>
            <td><?= htmlspecialchars($curso['nombre']) ?></td>
            <td><?= htmlspecialchars($curso['descripcion']) ?></td>
            <td>
                <a href="curso_editar.php?id=<?= $curso['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a href="curso_eliminar.php?id=<?= $curso['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este curso?');">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>
