<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

redirigir_si_no_autenticado();
solo_admin();

$actividad_id = $_GET['id'] ?? null;
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo']) && $actividad_id) {
    $archivo = $_FILES['archivo']['tmp_name'];
    $contador = 0;

    if (($handle = fopen($archivo, "r")) !== false) {
        $linea = 0;
        while (($data = fgetcsv($handle, 1000, ";")) !== false) {
            $linea++;
            if ($linea === 1) continue;

            // var_dump($data);
            // break para mostrar solo una línea y no saturar la salida
            // break;

            if (count($data) < 4) {
                continue;
            }

            $nombre = trim($data[0]);
            $apellido = trim($data[1]);
            $email = strtolower(trim($data[2]));
            $nota = str_replace(',', '.', trim($data[3]));

            // Buscar alumno por email
            $stmt = $pdo->prepare("
                SELECT a.id FROM alumnos a
                JOIN usuarios u ON a.id = u.id
                WHERE u.email = ?
            ");
            $stmt->execute([$email]);
            $alumno_id = $stmt->fetchColumn();

            if ($alumno_id && is_numeric($nota)) {
                $stmt = $pdo->prepare("
                    INSERT INTO actividades_alumnos (actividad_id, alumno_id, nota)
                    VALUES (?, ?, ?)
                    ON DUPLICATE KEY UPDATE nota = VALUES(nota)
                ");
                $stmt->execute([$actividad_id, $alumno_id, $nota]);
                $contador++;
            }
        }
        fclose($handle);
        $mensaje = "$contador calificaciones importadas correctamente.";
    } else {
        $mensaje = "No se pudo abrir el archivo.";
    }
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

require_once '../includes/header.php';
?>

<h2 class="mt-4">Importar Calificaciones - <?= htmlspecialchars($actividad['titulo']) ?> (<?= $actividad['asignatura'] ?> - <?= $actividad['curso'] ?>)</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>

<?php if (!$actividad_id): ?>
    <div class="alert alert-warning">No se ha indicado una actividad.</div>
<?php else: ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="archivo" class="form-label">Archivo CSV (nombre, apellido, email, nota)</label>
            <input type="file" name="archivo" id="archivo" accept=".csv" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-upload"></i> Importar calificaciones
        </button>
    </form>
<?php endif; ?>

<a href="actividades.php" class="btn btn-secondary mt-4">← Volver a actividades</a>

<?php require_once '../includes/footer.php'; ?>