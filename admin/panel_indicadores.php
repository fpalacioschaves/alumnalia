<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';

// Indicadores generales
$total_alumnos = $pdo->query("SELECT COUNT(*) FROM alumnos")->fetchColumn();
$total_profesores = $pdo->query("SELECT COUNT(*) FROM profesores")->fetchColumn();
$total_asignaturas = $pdo->query("SELECT COUNT(*) FROM asignaturas")->fetchColumn();
$total_examenes = $pdo->query("SELECT COUNT(*) FROM examenes")->fetchColumn();
$total_actividades = $pdo->query("SELECT COUNT(*) FROM actividades")->fetchColumn();
$total_ejercicios_asignados = $pdo->query("SELECT COUNT(*) FROM ejercicios_propuestos")->fetchColumn();

// Nota media por asignatura
$medias_asignaturas = $pdo->query("
    SELECT a.nombre AS asignatura,
           ROUND(AVG(nea.nota_total), 2) AS media_asignatura
    FROM notas_examen_alumno nea
    JOIN examenes ex ON nea.examen_id = ex.id
    JOIN asignaturas a ON ex.asignatura_id = a.id
    GROUP BY a.id, a.nombre
    ORDER BY media_asignatura DESC
")->fetchAll();

// Nota media por examen
$medias_examenes = $pdo->query("
    SELECT ex.id AS examen_id, ex.titulo, a.nombre AS asignatura,
           ROUND(AVG(nea.nota_total), 2) AS nota_media
    FROM notas_examen_alumno nea
    JOIN examenes ex ON nea.examen_id = ex.id
    JOIN asignaturas a ON ex.asignatura_id = a.id
    GROUP BY ex.id, ex.titulo, a.nombre
    ORDER BY nota_media ASC
")->fetchAll();

// Nota media por actividad
$medias_actividades = $pdo->query("
    SELECT ac.titulo, asig.nombre AS asignatura, ROUND(AVG(aa.nota), 2) AS nota_media
    FROM actividades_alumnos aa
    JOIN actividades ac ON aa.actividad_id = ac.id
    JOIN asignaturas asig ON ac.asignatura_id = asig.id
    GROUP BY ac.id, ac.titulo, asig.nombre
    ORDER BY nota_media ASC
")->fetchAll();
?>

<div class="container mt-4">
    <h1 class="mb-4">Panel de Indicadores</h1>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card text-bg-primary text-center">
                <div class="card-body">
                    <h5 class="card-title">Alumnos registrados</h5>
                    <p class="display-5 fw-bold"><?= $total_alumnos ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success text-center">
                <div class="card-body">
                    <h5 class="card-title">Profesores</h5>
                    <p class="display-5 fw-bold"><?= $total_profesores ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-secondary text-center">
                <div class="card-body">
                    <h5 class="card-title">Asignaturas</h5>
                    <p class="display-5 fw-bold"><?= $total_asignaturas ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card text-bg-warning text-center">
                <div class="card-body">
                    <h5 class="card-title">Exámenes creados</h5>
                    <p class="display-5 fw-bold"><?= $total_examenes ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card text-bg-warning text-center">
                <div class="card-body">
                    <h5 class="card-title">Actividades creadas</h5>
                    <p class="display-5 fw-bold"><?= $total_actividades ?></p>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card text-bg-danger text-center">
                <div class="card-body">
                    <h5 class="card-title">Ejercicios asignados</h5>
                    <p class="display-5 fw-bold"><?= $total_ejercicios_asignados ?></p>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-5">📊 Media de calificaciones por asignatura</h3>
    <table class="table table-striped">
        <thead class="table-light">
            <tr>
                <th>Asignatura</th>
                <th>Media</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medias_asignaturas as $fila): ?>
                <tr>
                    <td><?= htmlspecialchars($fila['asignatura']) ?></td>
                    <td><?= $fila['media_asignatura'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3 class="mt-5">📘 Nota media por examen</h3>
    <canvas id="graficoExamenes" height="100"></canvas>

    <h3 class="mt-5">📒 Nota media por actividad</h3>
    <canvas id="graficoActividades" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const canvas2 = document.getElementById('graficoExamenes');
if (canvas2) {
    const ctx2 = canvas2.getContext('2d');
    const examenes = <?= json_encode(array_column($medias_examenes, 'titulo')) ?>;
    const mediasExamenes = <?= json_encode(array_column($medias_examenes, 'nota_media')) ?>;
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: examenes,
            datasets: [{
                label: 'Nota media examen',
                data: mediasExamenes,
                backgroundColor: '#1d3557'
            }]
        },
        options: {
            indexAxis: 'y',
            scales: { x: { beginAtZero: true, max: 10 } }
        }
    });
}

const canvas3 = document.getElementById('graficoActividades');
if (canvas3) {
    const ctx3 = canvas3.getContext('2d');
    const actividades = <?= json_encode(array_column($medias_actividades, 'titulo')) ?>;
    const mediasActividades = <?= json_encode(array_column($medias_actividades, 'nota_media')) ?>;
    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: actividades,
            datasets: [{
                label: 'Nota media actividad',
                data: mediasActividades,
                backgroundColor: '#2a9d8f'
            }]
        },
        options: {
            indexAxis: 'y',
            scales: { x: { beginAtZero: true, max: 10 } }
        }
    });
}
</script>

<?php require_once '../includes/footer.php'; ?>