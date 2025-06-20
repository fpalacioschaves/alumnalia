<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

redirigir_si_no_autenticado();
solo_admin();

$examen_id = $_GET['examen_id'] ?? null;
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo']) && $examen_id) {
    $archivo = $_FILES['archivo']['tmp_name'];
    $contador = 0;

    if (($handle = fopen($archivo, "r")) !== false) {
        $linea = 0;
        
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $linea++;
            if ($linea === 1) continue;

            if (count($data) < 4) {
                continue; // saltamos filas incompletas
            }

            $nombre = trim($data[0]);
            $apellido = trim($data[1]);
            $email = strtolower(trim($data[2]));
            $nota_total = str_replace(',', '.', trim($data[3]));

            // Buscar alumno por email
            $stmt = $pdo->prepare("
                SELECT a.id FROM alumnos a
                JOIN usuarios u ON a.id = u.id
                WHERE u.email = ?
            ");
            $stmt->execute([$email]);
            $alumno_id = $stmt->fetchColumn();

            if ($alumno_id && is_numeric($nota_total)) {
                $stmt = $pdo->prepare("
                    INSERT INTO notas_examen_alumno (examen_id, alumno_id, nota_total)
                    VALUES (?, ?, ?)
                    ON DUPLICATE KEY UPDATE nota_total = VALUES(nota_total)
                ");
                $stmt->execute([$examen_id, $alumno_id, $nota_total]);
                $contador++;
            }
        }
        fclose($handle);
        $mensaje = "$contador notas importadas correctamente.";
    } else {
        $mensaje = "No se pudo abrir el archivo.";
    }
}
?>

<?php require_once '../includes/header.php'; ?>

<h2 class="mt-4">Importar calificaciones al examen #<?= htmlspecialchars($examen_id) ?></h2>

<?php if ($mensaje): ?>
    <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>

<?php if (!$examen_id): ?>
    <div class="alert alert-warning">No se ha indicado un examen.</div>
<?php else: ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="archivo" class="form-label">Archivo CSV (nombre, apellido, email, nota_total)</label>
            <input type="file" name="archivo" id="archivo" accept=".csv" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-upload"></i> Importar calificaciones
        </button>
    </form>
<?php endif; ?>

<a href="calificaciones.php?examen_id=<?= $examen_id ?>" class="btn btn-secondary mt-4">← Volver al examen</a>

<?php require_once '../includes/footer.php'; ?>