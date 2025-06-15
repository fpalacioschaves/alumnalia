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

// Obtener ejercicios del examen
$stmt = $pdo->prepare("SELECT id, enunciado, orden FROM ejercicios WHERE examen_id = ? ORDER BY orden");
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

// Obtener calificaciones existentes
$stmt = $pdo->prepare("
    SELECT * FROM resoluciones
    WHERE ejercicio_id IN (
        SELECT id FROM ejercicios WHERE examen_id = ?
    )
");
$stmt->execute([$examen_id]);
$resoluciones = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_UNIQUE);

require_once '../includes/header.php';
?>

<h2 class="mt-4">Calificaciones - <?= htmlspecialchars($examen['titulo']) ?></h2>

<table class="table table-bordered table-striped table-sm align-middle text-center">
    <thead class="table-light">
        <tr>
            <th>Alumno</th>
            <?php foreach ($ejercicios as $ej): ?>
                <th><?= 'Ej' . $ej['orden'] ?></th>
            <?php endforeach; ?>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($alumnos as $al): ?>
            <tr>
                <td class="text-start"><?= htmlspecialchars($al['apellido'] . ', ' . $al['nombre']) ?></td>
                <?php foreach ($ejercicios as $ej): ?>
                    <?php
                    $key = $al['id'] . '-' . $ej['id'];
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
                <?php
                $total = 0;
                foreach ($ejercicios as $ej) {
                    $stmt = $pdo->prepare("SELECT puntuacion_obtenida FROM resoluciones WHERE alumno_id = ? AND ejercicio_id = ?");
                    $stmt->execute([$al['id'], $ej['id']]);
                    $nota = $stmt->fetchColumn();
                    $total += $nota ?: 0;
                ?>

                <?php } ?>
                <td class="fw-bold bg-light"><?= number_format($total, 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="examenes.php" class="btn btn-secondary">← Volver a exámenes</a>

<?php require_once '../includes/footer.php'; ?>
