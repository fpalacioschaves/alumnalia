
<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

require_once '../includes/header.php';

$alumno_id = $_GET['id'] ?? null;
if (!$alumno_id || !is_numeric($alumno_id)) {
    header("Location: alumnos.php");
    exit;
}

// Obtener datos básicos del alumno
$stmt = $pdo->prepare("SELECT u.id, u.nombre, u.apellido, u.email, a.curso_id
                       FROM alumnos a
                       JOIN usuarios u ON a.id = u.id
                       WHERE a.id = ?");
$stmt->execute([$alumno_id]);
$alumno = $stmt->fetch();
if (!$alumno) {
    header("Location: alumnos.php");
    exit;
}

// Obtener empresa asignada (si existe)
$stmt = $pdo->prepare("SELECT ae.*, e.nombre AS empresa_nombre
                       FROM alumnos_empresa ae
                       JOIN empresas e ON ae.empresa_id = e.id
                       WHERE ae.alumno_id = ?");
$stmt->execute([$alumno_id]);
$empresa = $stmt->fetch();

// Obtener asignaturas del curso del alumno
$stmt = $pdo->prepare("SELECT * FROM asignaturas WHERE curso_id = ?");
$stmt->execute([$alumno['curso_id']]);
$asignaturas = $stmt->fetchAll();

// Obtener RA de esas asignaturas
$ra_por_asignatura = [];
foreach ($asignaturas as $asig) {
    $stmt = $pdo->prepare("SELECT * FROM resultados_aprendizaje WHERE asignatura_id = ?");
    $stmt->execute([$asig['id']]);
    $ra_por_asignatura[$asig['id']] = $stmt->fetchAll();
}

// Obtener RA ya marcados como trabajados por esa empresa
$ra_trabajados = [];
if ($empresa) {
    $stmt = $pdo->prepare("SELECT resultado_aprendizaje_id FROM ra_empresa_trabajados WHERE empresa_id = ?");
    $stmt->execute([$empresa['empresa_id']]);
    $ra_trabajados = array_column($stmt->fetchAll(), 'resultado_aprendizaje_id');
}
?>

<div class="container mt-4">
    <h2>Ficha del alumno: <?= htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']) ?></h2>
    <p>Email: <?= htmlspecialchars($alumno['email']) ?></p>

    <?php if ($empresa): ?>
        <h4 class="mt-4">Empresa asignada</h4>
        <ul>
            <li><strong>Empresa:</strong> <?= htmlspecialchars($empresa['empresa_nombre']) ?></li>
            <li><strong>Tutor de empresa:</strong> <?= htmlspecialchars($empresa['tutor']) ?></li>
            <li><strong>Email tutor:</strong> <?= htmlspecialchars($empresa['email']) ?></li>
            <li><strong>Teléfono tutor:</strong> <?= htmlspecialchars($empresa['telefono']) ?></li>
            <li><strong>Fechas:</strong> <?= htmlspecialchars($empresa['fecha_inicio']) ?> a <?= htmlspecialchars($empresa['fecha_fin']) ?></li>
        </ul>

        <h5 class="mt-4">Resultados de Aprendizaje trabajados en la empresa</h5>
        <form action="guardar_ra_trabajados.php" method="POST">
            <input type="hidden" name="empresa_id" value="<?= $empresa['empresa_id'] ?>">
            <?php foreach ($asignaturas as $asig): ?>
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong><?= htmlspecialchars($asig['nombre']) ?></strong>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($ra_por_asignatura[$asig['id']])): ?>
                            <?php foreach ($ra_por_asignatura[$asig['id']] as $ra): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           name="ra_ids[]"
                                           value="<?= $ra['id'] ?>"
                                           <?= in_array($ra['id'], $ra_trabajados) ? 'checked' : '' ?>>
                                    <label class="form-check-label">
                                        <?= htmlspecialchars($ra['codigo']) ?> - <?= htmlspecialchars($ra['descripcion']) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">Sin RA definidos para esta asignatura.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">Guardar RA trabajados</button>
        </form>
    <?php else: ?>
        <div class="alert alert-warning mt-4">Este alumno no tiene empresa asignada.</div>
    <?php endif; ?>

    <a href="alumnos.php" class="btn btn-secondary mt-4">← Volver al listado</a>
</div>

<?php require_once '../includes/footer.php'; ?>
