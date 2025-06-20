<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';
$mensaje = '';

// Obtener lista de cursos disponibles
$cursos = $pdo->query("SELECT id, nombre FROM cursos ORDER BY nombre")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $curso_id = $_POST['curso_id'] ?? null;
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';

    // Validar email duplicado
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        $mensaje = "Este correo ya está registrado.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar en usuarios
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password_hash, tipo, fecha_registro) VALUES (?, ?, ?, ?, 'alumno', CURRENT_DATE)");
        $stmt->execute([$nombre, $apellido, $email, $password_hash]);
        $nuevo_id = $pdo->lastInsertId();

        // Insertar en alumnos
        $stmt = $pdo->prepare("INSERT INTO alumnos (id, curso_id) VALUES (?, ?)");
        $stmt->execute([$nuevo_id, $curso_id, $fecha_nacimiento]);

        header("Location: alumnos.php");
        exit;
    }
}
?>


    <h2 class="mt-5">Añadir nuevo alumno</h2>

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
            <label>Curso:</label>
            <select name="curso_id" class="form-select" required>
                <option value="">-- Selecciona curso --</option>
                <?php foreach ($cursos as $curso): ?>
                    <option value="<?= $curso['id'] ?>"><?= htmlspecialchars($curso['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="btn btn-primary">Guardar</button>
        <a href="alumnos.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
