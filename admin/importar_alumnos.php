<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$mensaje = '';

// Obtener cursos
$cursos = $pdo->query("SELECT id, nombre FROM cursos ORDER BY nombre")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv']) && isset($_POST['curso_id'])) {
    $curso_id = $_POST['curso_id'];
    $archivo = $_FILES['csv']['tmp_name'];

    if (is_uploaded_file($archivo)) {
        $f = fopen($archivo, 'r');
        $pdo->beginTransaction();
        try {
            while (($linea = fgetcsv($f)) !== false) {
                [$nombre, $apellido, $email] = $linea;
                $password_hash = password_hash($email, PASSWORD_DEFAULT);

                // Insertar en usuarios
                $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password_hash, tipo) VALUES (?, ?, ?, ?, 'alumno')");
                $stmt->execute([$nombre, $apellido, $email, $password_hash]);
                $usuario_id = $pdo->lastInsertId();

                // Insertar en alumnos
                $stmt = $pdo->prepare("INSERT INTO alumnos (id, curso_id) VALUES (?, ?)");
                $stmt->execute([$usuario_id, $curso_id]);
            }
            $pdo->commit();
            $mensaje = "Alumnos importados correctamente.";
        } catch (Exception $e) {
            $pdo->rollBack();
            $mensaje = "Error al importar: " . $e->getMessage();
        }
        fclose($f);
    } else {
        $mensaje = "Error al subir el archivo.";
    }
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Importar Alumnos desde CSV</h2>

<?php if ($mensaje): ?>
    <div class="alert alert-info"> <?= htmlspecialchars($mensaje) ?> </div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Selecciona el curso:</label>
        <select name="curso_id" class="form-select" required>
            <option value="">-- Selecciona --</option>
            <?php foreach ($cursos as $curso): ?>
                <option value="<?= $curso['id'] ?>"><?= htmlspecialchars($curso['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Archivo CSV:</label>
        <input type="file" name="csv" accept=".csv" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-upload"></i> Importar alumnos
    </button>
    <a href="alumnos.php" class="btn btn-secondary">Cancelar</a>
</form>

<p class="mt-3 text-muted">
    El archivo CSV debe tener las columnas: <code>nombre, apellido, email</code> (en ese orden y sin cabecera).
</p>

<?php require_once '../includes/footer.php'; ?>
