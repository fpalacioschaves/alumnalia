<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();


$temas = $pdo->query("SELECT t.id, t.nombre, a.nombre AS asignatura FROM temas t JOIN asignaturas a ON t.asignatura_id = a.id ORDER BY a.nombre, t.nombre")->fetchAll();
$etiquetas = $pdo->query("SELECT id, nombre FROM etiquetas ORDER BY nombre")->fetchAll();
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tema_id = $_POST['tema_id'] ?? null;
    $etiqueta_id = $_POST['etiqueta_id'] ?? null;
    $tipo = $_POST['tipo'] ?? 'desarrollo';
    $dificultad = $_POST['dificultad'] ?? 'media';
    $enunciado = trim($_POST['enunciado'] ?? '');
    $solucion = trim($_POST['solucion'] ?? '');

    if ($tema_id && $etiqueta_id && $enunciado) {
        $stmt = $pdo->prepare("INSERT INTO ejercicios_propuestos (tema_id, etiqueta_id, tipo, dificultad, enunciado, solucion) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$tema_id, $etiqueta_id, $tipo, $dificultad, $enunciado, $solucion]);
        header("Location: ejercicios_propuestos.php");
        exit;
    } else {
        $mensaje = "Todos los campos obligatorios deben estar completos.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Nuevo Ejercicio Propuesto</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">Tema:</label>
        <select name="tema_id" class="form-select" required>
            <option value="">Selecciona un tema</option>
            <?php foreach ($temas as $t): ?>
                <option value="<?= $t['id'] ?>">
                    <?= htmlspecialchars($t['asignatura'] . ' - ' . $t['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Etiqueta:</label>
        <select name="etiqueta_id" class="form-select" required>
            <option value="">Selecciona una etiqueta</option>
            <?php foreach ($etiquetas as $e): ?>
                <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Tipo:</label>
        <select name="tipo" class="form-select">
            <option value="desarrollo">Desarrollo</option>
            <option value="test">Test</option>
            <option value="codigo">Código</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Dificultad:</label>
        <select name="dificultad" class="form-select">
            <option value="baja">Baja</option>
            <option value="media" selected>Media</option>
            <option value="alta">Alta</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Enunciado:</label>
        <textarea name="enunciado" class="form-control" rows="4" required></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Solución (opcional):</label>
        <textarea name="solucion" class="form-control" rows="3"></textarea>
    </div>

    <button class="btn btn-primary">Guardar ejercicio</button>
    <a href="ejercicios_propuestos.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>
