<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


redirigir_si_no_autenticado();
solo_admin();

$actividad_id = $_GET['id'] ?? null;
if (!$actividad_id || !is_numeric($actividad_id)) {
    header("Location: actividades.php");
    exit;
}

// Obtener actividad
$stmt = $pdo->prepare("
    SELECT a.id, a.titulo, a.descripcion, a.asignatura_id, a.curso_id, asig.nombre AS asignatura, c.nombre AS curso
    FROM actividades a
    JOIN asignaturas asig ON a.asignatura_id = asig.id
    JOIN cursos c ON a.curso_id = c.id
    WHERE a.id = ?
");
$stmt->execute([$actividad_id]);
$actividad = $stmt->fetch();

if (!$actividad) {
    header("Location: actividades.php");
    exit;
}

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo']) && $_FILES['archivo']['error'] === 0) {
    $csv = array_map('str_getcsv', file($_FILES['archivo']['tmp_name']));

    unset($csv[0]);
    $insertados = 0;
    foreach ($csv as $fila) {
        if (count($fila) >= 4) {
            $email = trim($fila[2]);
            $nota = floatval(str_replace(',', '.', $fila[3]));

            echo $email . " - " . $nota . "<br>";

            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $usuario = $stmt->fetch();

            if ($usuario) {
                $alumno_id = $usuario['id'];
                $stmt = $pdo->prepare("
                    INSERT INTO actividades_alumnos (actividad_id, alumno_id, puntuacion)
                    VALUES (?, ?, ?)
                    ON DUPLICATE KEY UPDATE puntuacion = VALUES(puntuacion)
                ");
                $stmt->execute([$actividad_id, $alumno_id, $nota]);
                $insertados++;
            }
        }
    }
    $mensaje = "$insertados calificaciones importadas correctamente.";
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Importar Calificaciones - <?= htmlspecialchars($actividad['titulo']) ?> (<?= $actividad['asignatura'] ?> - <?= $actividad['curso'] ?>)</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Archivo CSV con columnas: nombre, apellidos, email, nota</label>
        <input type="file" name="archivo" accept=".csv" class="form-control" required>
    </div>
    <button class="btn btn-primary"><i class="bi bi-upload"></i> Importar Calificaciones</button>
    <a href="actividades.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../includes/footer.php'; ?>