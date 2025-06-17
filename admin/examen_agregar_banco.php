<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$examen_id = $_GET['examen_id'] ?? null;
if (!$examen_id) {
    header('Location: examenes.php');
    exit;
}

$temas = $pdo->query("SELECT id, nombre FROM temas ORDER BY nombre")->fetchAll();
$etiquetas = $pdo->query("SELECT id, nombre FROM etiquetas ORDER BY nombre")->fetchAll();
$dificultades = ['baja', 'media', 'alta'];

$tema_id = $_GET['tema_id'] ?? null;
$etiqueta_id = $_GET['etiqueta_id'] ?? null;
$dificultad = $_GET['dificultad'] ?? null;

$sql = "SELECT bp.* FROM banco_preguntas bp WHERE 1";
$params = [];

if ($tema_id) {
    $sql .= " AND tema_id = ?";
    $params[] = $tema_id;
}
if ($etiqueta_id) {
    $sql .= " AND etiqueta_id = ?";
    $params[] = $etiqueta_id;
}
if ($dificultad) {
    $sql .= " AND dificultad = ?";
    $params[] = $dificultad;
}

$sql .= " AND bp.id NOT IN (SELECT pregunta_id FROM banco_preguntas_en_examen WHERE examen_id = ?)";
$params[] = $examen_id;

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$preguntas = $stmt->fetchAll();

require_once '../includes/header.php';
?>

<h2 class="mt-4">Agregar preguntas del banco al examen</h2>

<form method="GET" class="row g-3 mb-4">
    <input type="hidden" name="examen_id" value="<?= $examen_id ?>">

    <div class="col-md-4">
        <label class="form-label">Tema:</label>
        <select name="tema_id" class="form-select">
            <option value="">Todos</option>
            <?php foreach ($temas as $t): ?>
                <option value="<?= $t['id'] ?>" <?= $tema_id == $t['id'] ? 'selected' : '' ?>><?= htmlspecialchars($t['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Etiqueta:</label>
        <select name="etiqueta_id" class="form-select">
            <option value="">Todas</option>
            <?php foreach ($etiquetas as $e): ?>
                <option value="<?= $e['id'] ?>" <?= $etiqueta_id == $e['id'] ? 'selected' : '' ?>><?= htmlspecialchars($e['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Dificultad:</label>
        <select name="dificultad" class="form-select">
            <option value="">Todas</option>
            <?php foreach ($dificultades as $dif): ?>
                <option value="<?= $dif ?>" <?= $dificultad == $dif ? 'selected' : '' ?>><?= ucfirst($dif) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-1 d-flex align-items-end">
        <button class="btn btn-primary w-100"><i class="bi bi-search"></i></button>
    </div>
</form>

<?php if (!empty($preguntas)): ?>
    <form method="POST" action="procesar_agregar_preguntas.php">
        <input type="hidden" name="examen_id" value="<?= $examen_id ?>">

        <h5>Selecciona las preguntas a asignar</h5>
        <?php foreach ($preguntas as $p): ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="preguntas[]" value="<?= $p['id'] ?>" id="preg<?= $p['id'] ?>">
                <label class="form-check-label" for="preg<?= $p['id'] ?>">
                    <?= htmlspecialchars($p['enunciado']) ?>
                </label>
            </div>
        <?php endforeach; ?>

        <button class="btn btn-success mt-3">
            <i class="bi bi-check-circle"></i> Añadir al examen
        </button>
    </form>
<?php else: ?>
    <p class="text-muted">No hay preguntas disponibles con estos filtros o ya fueron asignadas.</p>
<?php endif; ?>

<a href="examen_editar.php?id=<?= $examen_id ?>" class="btn btn-secondary mt-4">← Volver al examen</a>

<?php require_once '../includes/footer.php'; ?>