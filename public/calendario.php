<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'alumno') {
  //  header('Location: index.php');
    exit;
}

$alumno_id = $_SESSION['usuario_id'];
$nombre = $_SESSION['user_nombre'];
$apellido = $_SESSION['user_apellido'] ;
require_once 'header.php';
?>


<h2 class="mt-4">Calendario de Actividades</h2>
<div class="container mt-4">
<div id="calendar"></div>

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

<!-- Modal -->
<div class="modal fade" id="eventoModal" tabindex="-1" aria-labelledby="eventoTitulo" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventoTitulo"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="eventoContenido">
        <!-- contenido dinámico -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
</div>
<!-- FullCalendar JS y bootstrap JS se cargan al final -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/calendario.js"></script>

<?php require_once '../includes/footer.php'; ?>
