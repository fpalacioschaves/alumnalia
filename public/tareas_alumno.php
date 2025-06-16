<?php
session_start();
require_once '../includes/db.php';
require_once 'header.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'alumno') {
    header('Location: index.php');
    exit;
}

$alumno_id = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("SELECT ta.id, ep.enunciado, ta.estado, ta.fecha_asignacion
    FROM tareas_asignadas ta
    JOIN ejercicios_propuestos ep ON ta.ejercicio_id = ep.id
    WHERE ta.alumno_id = ?
    ORDER BY ta.fecha_asignacion DESC");
$stmt->execute([$alumno_id]);
$tareas = $stmt->fetchAll();
?>
<div class="container mt-4">
<h2 class="mb-4">Mis Ejercicios Propuestos</h2>

<?php if ($tareas): ?>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Enunciado</th>
                <th>Estado</th>
                <th>Fecha asignación</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tareas as $t): ?>
                <tr>
                    <td><?= htmlspecialchars($t['enunciado']) ?></td>
                    <td><?= ucfirst($t['estado']) ?></td>
                    <td><?= htmlspecialchars($t['fecha_asignacion']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">No tienes ejercicios asignados actualmente.</div>
<?php endif; ?>
<a href="panel_alumno.php" class="btn btn-outline-secondary mt-4">&larr; Volver al panel</a>
</div>


<?php require_once '../includes/footer.php'; ?>
