<?php
session_start();
require_once '../includes/db.php';
require_once 'header.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'alumno') {
    //  header('Location: index.php');
      exit;
  }

$alumno_id = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("
    SELECT ex.titulo AS examen, ex.fecha, ROUND(SUM(r.puntuacion_obtenida), 2) AS nota_total
    FROM resoluciones r
    JOIN ejercicios e ON r.ejercicio_id = e.id
    JOIN examenes ex ON e.examen_id = ex.id
    WHERE r.alumno_id = ?
    GROUP BY ex.id, ex.titulo, ex.fecha
    ORDER BY ex.fecha DESC
");
$stmt->execute([$alumno_id]);
$examenes = $stmt->fetchAll();
?>
<div class="container mt-4">
<h2 class="mb-4">Resultados de Exámenes</h2>

<?php if ($examenes): ?>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Examen</th>
                <th>Fecha</th>
                <th>Nota media</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($examenes as $ex): ?>
                <tr>
                    <td><?= htmlspecialchars($ex['examen']) ?></td>
                    <td><?= htmlspecialchars($ex['fecha']) ?></td>
                    <td><?= htmlspecialchars($ex['nota_total']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">Aún no tienes resultados registrados.</div>
<?php endif; ?>

<a href="panel_alumno.php" class="btn btn-outline-secondary mt-4">&larr; Volver al panel</a>
</div>
<?php require_once '../includes/footer.php'; ?>
