<?php
session_start();
require_once '../includes/db.php';

$mensaje = '';
$tipos_permitidos = ['alumno', 'profesor', 'admin'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $tipo = $_POST['tipo'] ?? '';

    if (!in_array($tipo, $tipos_permitidos)) {
        $mensaje = "Tipo de usuario no válido.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $mensaje = "Este correo ya está registrado.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password_hash, tipo, fecha_registro) VALUES (?, ?, ?, ?, ?, CURRENT_DATE)");
            $stmt->execute([$nombre, $apellido, $email, $password_hash, $tipo]);
            $mensaje = "Usuario registrado correctamente.";

            // Redirige al login después del registro exitoso
            header("Location: login.php?registrado=1");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrar nuevo usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">
    <h2 class="mt-5">Registrar nuevo usuario</h2>

    <?php if ($mensaje): ?>
        <div class="alert alert-info mt-3"><?= $mensaje ?></div>
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
            <label>Tipo de usuario:</label>
            <select name="tipo" class="form-select" required>
                <option value="">--Selecciona--</option>
                <option value="alumno">Alumno</option>
                <option value="profesor">Profesor</option>
                <option value="admin">Administrador</option>
            </select>
        </div>
        <button class="btn btn-primary">Registrar</button>
    </form>
</body>
</html>
