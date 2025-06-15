<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';

// Obtener etiquetas
$stmt = $pdo->query("SELECT id, nombre FROM etiquetas ORDER BY nombre");
$etiquetas = $stmt->fetchAll();
?>

<h2 class="mt-4">Gestión de Etiquetas</h2>

<a href="etiqueta_nueva.php" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Nueva etiqueta
</a>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>Nombre</th>
            <th style="width: 140px;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($etiquetas as $et): ?>
        <tr>
            <td><?= htmlspecialchars($et['nombre']) ?></td>
            <td>
                <a href="etiqueta_editar.php?id=<?= $et['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a href="etiqueta_eliminar.php?id=<?= $et['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta etiqueta?');">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="dashboard.php" class="btn btn-secondary">← Volver al panel</a>

<?php require_once '../includes/footer.php'; ?>
