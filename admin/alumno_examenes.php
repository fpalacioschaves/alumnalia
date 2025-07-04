<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

$alumno_id = $_GET['id'] ?? null;
if (!$alumno_id || !is_numeric($alumno_id)) {
    header("Location: alumnos.php");
    exit;
}

// Obtener datos del alumno y su curso
$stmt = $pdo->prepare("
    SELECT u.nombre, u.apellido, c.nombre AS curso, a.curso_id
    FROM alumnos a
    JOIN usuarios u ON a.id = u.id
    JOIN cursos c ON a.curso_id = c.id
    WHERE a.id = ?
");
$stmt->execute([$alumno_id]);
$alumno = $stmt->fetch();

if (!$alumno) {
    header("Location: alumnos.php");
    exit;
}

// Obtener exámenes de su curso (por asignaturas)
$stmt = $pdo->prepare("
    SELECT e.id, e.titulo, e.fecha, e.tipo, a.nombre AS asignatura
    FROM examenes e
    JOIN asignaturas a ON e.asignatura_id = a.id
    WHERE a.curso_id = ?
    ORDER BY e.fecha DESC
");
$stmt->execute([$alumno['curso_id']]);
$examenes = $stmt->fetchAll();

// Obtener calificaciones finales del alumno
$stmt = $pdo->prepare("
    SELECT examen_id, nota_total
    FROM notas_examen_alumno
    WHERE alumno_id = ?
");
$stmt->execute([$alumno_id]);
$notas_finales = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Obtener máximos por examen
$maximos = [];
foreach ($examenes as $ex) {
    $stmt = $pdo->prepare("SELECT id, puntuacion FROM ejercicios WHERE examen_id = ?");
    $stmt->execute([$ex['id']]);
    $maximos[$ex['id']] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}

require_once '../includes/header.php';
?>

<h2 class="mt-4">Exámenes de <?= htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']) ?> (<?= htmlspecialchars($alumno['curso']) ?>)</h2>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>Examen</th>
            <th>Asignatura</th>
            <th>Fecha</th>
            <th>Tipo</th>
            <th>Nota</th>
     
            <th>Detalle</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($examenes as $ex): 
            $total = $notas_finales[$ex['id']] ?? null;

            if ($total !== null) {
               
                
             
            } else {
                $total = 0;
            
            }
        ?>
        <tr>
            <td><?= htmlspecialchars($ex['titulo']) ?></td>
            <td><?= htmlspecialchars($ex['asignatura']) ?></td>
            <td><?= htmlspecialchars($ex['fecha']) ?></td>
            <td><?= ucfirst($ex['tipo']) ?></td>
            <td><?= number_format($total, 2) ?></td>
         
            <td>
                <a href="calificaciones.php?examen_id=<?= $ex['id'] ?>" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-clipboard-check"></i> Ver
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="alumnos.php" class="btn btn-secondary">← Volver a alumnos</a>

<?php require_once '../includes/footer.php'; ?>
