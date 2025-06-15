<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$ejercicio_id = $_GET['ejercicio_id'] ?? null;
if (!$ejercicio_id || !is_numeric($ejercicio_id)) {
    header("Location: examenes.php");
    exit;
}

// Obtener ejercicio y verificar tipo
$stmt = $pdo->prepare("SELECT * FROM ejercicios WHERE id = ?");
$stmt->execute([$ejercicio_id]);
$ejercicio = $stmt->fetch();

if (!$ejercicio || !in_array($ejercicio['tipo'], ['test', 'multi'])) {
    header("Location: examenes.php");
    exit;
}

$examen_id = $ejercicio['examen_id'];

// Obtener respuestas asociadas
$stmt = $pdo->prepare("SELECT * FROM respuestas WHERE ejercicio_id = ? ORDER BY id");
$stmt->execute([$ejercicio_id]);
$respuestas = $stmt->fetchAll();

require_once '../includes/header.php';
?>

<h2 class="mt-4">Respuestas del ejercicio #<?= $ejercicio['id'] ?> (<?= ucfirst($ejercicio['tipo']) ?>)</h2>

<a href="respuesta_nueva.php?ejercicio_id=<?= $ejercicio_id ?>" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Nueva respuesta
</a>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Texto</th>
            <th>Correcta</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($respuestas as $r): ?>
        <tr>
            <td><?= $r['id'] ?></td>
            <td><?= htmlspecialchars($r['texto_respuesta']) ?></td>
            <td><?= $r['es_correcta'] ? '✅' : '❌' ?></td>
            <td>
                <a href="respuesta_editar.php?id=<?= $r['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a href="respuesta_eliminar.php?id=<?= $r['id'] ?>&ejercicio_id=<?= $ejercicio_id ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta respuesta?');">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="ejercicios.php?examen_id=<?= $examen_id ?>" class="btn btn-secondary">← Volver a ejercicios</a>

<?php require_once '../includes/footer.php'; ?>
