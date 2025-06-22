<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$evaluacion_id = $_GET['evaluacion_id'] ?? null;
if (!$evaluacion_id || !is_numeric($evaluacion_id)) {
    header("Location: evaluaciones.php");
    exit;
}

// Obtener datos de la evaluación
$stmt = $pdo->prepare("SELECT e.*, c.nombre AS curso_nombre, a.nombre AS asignatura_nombre FROM evaluaciones e JOIN cursos c ON e.curso_id = c.id JOIN asignaturas a ON e.asignatura_id = a.id WHERE e.id = ?");
$stmt->execute([$evaluacion_id]);
$evaluacion = $stmt->fetch();

if (!$evaluacion) {
    header("Location: evaluaciones.php");
    exit;
}


$curso_id = $evaluacion['curso_id'];
$asignatura_id = $evaluacion['asignatura_id'];
$numero_evaluacion = $evaluacion['numero_evaluacion'];
$pond_examen = $evaluacion['ponderacion_examenes'];
$pond_activ = $evaluacion['ponderacion_actividades'];
$pond_asist = $evaluacion['ponderacion_asistencia'];

// Obtener alumnos del curso
$stmt = $pdo->prepare("SELECT u.id, u.nombre, u.apellido FROM alumnos al JOIN usuarios u ON al.id = u.id WHERE al.curso_id = ? ORDER BY u.apellido, u.nombre");
$stmt->execute([$curso_id]);
$alumnos = $stmt->fetchAll();

// Obtener exámenes de esta evaluación
$stmt = $pdo->prepare("SELECT id, titulo FROM examenes WHERE asignatura_id = ? AND evaluacion = ?");
$stmt->execute([$asignatura_id, $numero_evaluacion]);
$examenes = $stmt->fetchAll();


// Obtener actividades de esta evaluación
$stmt = $pdo->prepare("SELECT id, titulo FROM actividades WHERE asignatura_id = ? AND curso_id = ? AND evaluacion = ?");
$stmt->execute([$asignatura_id, $curso_id, $numero_evaluacion]);
$actividades = $stmt->fetchAll();

// Obtener asistencias
$stmt = $pdo->prepare("SELECT alumno_id, porcentaje_asistencia FROM asistencia WHERE asignatura_id = ?  AND evaluacion = ?");
$stmt->execute([$asignatura_id, $numero_evaluacion]);
$asistencias = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

require_once '../includes/header.php';
?>

<h2 class="mt-4">Resultados Evaluación <?= $numero_evaluacion ?> - <?= htmlspecialchars($evaluacion['asignatura_nombre']) ?> (<?= htmlspecialchars($evaluacion['curso_nombre']) ?>)</h2>

<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Alumno</th>
            <?php foreach ($examenes as $ex): ?>
                <th><?= htmlspecialchars($ex['titulo']) ?></th>
            <?php endforeach; ?>
            <th>Media Ex.</th>
            <th>Pond. Ex.</th>
            <?php foreach ($actividades as $act): ?>
                <th><?= htmlspecialchars($act['titulo']) ?></th>
            <?php endforeach; ?>
            <th>Media Act.</th>
            <th>Pond. Act.</th>
            <th>% Asist.</th>
            <th>Pond. Asist.</th>
            <th>Nota Final</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($alumnos as $al):
        $eid = $al['id'];

        // Exámenes
        $totalEx = 0; $countEx = 0;
        foreach ($examenes as $ex):
            $stmt = $pdo->prepare("SELECT nota_total FROM notas_examen_alumno WHERE examen_id = ? AND alumno_id = ?");
            $stmt->execute([$ex['id'], $eid]);
            $nota = $stmt->fetchColumn();
            if ($nota !== false) {
                $totalEx += $nota;
                $countEx++;
            }
        endforeach;
        $mediaEx = $countEx > 0 ? round($totalEx / $countEx, 2) : 0;
        $ponderadaEx = round($mediaEx * $pond_examen, 2);

        // Actividades
        $totalAct = 0; $countAct = 0;
        foreach ($actividades as $act):
            $stmt = $pdo->prepare("SELECT nota FROM actividades_alumnos WHERE actividad_id = ? AND alumno_id = ?");
            $stmt->execute([$act['id'], $eid]);
            $nota = $stmt->fetchColumn();
            if ($nota !== false) {
                $totalAct += $nota;
                $countAct++;
            }
        endforeach;
        $mediaAct = $countAct > 0 ? round($totalAct / $countAct, 2) : 0;
        $ponderadaAct = round($mediaAct * $pond_activ, 2);

        // Asistencia
        $asistencia = $asistencias[$eid] ?? 0;
        $ponderadaAsist = round($asistencia * $pond_asist / 100, 2);

        $notaFinal = round($ponderadaEx + $ponderadaAct + $ponderadaAsist, 2);
        ?>
        <tr>
            <td><?= htmlspecialchars($al['apellido'] . ', ' . $al['nombre']) ?></td>
            <?php foreach ($examenes as $ex):
                $stmt = $pdo->prepare("SELECT nota_total FROM notas_examen_alumno WHERE examen_id = ? AND alumno_id = ?");
                $stmt->execute([$ex['id'], $eid]);
                $nota = $stmt->fetchColumn();
            ?>
                <td><?= $nota !== false ? number_format($nota, 2) : '—' ?></td>
            <?php endforeach; ?>
            <td><?= number_format($mediaEx, 2) ?></td>
            <td><?= number_format($ponderadaEx, 2) ?></td>
            <?php foreach ($actividades as $act):
                $stmt = $pdo->prepare("SELECT nota FROM actividades_alumnos WHERE actividad_id = ? AND alumno_id = ?");
                $stmt->execute([$act['id'], $eid]);
                $nota = $stmt->fetchColumn();
            ?>
                <td><?= $nota !== false ? number_format($nota, 2) : '—' ?></td>
            <?php endforeach; ?>
            <td><?= number_format($mediaAct, 2) ?></td>
            <td><?= number_format($ponderadaAct, 2) ?></td>
            <td><?= number_format($asistencia, 1) ?>%</td>
            <td><?= number_format($ponderadaAsist, 2) ?></td>
            <td class="fw-bold bg-light"><?= number_format($notaFinal, 2) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="evaluaciones.php" class="btn btn-secondary mt-4">← Volver a Evaluaciones</a>

<form method="POST" action="guardar_resultados_evaluacion.php" class="mt-3">
    <input type="hidden" name="evaluacion_id" value="<?= $evaluacion_id ?>">
    <button type="submit" class="btn btn-success">
        <i class="bi bi-save2"></i> Guardar resultados finales de la evaluación
    </button>
</form>

<a href="exportar_resultados_evaluacion.php?evaluacion_id=<?= $evaluacion_id ?>" class="btn btn-success mt-3">
    <i class="bi bi-file-earmark-excel"></i> Exportar a Excel
</a>


<?php require_once '../includes/footer.php'; ?>
