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
$total_ejercicios_asignados = $pdo->query("SELECT COUNT(*) FROM ejercicios_propuestos")->fetchColumn();


// Nota media por asignatura (corregida)
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
")->fetchAll();?>

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
            <?php 
            foreach ($medias_asignaturas as $fila): ?>
                <tr>
                    <td><?= htmlspecialchars($fila['asignatura']) ?></td>
                    <td><?= $fila['media_asignatura'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

     <h3 class="mt-5">📘 Nota media por examen</h3>
    <canvas id="graficoExamenes" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const canvas1 = document.getElementById('graficoAsignaturas');
if (canvas1) {
    const ctx1 = canvas1.getContext('2d');
    const asignaturas = <?= json_encode(array_column($medias_asignaturas, 'asignatura')) ?>;
    const mediasAsignaturas = <?= json_encode(array_column($medias_asignaturas, 'media_asignatura')) ?>;
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: asignaturas,
            datasets: [{
                label: 'Nota media',
                data: mediasAsignaturas,
                backgroundColor: '#457b9d'
            }]
        },
        options: {
            scales: { y: { beginAtZero: true, max: 10 } }
        }
    });
}

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
</script>




</div>

<?php require_once '../includes/footer.php'; ?>
