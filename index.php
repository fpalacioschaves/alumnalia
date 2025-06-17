<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alumnalia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="text-center mb-4">
        <img src="admin/assets/img/alumnalia-logo-transparente.png" alt="Logo Alumnalia" style="max-height: 300px;">
    </div>
    <div class="text-center mb-5">
        <h1 class="display-4">Bienvenido a <strong>Alumnalia</strong></h1>
        <p class="lead">Selecciona cómo deseas acceder a la plataforma</p>
    </div>

    <div class="row justify-content-center g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Acceso Administración</h5>
                    <p class="card-text">Profesores y administradores</p>
                    <a href="admin/login.php" class="btn btn-primary">Entrar como Admin</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Acceso Alumnado</h5>
                    <p class="card-text">Consulta tus notas, tareas y calendario</p>
                    <a href="public/index.php" class="btn btn-success">Entrar como Alumno</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
