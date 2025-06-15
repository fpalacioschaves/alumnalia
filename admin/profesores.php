<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once '../includes/header.php';

redirigir_si_no_autenticado();
solo_admin();

// Obtener todos los profesores con su usuario asociado
$stmt = $pdo->query("SELECT u.id, u.nombre, u.apellido, u.email, p.departamento 
                     FROM profesores p
                     JOIN usuarios u ON p.id = u.id
                     ORDER BY u.nombre");
$profesores = $stmt->fetchAll();
?>


    <h1 class="mt-4">Gestión de Profesores</h1>
    <a href="profesor_nuevo.php" class="btn btn-success mb-3">
        <i class="bi bi-person-plus"></i> Añadir profesor
    </a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Departamento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($profesores as $prof): ?>
            <tr>
                <td><?= htmlspecialchars($prof['nombre'] . ' ' . $prof['apellido']) ?></td>
                <td><?= htmlspecialchars($prof['email']) ?></td>
                <td><?= htmlspecialchars($prof['departamento']) ?></td>
                <td>
                    <a href="profesor_editar.php?id=<?= $prof['id'] ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="profesor_eliminar.php?id=<?= $prof['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este profesor?');">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php require_once '../includes/footer.php'; ?>

</body>
</html>
