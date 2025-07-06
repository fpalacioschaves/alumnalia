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
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="estructuraDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-diagram-3"></i> Estructura Académica
            </a>
            <ul class="dropdown-menu" aria-labelledby="estructuraDropdown">
                <li><a class="dropdown-item" href="cursos.php">Cursos</a></li>
                <li><a class="dropdown-item" href="asignaturas.php">Asignaturas</a></li>
                <li><a class="dropdown-item" href="temas.php">Temas</a></li>
                <li><a class="dropdown-item" href="ver_resultados_aprendizaje.php">Resultados de Aprendizaje</a></li>
                <li><a class="dropdown-item" href="etiquetas.php">Etiquetas</a></li>
            </ul>
        </li>

          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="evaluacionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-journals"></i> Pruebas
          </a>
          <ul class="dropdown-menu" aria-labelledby="evaluacionDropdown">
            <li><a class="dropdown-item" href="examenes.php">Exámenes</a></li>
            <li><a class="dropdown-item" href="actividades.php">Actividades</a></li>
            <li><a class="dropdown-item" href="ver_asistencia.php">Ver Asistencia</a></li>
            <li><a class="dropdown-item" href="ejercicios_propuestos.php">Ejercicios Propuestos</a></li>
            <li><a class="dropdown-item" href="banco_preguntas.php">Banco de Preguntas</a></li>
            <li><a class="dropdown-item" href="generar_examen.php">Generar Examen</a></li>

          </ul>
        </li>

       

        <li class="nav-item">
          <a class="nav-link" href="evaluaciones.php"><i class="bi bi-graph-up-arrow"></i> Evaluaciones</a>
        </li>

        

         <li class="nav-item">
          <a class="nav-link" href="panel_indicadores.php"><i class="bi bi-bar-chart-line"></i> Indicadores</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="empresaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-building"></i> Empresas
          </a>
          <ul class="dropdown-menu" aria-labelledby="empresaDropdown">
            <li><a class="dropdown-item" href="empresas.php">Listado de empresas</a></li>
            <li><a class="dropdown-item" href="alumno_empresa_asignar.php">Asignar alumno a empresa</a></li>
          </ul>
        </li>




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
