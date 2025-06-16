<?php
require_once '../includes/db.php';
require_once '../includes/header.php';
solo_admin();

$alumno_id = $_GET['alumno_id'] ?? null;
if (!$alumno_id) {
    echo "<div class='alert alert-danger'>Alumno no especificado.</div>";
    exit;
}

$stmt = $pdo->prepare("SELECT nombre, apellido FROM usuarios WHERE id = ?");
$stmt->execute([$alumno_id]);
$alumno = $stmt->fetch();
if (!$alumno) {
    echo "<div class='alert alert-warning'>Alumno no encontrado.</div>";
    exit;
}

// Notas de exámenes (total por examen)
$examenes = $pdo->prepare("SELECT ex.titulo AS examen, ex.fecha, SUM(r.puntuacion_obtenida) AS nota_total
    FROM resoluciones r
    JOIN ejercicios e ON r.ejercicio_id = e.id
    JOIN examenes ex ON e.examen_id = ex.id
    WHERE r.alumno_id = ?
    GROUP BY ex.id, ex.titulo, ex.fecha
    ORDER BY ex.fecha DESC");
$examenes->execute([$alumno_id]);
$por_examen = $examenes->fetchAll();

// Ejercicios propuestos desde tareas_asignadas con nota
$ejercicios = $pdo->prepare("SELECT ep.enunciado, ta.estado, ta.fecha_asignacion, r.puntuacion_obtenida
    FROM tareas_asignadas ta
    JOIN ejercicios_propuestos ep ON ta.ejercicio_id = ep.id
    LEFT JOIN resoluciones r ON r.ejercicio_id = ep.id AND r.alumno_id = ta.alumno_id
    WHERE ta.alumno_id = ?
    ORDER BY ta.fecha_asignacion DESC");
$ejercicios->execute([$alumno_id]);
$por_ejercicio = $ejercicios->fetchAll();

// Etiquetas con puntuaciones bajas (media cercana a 0) desde ejercicios normales
$etiquetas = $pdo->prepare("SELECT et.nombre AS etiqueta, ROUND(AVG(r.puntuacion_obtenida),2) AS media
    FROM resoluciones r
    JOIN ejercicios e ON r.ejercicio_id = e.id
    JOIN etiquetas et ON e.etiqueta_id = et.id
    WHERE r.alumno_id = ?
    GROUP BY et.id
    HAVING media <= 0.5
    ORDER BY media ASC");
$etiquetas->execute([$alumno_id]);
$debilidades = $etiquetas->fetchAll();
?>

<h2 class="mb-4">Informe de progreso: <?= htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']) ?></h2>

<h4>Notas por Examen</h4>
<table class="table table-sm table-bordered">
    <thead class="table-light">
        <tr><th>Examen</th><th>Fecha</th><th>Nota Total</th></tr>
    </thead>
    <tbody>
        <?php foreach ($por_examen as $fila): ?>
            <tr><td><?= $fila['examen'] ?></td><td><?= $fila['fecha'] ?></td><td><?= $fila['nota_total'] ?></td></tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h4>Ejercicios Propuestos</h4>
<table class="table table-sm table-bordered">
    <thead class="table-light">
        <tr><th>Enunciado</th><th>Estado</th><th>Fecha asignación</th><th>Nota</th></tr>
    </thead>
    <tbody>
        <?php foreach ($por_ejercicio as $fila): ?>
            <tr>
                <td><?= $fila['enunciado'] ?></td>
                <td><?= ucfirst($fila['estado']) ?></td>
                <td><?= $fila['fecha_asignacion'] ?></td>
                <td><?= $fila['puntuacion_obtenida'] !== null ? $fila['puntuacion_obtenida'] : '-' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h4>Etiquetas con resultados bajos</h4>
<table class="table table-sm table-bordered">
    <thead class="table-light">
        <tr><th>Etiqueta</th><th>Media</th></tr>
    </thead>
    <tbody>
        <?php foreach ($debilidades as $fila): ?>
            <tr><td><?= $fila['etiqueta'] ?></td><td><?= $fila['media'] ?></td></tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="alumnos.php" class="btn btn-outline-secondary mt-4">&larr; Volver a alumnos</a>

<?php require_once '../includes/footer.php'; ?>
