<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$temas = $pdo->query("SELECT id, nombre FROM temas ORDER BY nombre")->fetchAll();
$etiquetas = $pdo->query("SELECT id, nombre FROM etiquetas ORDER BY nombre")->fetchAll();

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enunciado = $_POST['enunciado'] ?? '';
    $dificultad = $_POST['dificultad'] ?? 'media';
    $tema_id = $_POST['tema_id'] ?? null;
    $etiqueta_id = $_POST['etiqueta_id'] ?? null;
    $opciones = $_POST['opciones'] ?? [];
    $correcta = $_POST['correcta'] ?? '';

    if ($enunciado && count($opciones) >= 2 && $correcta !== '') {
        $stmt = $pdo->prepare("INSERT INTO banco_preguntas (enunciado, dificultad, tema_id, etiqueta_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$enunciado, $dificultad, $tema_id, $etiqueta_id]);
        $pregunta_id = $pdo->lastInsertId();

        foreach ($opciones as $i => $texto) {
            $stmt = $pdo->prepare("INSERT INTO opciones_banco_pregunta (pregunta_id, texto, es_correcta) VALUES (?, ?, ?)");
            $stmt->execute([$pregunta_id, $texto, ($correcta == $i ? 1 : 0)]);
        }

        header("Location: banco_preguntas.php");
        exit;
    } else {
        $mensaje = "Debes completar el enunciado, al menos 2 opciones y marcar la correcta.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Nueva Pregunta</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">Enunciado:</label>
        <textarea name="enunciado" class="form-control" required></textarea>
    </div>

    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Dificultad:</label>
            <select name="dificultad" class="form-select">
                <option value="baja">Baja</option>
                <option value="media" selected>Media</option>
                <option value="alta">Alta</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tema:</label>
            <select name="tema_id" class="form-select">
                <option value="">Ninguno</option>
                <?php foreach ($temas as $t): ?>
                    <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Etiqueta:</label>
            <select name="etiqueta_id" class="form-select">
                <option value="">Ninguna</option>
                <?php foreach ($etiquetas as $e): ?>
                    <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <hr>
    <h5>Opciones de respuesta</h5>
    <?php for ($i = 0; $i < 4; $i++): ?>
        <div class="input-group mb-2">
            <div class="input-group-text">
                <input class="form-check-input mt-0" type="radio" name="correcta" value="<?= $i ?>">
            </div>
            <input type="text" class="form-control" name="opciones[]" placeholder="Opción <?= $i + 1 ?>">
        </div>
    <?php endfor; ?>

    <button class="btn btn-success mt-3">
        <i class="bi bi-check-circle"></i> Guardar Pregunta
    </button>
    <a href="banco_preguntas.php" class="btn btn-secondary mt-3">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
