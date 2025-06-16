<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'alumno') {
  //  header('Location: index.php');
    exit;
}

$alumno_id = $_SESSION['usuario_id'];
$nombre = $_SESSION['user_nombre'];
$apellido = $_SESSION['user_apellido'] ?? '';
require_once 'header.php';
?>

<div class="container mt-4">
    <h2 class="mb-4">Bienvenido, <? echo  htmlspecialchars($nombre); ?> <? echo htmlspecialchars($apellido); ?> </h2>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-clipboard-data" style="font-size: 2rem;"></i>
                    <h5 class="card-title mt-2">Exámenes</h5>
                    <p class="card-text">Consulta tus resultados de exámenes realizados.</p>
                    <a href="resultados_examenes.php" class="btn btn-outline-primary btn-sm">Ver exámenes</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-journal-check" style="font-size: 2rem;"></i>
                    <h5 class="card-title mt-2">Ejercicios Propuestos</h5>
                    <p class="card-text">Visualiza y gestiona tus tareas de refuerzo asignadas.</p>
                    <a href="tareas_alumno.php" class="btn btn-outline-primary btn-sm">Ver ejercicios</a>
                </div>
            </div>
        </div>
    </div>

    <a href="logout.php" class="btn btn-outline-secondary mt-3">Cerrar sesión</a>
</div>

<?php require_once '../includes/footer.php'; ?>
