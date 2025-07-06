<?php
session_start();
require_once '../includes/db.php';
require_once 'header.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'alumno') {
    header('Location: index.php');
    exit;
}

$alumno_id = $_SESSION['usuario_id'];

// Obtener empresa asignada al alumno
$stmt = $pdo->prepare("
    SELECT ae.empresa_id, e.nombre AS empresa_nombre, ae.tutor_nombre, ae.tutor_email
    FROM alumnos_empresas ae
    JOIN empresas e ON ae.empresa_id = e.id
    WHERE ae.alumno_id = ?
");
$stmt->execute([$alumno_id]);
$empresa = $stmt->fetch();
?>

<div class="container mt-4">
    <h2 class="mb-4">Información de la Empresa Asignada</h2>

    <?php if ($empresa): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">🏢 <?= htmlspecialchars($empresa['empresa_nombre']) ?></h5>
                <p><strong>Tutor de empresa:</strong> <?= htmlspecialchars($empresa['tutor_nombre']) ?></p>
                <p><strong>Email de contacto:</strong> <?= htmlspecialchars($empresa['tutor_email']) ?></p>
            </div>
        </div>

        <?php
        // Obtener RA asociados al alumno en esa empresa, con asignatura
        $stmt = $pdo->prepare("
            SELECT ra.codigo, ra.descripcion, a.nombre AS asignatura
            FROM ra_empresa_alumno rea
            JOIN resultados_aprendizaje ra ON rea.ra_id = ra.id
            JOIN asignaturas a ON ra.asignatura_id = a.id
            WHERE rea.alumno_id = ? AND rea.empresa_id = ?
            ORDER BY a.nombre, ra.codigo
        ");
        $stmt->execute([$alumno_id, $empresa['empresa_id']]);
        $ra_trabajados = $stmt->fetchAll();
        ?>

        <h4>Resultados de Aprendizaje trabajados</h4>
        <?php if ($ra_trabajados): ?>
            <?php
            $agrupados = [];
            foreach ($ra_trabajados as $ra) {
                $agrupados[$ra['asignatura']][] = $ra;
            }
            ?>
            <?php foreach ($agrupados as $asignatura => $ras): ?>
                <h5 class="mt-4"><?= htmlspecialchars($asignatura) ?></h5>
                <ul class="list-group mb-3">
                    <?php foreach ($ras as $ra): ?>
                        <li class="list-group-item">
                            <strong><?= htmlspecialchars($ra['codigo']) ?>:</strong>
                            <?= htmlspecialchars($ra['descripcion']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">No se han registrado RA trabajados en la empresa todavía.</div>
        <?php endif; ?>

    <?php else: ?>
        <div class="alert alert-warning">No tienes una empresa asignada actualmente.</div>
    <?php endif; ?>

    <a href="panel_alumno.php" class="btn btn-outline-secondary">← Volver al panel</a>
</div>

<?php require_once '../includes/footer.php'; ?>