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
  <h2>Tutor IA</h2>
  <p class="text-muted">Pregunta lo que quieras sobre la materia. Ej.: <em>¿Qué es una subconsulta en SQL?</em></p>

  <div class="mb-3">
    <textarea id="pregunta" class="form-control" rows="3" placeholder="Escribe tu pregunta..."></textarea>
  </div>
  <button id="btnEnviar" class="btn btn-primary mb-3">
    <i class="bi bi-send"></i> Preguntar
  </button>

  <div id="respuesta" class="card d-none">
    <div class="card-body" id="respuestaContenido"></div>
  </div>
</div>

<script>
document.getElementById('btnEnviar').addEventListener('click', () => {
  const pregunta = document.getElementById('pregunta').value;
  const respuestaDiv = document.getElementById('respuesta');
  const contenido = document.getElementById('respuestaContenido');

  if (!pregunta.trim()) return;

  contenido.innerHTML = "⏳ Esperando respuesta...";
  respuestaDiv.classList.remove('d-none');

  fetch('ia_chat_alumno.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'pregunta=' + encodeURIComponent(pregunta)
  })
  .then(res => res.text())
  .then(html => contenido.innerHTML = html)
  .catch(() => contenido.innerHTML = "⚠️ Error al contactar con el tutor IA.");
});
</script>

<?php require_once '../includes/footer.php'; ?>
