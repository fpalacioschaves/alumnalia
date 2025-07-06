<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'alumno') {
    exit;
}

$alumno_id = $_SESSION['usuario_id'];
$nombre = $_SESSION['user_nombre'];
$apellido = $_SESSION['user_apellido'];
require_once 'header.php';
?>

<div class="container mt-4">
    <h2 class="mb-4">Bienvenido, <?= htmlspecialchars($nombre) ?> <?= htmlspecialchars($apellido) ?></h2>

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

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-event" style="font-size: 2rem;"></i>
                    <h5 class="card-title">Calendario</h5>
                    <p class="card-text">Visualiza tus exámenes y fechas de entrega en un calendario.</p>
                    <a href="calendario.php" class="btn btn-outline-primary btn-sm">Ver calendario</a>
                </div>
            </div>
        </div>

        <!-- NUEVO: Tutor IA -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-robot" style="font-size: 2rem;"></i>
                    <h5 class="card-title">Tutor IA</h5>
                    <p class="card-text">Haz preguntas y recibe ayuda de un tutor inteligente.</p>
                    <a href="chat_ia.php" class="btn btn-outline-success btn-sm">Hablar con el tutor IA</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-building display-4 text-warning"></i>
                    <h5 class="card-title mt-2">Mi Empresa</h5>
                    <p class="card-text">Consulta los datos de la empresa donde realizas la FCT o Dual.</p>
                    <a href="empresa_alumno.php" class="btn btn-outline-warning btn-sm">Ver empresa</a>
                </div>
            </div>
        </div>


    </div>

    <a href="logout.php" class="btn btn-outline-secondary mt-3">Cerrar sesión</a>
</div>

<?php require_once '../includes/footer.php'; ?>

