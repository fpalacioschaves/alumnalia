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
<style>
#calendar {
    max-width: 900px;
    margin: 20px auto;
    background: #ffffff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.fc-daygrid-day-number {
    font-size: 0.85rem;
    padding: 4px 6px;
    color: #1d3557;
}
.fc-event {
    font-size: 0.75rem;
    padding: 4px 6px;
    border-radius: 6px;
    border: none;
}
.fc-daygrid-day {
    padding: 5px;
    height: 80px;
}
.fc-toolbar-title {
    font-size: 1.2rem;
    color: #1d3557;
}
.fc-button {
    background-color: #457b9d !important;
    border-color: #457b9d !important;
    color: white !important;
    font-size: 0.85rem;
}
.fc-button:hover {
    background-color: #1d3557 !important;
    border-color: #1d3557 !important;
}
</style>
<div class="container mt-4">
<h2 class="mt-4">Calendario de Actividades</h2>
<div id="calendar"></div>

<!-- FullCalendar CSS y JS (versión UMD compatible) -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: 'eventos.php'
    });

    calendar.render();
});
</script>
</div>
<?php require_once '../includes/footer.php'; ?>