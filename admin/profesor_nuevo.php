<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';
$mensaje = '';

// Obtener todas las asignaturas
$asignaturas = $pdo->query("SELECT id, nombre FROM asignaturas ORDER BY nombre")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $asignaturas_seleccionadas = $_POST['asignaturas'] ?? [];

    // Validar email duplicado
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        $mensaje = "Este correo ya está registrado.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar en usuarios
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password_hash, tipo, fecha_registro) VALUES (?, ?, ?, ?, 'profesor', CURRENT_DATE)");
        $stmt->execute([$nombre, $apellido, $email, $password_hash]);

        $nuevo_id = $pdo->lastInsertId();

        // Insertar en profesores
        $stmt = $pdo->prepare("INSERT INTO profesores (id, departamento) VALUES (?, ?)");
        $stmt->execute([$nuevo_id, $departamento]);

        // Insertar asignaturas asociadas
        $stmt = $pdo->prepare("INSERT INTO profesor_asignatura (profesor_id, asignatura_id) VALUES (?, ?)");
        foreach ($asignaturas_seleccionadas as $asignatura_id) {
            $stmt->execute([$nuevo_id, $asignatura_id]);
        }

        header("Location: profesores.php");
        exit;
    }
}
?>

    <h2 class="mt-5">Añadir nuevo profesor</h2>

    <?php if ($mensaje): ?>
        <div class="alert alert-danger"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Apellido:</label>
            <input type="text" name="apellido" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Contraseña:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Departamento:</label>
            <input type="text" name="departamento" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Asignaturas que imparte:</label>
            <select name="asignaturas[]" class="form-select" multiple required>
                <?php foreach ($asignaturas as $asig): ?>
                    <option value="<?= $asig['id'] ?>"><?= htmlspecialchars($asig['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
            <small class="form-text text-muted">Usa Ctrl o Cmd para seleccionar múltiples.</small>
        </div>
        <button class="btn btn-primary">Guardar</button>
        <a href="profesores.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
