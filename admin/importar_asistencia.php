<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$mensaje = '';

// Obtener cursos y asignaturas
$cursos = $pdo->query("SELECT id, nombre FROM cursos ORDER BY nombre")->fetchAll();
$asignaturas = $pdo->query("SELECT id, nombre FROM asignaturas ORDER BY nombre")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
    $curso_id = $_POST['curso_id'] ?? null;
    $asignatura_id = $_POST['asignatura_id'] ?? null;
    $evaluacion = $_POST['evaluacion'] ?? null;
    $archivo = $_FILES['archivo']['tmp_name'];

    if ($curso_id && $asignatura_id && $evaluacion && is_uploaded_file($archivo)) {
        $contador = 0;
        if (($handle = fopen($archivo, "r")) !== false) {
            $linea = 0;
            while (($data = fgetcsv($handle, 1000, ";")) !== false) {
                $linea++;
                if ($linea === 1) continue; // saltar cabecera

                if (count($data) < 4) continue;

                $email = strtolower(trim($data[2]));
                $asistencia = str_replace(',', '.', trim($data[3]));

                // Buscar alumno por email
                $stmt = $pdo->prepare("SELECT a.id FROM alumnos a JOIN usuarios u ON a.id = u.id WHERE u.email = ?");
                $stmt->execute([$email]);
                $alumno_id = $stmt->fetchColumn();

                if ($alumno_id && is_numeric($asistencia)) {
                    $stmt = $pdo->prepare("
                        INSERT INTO asistencia_alumnos (alumno_id, asignatura_id, evaluacion, porcentaje_asistencia)
                        VALUES (?, ?, ?, ?)
                        ON DUPLICATE KEY UPDATE porcentaje_asistencia = VALUES(porcentaje_asistencia)
                    ");
                    $stmt->execute([$alumno_id, $asignatura_id, $evaluacion, $asistencia]);
                    $contador++;
                }
            }
            fclose($handle);
            $mensaje = "$contador registros de asistencia importados correctamente.";
        } else {
            $mensaje = "No se pudo abrir el archivo.";
        }
    } else {
        $mensaje = "Todos los campos son obligatorios.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Importar Asistencia</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-info"> <?= htmlspecialchars($mensaje) ?> </div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="mb-4">
    <div class="mb-3">
        <label for="curso_id" class="form-label">Curso:</label>
        <select name="curso_id" id="curso_id" class="form-select" required>
            <option value="">Selecciona curso</option>
            <?php foreach ($cursos as $curso): ?>
                <option value="<?= $curso['id'] ?>"><?= htmlspecialchars($curso['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="asignatura_id" class="form-label">Asignatura:</label>
        <select name="asignatura_id" id="asignatura_id" class="form-select" required>
            <option value="">Selecciona asignatura</option>
            <?php foreach ($asignaturas as $a): ?>
                <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="evaluacion" class="form-label">Evaluación:</label>
        <select name="evaluacion" id="evaluacion" class="form-select" required>
            <option value="">Selecciona evaluación</option>
            <option value="1">Evaluación 1</option>
            <option value="2">Evaluación 2</option>
            <option value="3">Evaluación 3</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="archivo" class="form-label">Archivo CSV (nombre;apellido;email;asistencia)</label>
        <input type="file" name="archivo" id="archivo" accept=".csv" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-upload"></i> Importar asistencia
    </button>
</form>

<a href="evaluaciones.php" class="btn btn-secondary">← Volver</a>

<?php require_once '../includes/footer.php'; ?>
