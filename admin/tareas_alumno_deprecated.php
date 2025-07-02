<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();

$alumno_id = $_GET['id'];  // Se asume que el alumno está autenticado

// Obtener datos del alumno
$stmt = $pdo->prepare("
    SELECT u.nombre, u.apellido, c.nombre AS curso
    FROM alumnos a
    JOIN usuarios u ON a.id = u.id
    JOIN cursos c ON a.curso_id = c.id
    WHERE a.id = ?
");
$stmt->execute([$alumno_id]);
$alumno = $stmt->fetch();
if (!$alumno) {
    header("Location: alumnos.php");
    exit;
}


// Obtener tareas asignadas
$stmt = $pdo->prepare("
    SELECT ta.id, ta.completado, ta.fecha_asignacion,
           e.enunciado, e.tipo, e.puntuacion,
           et.nombre AS etiqueta
    FROM tareas_asignadas ta
    JOIN ejercicios e ON ta.ejercicio_id = e.id
    LEFT JOIN etiquetas et ON e.etiqueta_id = et.id
    WHERE ta.alumno_id = ?
    ORDER BY ta.fecha_asignacion DESC
");
$stmt->execute([$alumno_id]);
$tareas = $stmt->fetchAll();

require_once '../includes/header.php';
?>

<h2 class="mt-4">Necesidades de refuerzo de <?= htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']) ?></h2>

<?php if (empty($tareas)): ?>
    <div class="alert alert-info">No tienes ejercicios de refuerzo asignados por ahora.</div>
<?php else: ?>
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Etiqueta</th>
                <th>Enunciado</th>
                <th>Puntos</th>
                <th>Tipo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tareas as $t): ?>
                <tr>
                    <td>
                        <?= $t['etiqueta'] ? '<span class="badge bg-secondary">' . htmlspecialchars($t['etiqueta']) . '</span>' : '—' ?>
                    </td>
                    <td><?= htmlspecialchars($t['enunciado']) ?></td>
                    <td><?= $t['puntuacion'] ?></td>
                    <td><?= ucfirst($t['tipo']) ?></td>
                    <td>
                        <?= $t['completado'] ? '<span class="badge bg-success">Completado</span>' : '<span class="badge bg-warning text-dark">Pendiente</span>' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<a href="asignacion_manual.php?alumno_id=<?= $alumno_id ?>" class="btn btn-outline-primary mt-4">
    <i class="bi bi-plus-circle"></i> Asignar ejercicios manualmente
</a>

<?php require_once '../includes/footer.php'; ?>
