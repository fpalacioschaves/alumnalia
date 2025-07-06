<?php
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';
?>

<h1 class="mb-4">Panel de Administración</h1>

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">

    <!-- Alumnos -->
    <div class="col">
        <div class="card border-primary h-100">
            <div class="card-body text-center">
                <i class="bi bi-people display-4 text-primary"></i>
                <h5 class="card-title mt-3">Alumnos</h5>
                <p class="card-text">Gestión completa de alumnos registrados</p>
                <a href="alumnos.php" class="btn btn-primary">Ver alumnos</a>
            </div>
        </div>
    </div>

    <!-- Profesores -->
    <div class="col">
        <div class="card border-success h-100">
            <div class="card-body text-center">
                <i class="bi bi-person-badge display-4 text-success"></i>
                <h5 class="card-title mt-3">Profesores</h5>
                <p class="card-text">Consulta y edición de profesores y sus asignaturas</p>
                <a href="profesores.php" class="btn btn-success">Ver profesores</a>
            </div>
        </div>
    </div>

    <!-- Cursos -->
    <div class="col">
        <div class="card border-secondary h-100">
            <div class="card-body text-center">
                <i class="bi bi-diagram-3 display-4 text-secondary"></i>
                <h5 class="card-title mt-3">Cursos</h5>
                <p class="card-text">Gestiona los ciclos y grupos disponibles</p>
                <a href="cursos.php" class="btn btn-secondary">Ver cursos</a>
            </div>
        </div>
    </div>

    <!-- Asignaturas -->
    <div class="col">
        <div class="card border-warning h-100">
            <div class="card-body text-center">
                <i class="bi bi-journal-bookmark display-4 text-warning"></i>
                <h5 class="card-title mt-3">Asignaturas</h5>
                <p class="card-text">Listado y control de asignaturas impartidas</p>
                <a href="asignaturas.php" class="btn btn-warning">Ver asignaturas</a>
            </div>
        </div>
    </div>

    <!-- Temas -->
    <div class="col">
        <div class="card border-danger h-100">
            <div class="card-body text-center">
                <i class="bi bi-list-ul display-4 text-danger"></i>
                <h5 class="card-title mt-3">Temas</h5>
                <p class="card-text">Gestiona los temas asociados a cada asignatura.</p>
                <a href="temas.php" class="btn btn-danger">Ver temas</a>
            </div>
        </div>
    </div>

        <!-- Etiquetas -->
    <div class="col">
        <div class="card border-primary h-100">
            <div class="card-body text-center">
                <i class="bi bi-tags display-4 text-primary"></i>
                <h5 class="card-title mt-3">Etiquetas</h5>
                <p class="card-text">Etiquetas para clasificar ejercicios.</p>
                <a href="etiquetas.php" class="btn btn-primary">Ver etiquetas</a>
            </div>
        </div>
    </div>

        <!-- Exámenes -->
    <div class="col">
        <div class="card border-success h-100">
            <div class="card-body text-center">
                <i class="bi bi-file-earmark-text display-4 text-success"></i>
                <h5 class="card-title mt-3">Exámenes</h5>
                <p class="card-text">Control de pruebas, ejercicios y correcciones</p>
                <a href="examenes.php" class="btn btn-success">Ver exámenes</a>
            </div>
        </div>
    </div>

      <!-- Generar examen -->
    <div class="col">
        <div class="card border-dark h-100">
            <div class="card-body text-center">
                <i class="bi bi-shuffle display-4 text-dark"></i>
                <h5 class="card-title mt-3">Generar Examen</h5>
                <p class="card-text">Crear un examen automáticamente a partir del banco de preguntas.</p>
                <a href="generar_examen.php" class="btn btn-dark">Generar examen</a>
            </div>
        </div>
    </div>



    <!-- Ejercicios Propuestos -->
    <div class="col">
        <div class="card border-info h-100">
            <div class="card-body text-center">
                <i class="bi bi-lightbulb display-4 text-info"></i>
                <h5 class="card-title mt-3">Ejercicios Propuestos</h5>
                <p class="card-text">Ejercicios clasificados por tema y dificultad.</p>
                <a href="ejercicios_propuestos.php" class="btn btn-info">Ver ejercicios propuestos</a>
            </div>
        </div>
    </div>

    <!-- Banco de Preguntas -->
    <div class="col">
        <div class="card border-warning h-100">
            <div class="card-body text-center">
                <i class="bi bi-journals display-4 text-warning"></i>
                <h5 class="card-title mt-3">Banco de Preguntas</h5>
                <p class="card-text">Banco de preguntas de elección múltiple</p>
                <a href="banco_preguntas.php" class="btn btn-warning">Gestionar Banco de Preguntas</a>
            </div>
        </div>
    </div>



  

    <!-- Actividades -->
    <div class="col">
        <div class="card border-primary h-100">
            <div class="card-body text-center">
                <i class="bi bi-clipboard-data display-4 text-primary"></i>
                <h5 class="card-title mt-3">Actividades</h5>
                <p class="card-text">Gestión de actividades y entregas por curso y asignatura</p>
                <a href="actividades.php" class="btn btn-primary">Ver actividades</a>
            </div>
        </div>
    </div>

    <!-- Evaluaciones -->
    <div class="col">
        <div class="card border-dark h-100">
            <div class="card-body text-center">
                <i class="bi bi-bar-chart display-4 text-dark"></i>
                <h5 class="card-title mt-3">Evaluaciones</h5>
                <p class="card-text">Gestiona las evaluaciones, ponderaciones y notas finales por curso y asignatura.</p>
                <a href="evaluaciones.php" class="btn btn-dark">Ver evaluaciones</a>
            </div>
        </div>
    </div>

    <!-- Resultados de Aprendizaje -->
    <div class="col">
        <div class="card border-info h-100">
            <div class="card-body text-center">
                <i class="bi bi-check2-square display-4 text-info"></i>
                <h5 class="card-title mt-3">Resultados de Aprendizaje</h5>
                <p class="card-text">Consulta y gestión de los resultados de aprendizaje del ciclo formativo.</p>
                <a href="resultados_aprendizaje.php" class="btn btn-info">Ver resultados</a>
            </div>
        </div>
    </div>



    <!-- Resumen RA -->
    <div class="col">
        <div class="card border-secondary h-100">
            <div class="card-body text-center">
                <i class="bi bi-list-check display-4 text-secondary"></i>
                <h5 class="card-title mt-3">Resumen RA por alumno</h5>
                <p class="card-text">Consulta qué RA ha trabajado cada alumno en la empresa asignada.</p>
                <a href="resumen_ra_alumnos.php" class="btn btn-outline-secondary">Ver resumen</a>
            </div>
        </div>
    </div>

        <!-- Empresas -->
    <div class="col">
        <div class="card border-warning h-100">
            <div class="card-body text-center">
                <i class="bi bi-building display-4 text-warning"></i>
                <h5 class="card-title mt-3">Empresas</h5>
                <p class="card-text">Gestiona las empresas colaboradoras y la asignación de alumnos en FCT o Dual.</p>
                <a href="empresas.php" class="btn btn-warning">Ver empresas</a>
            </div>
        </div>
    </div>

</div>

<?php require_once '../includes/footer.php'; ?>
