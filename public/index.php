<?php
session_start();
require_once '../includes/db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    var_dump($_SESSION);
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? AND tipo = 'alumno'");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
         $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['rol'] = $user['tipo'];       // 'alumno'
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_nombre'] = $user['nombre'];
        $_SESSION['user_apellido'] = $user['apellido'] ?? '';
        $_SESSION['curso_id'] = $user['curso_id'] ?? null;
        header("Location: panel_alumno.php");
        exit;
    } else {
        $error = "Credenciales incorrectas. Intenta de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Alumno - Alumnalia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>Acceso Alumno - Alumnalia</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        <form method="POST" action="index.php">
                            <div class="mb-3">
                                <label class="form-label">Email:</label>
                                <input type="text" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contraseña:</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button class="btn btn-primary w-100">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
