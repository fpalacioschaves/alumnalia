<?php
require_once '../includes/db.php';
session_start();
$alumno_id = $_SESSION['usuario_id'];
$nombre = $_SESSION['user_nombre'];
$apellido = $_SESSION['user_apellido'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona Alumno - Alumnalia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="panel_alumno.php">Alumnalia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAlumno">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarAlumno">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="panel_alumno.php"><i class="bi bi-house"></i> Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="resultados_examenes.php"><i class="bi bi-clipboard-data"></i> Exámenes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tareas_alumno.php"><i class="bi bi-journal-check"></i> Ejercicios</a>
                </li>
            </ul>
            <span class="navbar-text me-3">
                <?= htmlspecialchars($_SESSION['user_nombre']) ?>
            </span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
        </div>
    </div>
</nav>