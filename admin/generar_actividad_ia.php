<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$alumno_id = $_POST['alumno_id'];
$etiqueta_id = $_POST['etiqueta_id'];
$etiqueta_nombre = $_POST['etiqueta_nombre'];

// Ejemplo de prompt a IA (futuro endpoint o integración)
$prompt = "Genera una actividad de refuerzo para un alumno que falla en el tema: $etiqueta_nombre. El ejercicio debe ser breve, claro y práctico.";

// Simulación de IA con contenido genérico
$actividad = "Actividad generada para reforzar: <strong>$etiqueta_nombre</strong><br><br>" .
             "📌 Enunciado: ...<br>" .
             "📝 Instrucciones: ...<br>" .
             "🎯 Objetivo: Comprender y aplicar correctamente el concepto relacionado con '$etiqueta_nombre'.";

// En versión avanzada, esta actividad se insertaría en la tabla `actividades` o `ejercicios_propuestos`

require_once '../includes/header.php';
?>

<h3>Actividad generada con IA</h3>
<div class="card">
    <div class="card-body">
        <?= $actividad ?>
    </div>
</div>
<a href="alumno_refuerzo.php?id=<?= $alumno_id ?>" class="btn btn-secondary mt-3">← Volver al plan de refuerzo</a>

<?php require_once '../includes/footer.php'; ?>
