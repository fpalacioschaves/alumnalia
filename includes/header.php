<?php
if (session_status() === PHP_SESSION_NONE) {
 //   session_start();
}
require_once 'auth.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel de Administración</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../admin/assets/css/alumnalia.css">

    
</head>
<body>
<?php if (usuario_autenticado() && tipo_usuario() === 'admin'): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Alumnalia</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bi bi-house"></i> Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="alumnos.php"><i class="bi bi-people"></i> Alumnos</a></li>
        <li class="nav-item"><a class="nav-link" href="profesores.php"><i class="bi bi-person-badge"></i> Profesores</a></li>
        <li class="nav-item"><a class="nav-link" href="cursos.php"><i class="bi bi-journal-bookmark"></i> Cursos</a></li>
        <li class="nav-item"><a class="nav-link" href="asignaturas.php"><i class="bi bi-journal-bookmark"></i> Asignaturas</a></li>
        <li class="nav-item"><a class="nav-link" href="/admin/temas.php"><i class="bi bi-list-ul"></i> Temas</a></li>
        <li class="nav-item"><a class="nav-link" href="examenes.php"><i class="bi bi-file-earmark-text"></i> Exámenes</a></li>
        <li class="nav-item"><a class="nav-link" href="ejercicios_propuestos.php"><i class="bi bi-lightbulb"></i> Ejercicios propuestos</a></li>
        <li class="nav-item"><a class="nav-link" href="etiquetas.php"><i class="bi bi-tags"></i> Etiquetas</a></li>
      </ul>
      <span class="navbar-text text-white me-3">
        <?= $_SESSION['user_nombre'] ?? 'Administrador' ?>
      </span>
      <a class="btn btn-outline-light btn-sm" href="logout.php"><i class="bi bi-box-arrow-right"></i> Salir</a>
    </div>
  </div>
</nav>
<?php endif; ?>
<div class="container mt-4">
