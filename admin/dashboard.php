<?php
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';
?>

<h1 class="mb-4">Panel de Administración</h1>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-primary h-100" style="height: 250px !important;">
            <div class="card-body text-center">
                <i class="bi bi-people display-4 text-primary"></i>
                <h5 class="card-title mt-3">Alumnos</h5>
                <p class="card-text">Gestión completa de alumnos registrados</p>
                <a href="alumnos.php" class="btn btn-primary">Ver alumnos</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-success h-100" style="height: 250px !important;">
            <div class="card-body text-center">
                <i class="bi bi-person-badge display-4 text-success"></i>
                <h5 class="card-title mt-3">Profesores</h5>
                <p class="card-text">Consulta y edición de profesores y sus asignaturas</p>
                <a href="profesores.php" class="btn btn-success">Ver profesores</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-secondary h-100" style="height: 250px !important;">
            <div class="card-body text-center">
                <i class="bi bi-diagram-3 display-4 text-secondary"></i>
                <h5 class="card-title mt-3">Cursos</h5>
                <p class="card-text">Gestiona los ciclos y grupos disponibles</p>
                <a href="cursos.php" class="btn btn-secondary">Ver cursos</a>
            </div>
        </div>
    </div>


    <div class="col-md-4">
        <div class="card border-warning h-100" style="height: 250px !important;">
            <div class="card-body text-center">
                <i class="bi bi-journal-bookmark display-4 text-warning"></i>
                <h5 class="card-title mt-3">Asignaturas</h5>
                <p class="card-text">Listado y control de asignaturas impartidas</p>
                <a href="asignaturas.php" class="btn btn-warning">Ver asignaturas</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-danger h-100" style="height: 250px !important;">
            <div class="card-body text-center">
            <i class="bi bi-list-ul display-4 text-danger"></i>
            <h5 class="card-title mt-3">Temas</h5>
            <p class="card-text">Gestiona los temas asociados a cada asignatura.</p>
            <a href="temas.php" class="btn btn-danger">Ver temas</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
  <div class="card border-info h-100" style="height: 250px !important;">
    <div class="card-body text-center">
      <i class="bi bi-lightbulb display-4 text-info"></i>
      <h5 class="card-title mt-3">Ejercicios Propuestos</h5>
      <p class="card-text">Ejercicios clasificados por tema y dificultad.</p>
      <a href="ejercicios_propuestos.php" class="btn btn-info">Ver ejercicios propuestos</a>
    </div>
  </div>
</div>

    <div class="col-md-4 mb-4">
  <div class="card border-primary h-100" style="height: 250px !important;">
    <div class="card-body text-center">
      <i class="bi bi-tags display-4 text-primary"></i>
      <h5 class="card-title mt-3">Etiquetas</h5>
      <p class="card-text">Etiquetas para clasificar ejercicios.</p>
      <a href="etiquetas.php" class="btn btn-primary">Ver etiquetas</a>
    </div>
  </div>
</div>

    <div class="col-md-4">
        <div class="card border-success h-100" style="height: 250px !important;">
            <div class="card-body text-center">
                <i class="bi bi-file-earmark-text display-4 text-success"></i>
                <h5 class="card-title mt-3">Exámenes y ejercicios</h5>
                <p class="card-text">Control de pruebas, ejercicios y correcciones</p>
                <a href="examenes.php" class="btn btn-success">Ver exámenes</a>
            </div>
        </div>
    </div>

      <div class="col-md-4">
     <div class="card border-warning h-100" style="height: 250px !important;">
        <div class="card-body text-center">
            <i class="bi bi-journals display-4 text-warning"></i>
             <h5 class="card-title mt-3">Banco de Preguntas</h5>
              <p class="card-text">Banco de preguntas de elección múltiple</p>
            <a href="banco_preguntas.php" class="btn btn-warning">Gestionar Banco de Preguntas</a>
        </div>
    </div>
</div>

    <div class="col-md-4">
        <div class="card border-dark h-100" style="height: 250px !important;">
            <div class="card-body text-center">
                <i class="bi bi-shuffle display-4 text-dark"></i>
                <h5 class="card-title mt-3">Generar Examen</h5>
                <p class="card-text">Crear un examen automáticamente a partir del banco de preguntas.</p>
                <a href="generar_examen.php" class="btn btn-dark">Generar examen</a>
            </div>
        </div>
    </div>

</div>

<?php require_once '../includes/footer.php'; ?>
