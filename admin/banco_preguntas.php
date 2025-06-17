<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$stmt = $pdo->query("SELECT bp.*, t.nombre AS tema, e.nombre AS etiqueta
                     FROM banco_preguntas bp
                     LEFT JOIN temas t ON bp.tema_id = t.id
                     LEFT JOIN etiquetas e ON bp.etiqueta_id = e.id
                     ORDER BY bp.id DESC");
$preguntas = $stmt->fetchAll();

require_once '../includes/header.php';
?>

<h2 class="mt-4">Banco de Preguntas</h2>
<a href="banco_pregunta_nueva.php" class="btn btn-primary mb-3">
    <i class="bi bi-plus-circle"></i> Nueva Pregunta
</a>

<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Enunciado</th>
            <th>Dificultad</th>
            <th>Tema</th>
            <th>Etiqueta</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($preguntas as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['enunciado']) ?></td>
                <td><?= ucfirst($p['dificultad']) ?></td>
                <td><?= htmlspecialchars($p['tema'] ?? '-') ?></td>
                <td><?= htmlspecialchars($p['etiqueta'] ?? '-') ?></td>
                <td>
                    <a href="banco_pregunta_editar.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a href="banco_pregunta_eliminar.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Eliminar esta pregunta?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="dashboard.php" class="btn btn-secondary mt-4">← Volver al panel</a>

<?php require_once '../includes/footer.php'; ?>
