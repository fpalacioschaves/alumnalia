<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

require_once '../includes/header.php';

// Obtener todos los temas con sus asignaturas
$stmt = $pdo->query("
    SELECT t.id, t.nombre AS tema, a.nombre AS asignatura
    FROM temas t
    JOIN asignaturas a ON t.asignatura_id = a.id
    ORDER BY a.nombre, t.nombre
");
$temas = $stmt->fetchAll();
?>

<h2 class="mt-4">Gestión de Temas</h2>

<a href="tema_nuevo.php" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Nuevo tema
</a>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>Asignatura</th>
            <th>Tema</th>
            <th style="width: 140px;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($temas as $tema): ?>
        <tr>
            <td><?= htmlspecialchars($tema['asignatura']) ?></td>
            <td><?= htmlspecialchars($tema['tema']) ?></td>
            <td>
                <a href="tema_editar.php?id=<?= $tema['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a href="tema_eliminar.php?id=<?= $tema['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este tema?');">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="dashboard.php" class="btn btn-secondary">← Volver al panel</a>

<?php require_once '../includes/footer.php'; ?>
