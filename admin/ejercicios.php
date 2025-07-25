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

// Obtener examen
$stmt = $pdo->prepare("SELECT e.*, a.nombre AS asignatura FROM examenes e LEFT JOIN asignaturas a ON e.asignatura_id = a.id WHERE e.id = ?");
$stmt->execute([$examen_id]);
$examen = $stmt->fetch();

if (!$examen) {
    header("Location: examenes.php");
    exit;
}

// Obtener ejercicios manuales
$stmt = $pdo->prepare("SELECT ej.id, ej.enunciado, ej.tipo, ej.puntuacion, ej.orden, et.nombre AS etiqueta
                       FROM ejercicios ej
                       LEFT JOIN etiquetas et ON ej.etiqueta_id = et.id
                       WHERE ej.examen_id = ?
                       ORDER BY ej.orden ASC");
$stmt->execute([$examen_id]);
$ejercicios = $stmt->fetchAll();

// Obtener ejercicios del banco de preguntas
$stmt = $pdo->prepare("SELECT bp.id, bp.enunciado, 'test' AS tipo, puntuacion AS puntuacion, NULL AS orden, e.nombre AS etiqueta
                       FROM banco_preguntas_en_examen bpe
                       JOIN banco_preguntas bp ON bpe.pregunta_id = bp.id
                       LEFT JOIN etiquetas e ON bp.etiqueta_id = e.id
                       WHERE bpe.examen_id = ?");
$stmt->execute([$examen_id]);
$preguntas_banco = $stmt->fetchAll();

require_once '../includes/header.php';
?>

<h2 class="mt-4">Ejercicios del examen: <?= htmlspecialchars($examen['titulo']) ?> (<?= htmlspecialchars($examen['asignatura']) ?>)</h2>

<a href="ejercicio_nuevo.php?examen_id=<?= $examen_id ?>" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Nuevo ejercicio
</a>
<a href="examen_agregar_banco.php?examen_id=<?= $examen_id ?>" class="btn btn-outline-primary mb-3 ms-2">
    <i class="bi bi-journals"></i> Añadir desde banco de preguntas
</a>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>Orden</th>
            <th>Enunciado</th>
            <th>Tipo</th>
            <th>Puntos</th>
            <th>Etiqueta</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ejercicios as $e): ?>
        <tr>
            <td><?= $e['orden'] ?></td>
            <td><?= htmlspecialchars(mb_strimwidth($e['enunciado'], 0, 80, '...')) ?></td>
            <td><?= ucfirst($e['tipo']) ?></td>
            <td><?= $e['puntuacion'] ?></td>
            <td><?= htmlspecialchars($e['etiqueta'] ?? '—') ?></td>
            <td>
                <a href="ejercicio_editar.php?id=<?= $e['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a href="ejercicio_eliminar.php?id=<?= $e['id'] ?>&examen_id=<?= $examen_id ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este ejercicio?');">
                    <i class="bi bi-trash"></i>
                </a>
                <?php if ($e['tipo'] === 'test' || $e['tipo'] === 'multi'): ?>
                    <a href="respuestas.php?ejercicio_id=<?= $e['id'] ?>" class="btn btn-info btn-sm">
                        <i class="bi bi-list-check"></i> Respuestas
                    </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>

        <?php foreach ($preguntas_banco as $b): ?>
        <tr class="table-secondary">
            <td>Banco</td>
            <td><?= htmlspecialchars(mb_strimwidth($b['enunciado'], 0, 80, '...')) ?></td>
            <td><?= ucfirst($b['tipo']) ?></td>
            <!-- Aqui van los puntos del ejercicio del banco -->
            <td>
                <form method="POST" action="valorar_ejercicio_banco_en_examen.php" style="display:inline-block; width:60px">
                    <input type="hidden" name="examen_id" value="<?= $examen_id ?>">
                    <input type="hidden" name="ejercicio_id" value="<?= $b['id'] ?>">
                    <input type="number" step="0.05" min="0" name="nota" value="<?= $b['puntuacion'] !== false ? $b['puntuacion']: '' ?>" class="form-control form-control-sm text-center" onchange="this.form.submit();">
                </form>
            </td>

            <!-- Fin de los puntos del ejercicio del banco -->

            <td><?= htmlspecialchars($b['etiqueta'] ?? '—') ?></td>
            <td>
                <a href="pregunta_banco_eliminar.php?examen_id=<?= $examen_id ?>&pregunta_id=<?= $b['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Quitar esta pregunta del examen?');">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="examen_editar.php?id=<?= $examen_id ?>" class="btn btn-secondary">← Volver al examen</a>

<?php require_once '../includes/footer.php'; ?>