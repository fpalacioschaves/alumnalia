<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$temas = $pdo->query("SELECT t.id, t.nombre, a.nombre AS asignatura FROM temas t JOIN asignaturas a ON t.asignatura_id = a.id ORDER BY a.nombre, t.nombre")->fetchAll();
$etiquetas = $pdo->query("SELECT id, nombre FROM etiquetas ORDER BY nombre")->fetchAll();
$dificultades = ['baja', 'media', 'alta'];
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tema_id = $_POST['tema_id'] ?? null;
    $etiqueta_id = $_POST['etiqueta_id'] ?? null;
    $dificultad = $_POST['dificultad'] ?? null;
    $cantidad = (int) ($_POST['cantidad'] ?? 0);

    if ($cantidad > 0) {
        $condiciones = [];
        $parametros = [];

        if ($tema_id) {
            $condiciones[] = 'tema_id = ?';
            $parametros[] = $tema_id;
        }
        if ($etiqueta_id) {
            $condiciones[] = 'etiqueta_id = ?';
            $parametros[] = $etiqueta_id;
        }
        if ($dificultad) {
            $condiciones[] = 'dificultad = ?';
            $parametros[] = $dificultad;
        }

        $sql = "SELECT * FROM banco_preguntas";
        if ($condiciones) {
            $sql .= " WHERE " . implode(" AND ", $condiciones);
        }
        $sql .= " ORDER BY RAND() LIMIT ?";
        $parametros[] = $cantidad;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($parametros);
        $preguntas = $stmt->fetchAll();

        if (count($preguntas) > 0) {
            // Aquí podrías redirigir al paso siguiente para crear el examen con estas preguntas
            $_SESSION['preguntas_generadas'] = $preguntas;
            header("Location: generar_examen_confirmar.php");
            exit;
        } else {
            $mensaje = "No se encontraron preguntas con los criterios seleccionados.";
        }
    } else {
        $mensaje = "Debe indicar una cantidad válida de preguntas.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Generar Examen Automáticamente</h2>
<p>Selecciona los criterios para generar un examen a partir del banco de preguntas.</p>

<?php if ($mensaje): ?>
  <div class="alert alert-danger"> <?= htmlspecialchars($mensaje) ?> </div>
<?php endif; ?>

<form method="POST" class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Tema (opcional):</label>
        <select name="tema_id" class="form-select">
            <option value="">-- Todos --</option>
            <?php foreach ($temas as $t): ?>
                <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['asignatura'] . ' - ' . $t['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Etiqueta (opcional):</label>
        <select name="etiqueta_id" class="form-select">
            <option value="">-- Todas --</option>
            <?php foreach ($etiquetas as $e): ?>
                <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Dificultad (opcional):</label>
        <select name="dificultad" class="form-select">
            <option value="">-- Todas --</option>
            <?php foreach ($dificultades as $dif): ?>
                <option value="<?= $dif ?>"><?= ucfirst($dif) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Cantidad de preguntas:</label>
        <input type="number" name="cantidad" class="form-control" min="1" required>
    </div>
    <div class="col-md-12">
        <button class="btn btn-primary">
            <i class="bi bi-shuffle"></i> Generar y continuar
        </button>
    </div>
</form>

<?php require_once '../includes/footer.php'; ?>