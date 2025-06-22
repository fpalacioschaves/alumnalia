<?php


require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$actividad_id = $_GET['id'] ?? null;
if (!$actividad_id || !is_numeric($actividad_id)) {
    header("Location: actividades.php");
    exit;
}

// Obtener datos de la actividad
$stmt = $pdo->prepare("
    SELECT act.*, c.nombre AS curso_nombre, a.nombre AS asignatura_nombre
    FROM actividades act
    JOIN cursos c ON act.curso_id = c.id
    JOIN asignaturas a ON act.asignatura_id = a.id
    WHERE act.id = ?
");
$stmt->execute([$actividad_id]);
$actividad = $stmt->fetch();

if (!$actividad) {
    header("Location: actividades.php");
    exit;
}

// Obtener alumnos del curso
$stmt = $pdo->prepare("
    SELECT u.id, u.nombre, u.apellido
    FROM alumnos al
    JOIN usuarios u ON al.id = u.id
    WHERE al.curso_id = ?
    ORDER BY u.apellido, u.nombre
");
$stmt->execute([$actividad['curso_id']]);
$alumnos = $stmt->fetchAll();

// Obtener calificaciones existentes
$stmt = $pdo->prepare("
    SELECT alumno_id, nota
    FROM actividades_alumnos
    WHERE actividad_id = ?
");
$stmt->execute([$actividad_id]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$notas = [];
foreach ($rows as $row) {
    $notas[$row['alumno_id']] = $row['nota'];
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Calificar Actividad: <?= htmlspecialchars($actividad['titulo']) ?> (<?= htmlspecialchars($actividad['curso_nombre']) ?> - <?= htmlspecialchars($actividad['asignatura_nombre']) ?>)</h2>

<form method="POST" action="procesar_calificaciones_actividad.php" class="mt-4">
    <input type="hidden" name="actividad_id" value="<?= $actividad_id ?>">

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Alumno</th>
                <th>Nota (0-10)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alumnos as $al): ?>
            <tr>
                <td><?= htmlspecialchars($al['apellido'] . ', ' . $al['nombre']) ?></td>
                <td>
                    <input type="number" name="notas[<?= $al['id'] ?>]" value="<?= $notas[$al['id']] ?? '' ?>" min="0" max="10" step="0.1" class="form-control form-control-sm">
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Guardar calificaciones
    </button>
    <a href="actividades.php" class="btn btn-secondary">← Volver</a>

    <h4 class="mt-5">📊 Gráfico de notas de la actividad</h4>
    <canvas id="graficoNotasActividad" height="120"></canvas>
</form>

<?php
$labels = [];
$dataNotas = [];
$sumaNotas = 0;
foreach ($alumnos as $al) {
    $nombreCompleto = $al['apellido'] . ', ' . $al['nombre'];
    $labels[] = $nombreCompleto;
    $nota = $notas[$al['id']] ?? null;
    if ($nota !== null) {
        $dataNotas[] = $nota;
        $sumaNotas += $nota;
    } else {
        $dataNotas[] = null;
    }
}
$media = count(array_filter($dataNotas, fn($n) => $n !== null)) > 0 ? round($sumaNotas / count(array_filter($dataNotas, fn($n) => $n !== null)), 2) : 0;
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('graficoNotasActividad').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [
                {
                    label: 'Nota del alumno',
                    data: <?= json_encode($dataNotas) ?>,
                    backgroundColor: '#1d3557'
                },
                {
                    label: 'Nota media de la clase',
                    data: Array(<?= count($dataNotas) ?>).fill(<?= $media ?>),
                    backgroundColor: 'rgba(230, 57, 70, 0.3)',
                    type: 'line',
                    borderColor: '#e63946',
                    borderWidth: 2,
                    fill: false
                }
            ]
        },
        options: {
            scales: {
                y: { beginAtZero: true, max: 10 }
            }
        }
    });
});
</script>

<?php require_once '../includes/footer.php'; ?>
