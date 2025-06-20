<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$examen_id = $_GET['examen_id'] ?? null;
if (!$examen_id || !is_numeric($examen_id)) {
    header("Location: examenes.php");
    exit;
}

// Obtener examen y asignatura
$stmt = $pdo->prepare("
    SELECT e.*, a.curso_id
    FROM examenes e
    JOIN asignaturas a ON e.asignatura_id = a.id
    WHERE e.id = ?
");
$stmt->execute([$examen_id]);
$examen = $stmt->fetch();

if (!$examen) {
    header("Location: examenes.php");
    exit;
}

// Obtener ejercicios del examen con puntuación
$stmt = $pdo->prepare("SELECT id, enunciado, orden, puntuacion FROM ejercicios WHERE examen_id = ? ORDER BY orden");
$stmt->execute([$examen_id]);
$ejercicios = $stmt->fetchAll();

// Obtener alumnos del curso de la asignatura
$stmt = $pdo->prepare("
    SELECT u.id, u.nombre, u.apellido
    FROM alumnos al
    JOIN usuarios u ON al.id = u.id
    WHERE al.curso_id = ?
    ORDER BY u.apellido, u.nombre
");
$stmt->execute([$examen['curso_id']]);
$alumnos = $stmt->fetchAll();

// Obtener calificaciones existentes de las preguntas puestas manualmente
$stmt = $pdo->prepare("
    SELECT * FROM resoluciones
    WHERE ejercicio_id IN (
        SELECT id FROM ejercicios WHERE examen_id = ?
    )
");
$stmt->execute([$examen_id]);
$resoluciones = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_UNIQUE);

// Obtener las preguntas del banco de preguntas
$stmt = $pdo->prepare("
    SELECT * FROM banco_preguntas_en_examen
    WHERE examen_id = ?
");
$stmt->execute([$examen_id]);
$bancoPreguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
?>

<?php
$nombresAlumnos = [];
$notasAlumnos = [];
$sumaNotas = 0;
?>

<h2 class="mt-4">Calificaciones - <?= htmlspecialchars($examen['titulo']) ?></h2>
<table class="table table-bordered table-striped table-sm align-middle text-center">
    <thead class="table-light">
        <tr>
            <th>Alumno</th>
            <?php foreach ($ejercicios as $ej): ?>
                <th><?= 'Ej' . $ej['orden'] ?><br><small class="text-muted">(<?= number_format($ej['puntuacion'], 2) ?>)</small></th>
            <?php endforeach; ?>
             <?php foreach ($bancoPreguntas as $banco): ?>
                <th><?= 'Banco' . $banco['pregunta_id'] ?><br><small class="text-muted">(<?= number_format($banco['puntuacion'], 2) ?>)</small></th>
            <?php endforeach; ?>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($alumnos as $al): $nombresAlumnos[] = $al['apellido'] . ', ' . $al['nombre']; ?>
            <tr>
                <td class="text-start"><?= htmlspecialchars($al['apellido'] . ', ' . $al['nombre']) ?></td>
                <?php foreach ($ejercicios as $ej):
                    $stmt = $pdo->prepare("SELECT puntuacion_obtenida FROM resoluciones WHERE alumno_id = ? AND ejercicio_id = ?");
                    $stmt->execute([$al['id'], $ej['id']]);
                    $nota = $stmt->fetchColumn();
                ?>
                    <td>
                        <form method="POST" action="calificar_ejercicio.php" style="display:inline-block; width:60px">
                            <input type="hidden" name="alumno_id" value="<?= $al['id'] ?>">
                            <input type="hidden" name="ejercicio_id" value="<?= $ej['id'] ?>">
                            <input type="number" step="0.1" min="0" name="nota" value="<?= $nota !== false ? $nota : '' ?>" class="form-control form-control-sm text-center" onchange="this.form.submit();">
                        </form>
                    </td>
                <?php endforeach; ?>

                <?php foreach ($bancoPreguntas as $banco):
                    $stmt = $pdo->prepare("SELECT puntuacion_obtenida FROM resoluciones_banco_preguntas WHERE alumno_id = ? AND ejercicio_id = ?");
                    $stmt->execute([$al['id'], $banco['pregunta_id']]);
                    $nota = $stmt->fetchColumn();
                ?>
                    <td>
                        <form method="POST" action="calificar_ejercicio_banco.php" style="display:inline-block; width:60px">
                            <input type="hidden" name="alumno_id" value="<?= $al['id'] ?>">
                            <input type="hidden" name="examen_id" value="<?= $examen_id ?>">
                            <input type="hidden" name="ejercicio_id" value="<?= $banco['pregunta_id'] ?>">
                            <input type="number" step="0.1" min="0" name="nota" value="<?= $nota !== false ? $nota : '' ?>" class="form-control form-control-sm text-center" onchange="this.form.submit();">
                        </form>
                    </td>
                <?php endforeach; ?>

                <?php
                $stmtNota = $pdo->prepare("SELECT nota_total FROM notas_examen_alumno WHERE examen_id = ? AND alumno_id = ?");
                $stmtNota->execute([$examen_id, $al['id']]);
                $notaGuardada = $stmtNota->fetchColumn();

                if ($notaGuardada !== false) {
                    $notaTotal = number_format($notaGuardada, 2);
                } else {
                    $stmt1 = $pdo->prepare("SELECT SUM(r.puntuacion_obtenida) FROM resoluciones r JOIN ejercicios e ON r.ejercicio_id = e.id WHERE e.examen_id = ? AND r.alumno_id = ?");
                    $stmt1->execute([$examen_id, $al['id']]);
                    $notaManual = $stmt1->fetchColumn() ?? 0;

                    $stmt2 = $pdo->prepare("SELECT SUM(rb.puntuacion_obtenida) FROM resoluciones_banco_preguntas rb JOIN banco_preguntas_en_examen bpe ON rb.banco_pregunta_id = bpe.pregunta_id AND bpe.examen_id = ? WHERE rb.alumno_id = ?");
                    $stmt2->execute([$examen_id, $al['id']]);
                    $notaBanco = $stmt2->fetchColumn() ?? 0;

                    $notaTotal = number_format($notaManual + $notaBanco, 2);
                }
                $notasAlumnos[] = $notaTotal;
                $sumaNotas += $notaTotal;
                ?>
                <td class="fw-bold bg-light"><?= $notaTotal ?></td>
            </tr>
        <?php endforeach; $notaMedia = count($notasAlumnos) > 0 ? round($sumaNotas / count($notasAlumnos), 2) : 0; ?>
    </tbody>
</table>

<form method="POST" action="guardar_notas_finales.php" class="mb-3">
    <input type="hidden" name="examen_id" value="<?= $examen_id ?>">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Guardar notas finales en tabla
    </button>
</form>
<p>Advertencia: al guardar las notas finales, se eliminarán las calificaciones de ejercicios manuales y del banco de preguntas, y se guardarán las notas totales calculadas.</p>
<p>Si se han importado las notas, no es necesario guardar, ya que se guardan automáticamente al importar.</p>

<a href="examenes.php" class="btn btn-secondary">← Volver a exámenes</a>
<a href="importar_notas.php?examen_id=<?= $examen_id ?>" class="btn btn-outline-primary">
    <i class="bi bi-upload"></i> Importar calificaciones desde archivo
</a>

<h4 class="mt-5">📊 Comparativa de notas del examen</h4>
<canvas id="graficoNotasExamen" height="120"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('graficoNotasExamen').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($nombresAlumnos) ?>,
        datasets: [
            {
                label: 'Nota del alumno',
                data: <?= json_encode($notasAlumnos) ?>,
                backgroundColor: '#1d3557'
            },
            {
                label: 'Nota media del examen',
                data: Array(<?= count($notasAlumnos) ?>).fill(<?= $notaMedia ?>),
                backgroundColor: 'rgba(230, 57, 70, 0.5)',
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
</script>
<?php require_once '../includes/footer.php'; ?>