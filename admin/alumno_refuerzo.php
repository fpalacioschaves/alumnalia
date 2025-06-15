<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$alumno_id = $_GET['id'] ?? null;
if (!$alumno_id || !is_numeric($alumno_id)) {
    header("Location: alumnos.php");
    exit;
}

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

// Obtener rendimiento medio por etiqueta
$stmt = $pdo->prepare("
    SELECT et.id, et.nombre,
           COUNT(r.id) AS total_ejercicios,
           AVG(r.puntuacion_obtenida) AS media
    FROM resoluciones r
    JOIN ejercicios e ON r.ejercicio_id = e.id
    JOIN etiquetas et ON e.etiqueta_id = et.id
    WHERE r.alumno_id = ?
      AND e.etiqueta_id IS NOT NULL
    GROUP BY et.id, et.nombre
    HAVING COUNT(r.id) >= 3 AND AVG(r.puntuacion_obtenida) < 0.6
    ORDER BY media ASC
");
$stmt->execute([$alumno_id]);
$debilidades = $stmt->fetchAll();

// Obtener ejercicios de refuerzo por etiqueta
$ejercicios_refuerzo = [];
foreach ($debilidades as $etiqueta) {
    $stmt = $pdo->prepare("
        SELECT e.id, e.enunciado, e.puntuacion
        FROM ejercicios e
        WHERE e.etiqueta_id = ? 
        ORDER BY RAND()
        LIMIT 3
    ");
    $stmt->execute([$etiqueta['id']]);
    $ejercicios_refuerzo[$etiqueta['id']] = $stmt->fetchAll();
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Plan de refuerzo para <?= htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']) ?></h2>
<p class="text-muted">Curso: <?= htmlspecialchars($alumno['curso']) ?></p>

<?php if (empty($debilidades)): ?>
    <div class="alert alert-success">Este alumno no presenta debilidades destacadas en este momento.</div>
<?php else: ?>
    <?php foreach ($debilidades as $et): ?>
        <div class="card mb-3">
        <div class="card-header bg-warning-subtle d-flex justify-content-between align-items-center">
    <div>
        <span class="badge bg-warning text-dark"><?= htmlspecialchars($et['nombre']) ?></span>
        <small class="text-muted ms-2">(<?= $et['total_ejercicios'] ?> ejercicios, media: <?= number_format($et['media'], 2) ?>)</small>
    </div>
</div>
            <div class="card-body">
                <?php if (!empty($ejercicios_refuerzo[$et['id']])): ?>
                    <ul class="list-group">
                        <?php foreach ($ejercicios_refuerzo[$et['id']] as $ej): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><?= htmlspecialchars($ej['enunciado']) ?> (<?= $ej['puntuacion'] ?> pt)</span>
                                <form method="POST" action="asignar_refuerzo.php" class="m-0">
                                    <input type="hidden" name="alumno_id" value="<?= $alumno_id ?>">
                                    <input type="hidden" name="ejercicio_id" value="<?= $ej['id'] ?>">
                                    <button class="btn btn-sm btn-outline-success" title="Asignar ejercicio">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                </form>
                            </li>
                                                    <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-muted">No hay ejercicios de refuerzo disponibles para esta etiqueta.</div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<a href="alumnos.php" class="btn btn-secondary">← Volver a alumnos</a>

<?php require_once '../includes/footer.php'; ?>
