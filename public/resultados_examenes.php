<?php
session_start();
require_once '../includes/db.php';
require_once 'header.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'alumno') {
    exit;
}

$alumno_id = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("
    SELECT 
        ex.id,
        ex.titulo AS examen,
        ex.fecha,
        ROUND(
            CASE 
                WHEN ne.nota_total IS NOT NULL THEN ne.nota_total
                ELSE IFNULL(suma_resoluciones.total, 0)
            END
        , 2) AS nota_total
    FROM examenes ex
    LEFT JOIN (
        SELECT 
            e.examen_id,
            SUM(r.puntuacion_obtenida) +
            IFNULL((
                SELECT SUM(rbp.puntuacion_obtenida)
                FROM banco_preguntas_en_examen bpe
                JOIN resoluciones_banco_preguntas rbp ON bpe.pregunta_id = rbp.ejercicio_id
                WHERE bpe.examen_id = e.examen_id AND rbp.alumno_id = :alumno_id1
            ), 0) AS total
        FROM ejercicios e
        JOIN resoluciones r ON e.id = r.ejercicio_id
        WHERE r.alumno_id = :alumno_id2
        GROUP BY e.examen_id
    ) AS suma_resoluciones ON ex.id = suma_resoluciones.examen_id
    LEFT JOIN notas_examen_alumno ne 
        ON ex.id = ne.examen_id AND ne.alumno_id = :alumno_id3
    ORDER BY ex.fecha DESC
");

$stmt->execute([
    'alumno_id1' => $alumno_id,
    'alumno_id2' => $alumno_id,
    'alumno_id3' => $alumno_id
]);

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
                    <th>Nota total</th>
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
