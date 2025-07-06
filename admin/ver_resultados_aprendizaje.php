<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();


require_once '../includes/header.php';

// Obtener asignaturas disponibles
$asignaturas = $pdo->query("SELECT a.id, a.nombre, c.nombre AS curso 
    FROM asignaturas a 
    JOIN cursos c ON a.curso_id = c.id 
    ORDER BY c.nombre, a.nombre")->fetchAll();

$asignatura_id = $_GET['asignatura_id'] ?? null;
$resultados = [];

if ($asignatura_id && is_numeric($asignatura_id)) {
    // Obtener RA de la asignatura
    $stmt = $pdo->prepare("SELECT * FROM resultados_aprendizaje WHERE asignatura_id = ? ORDER BY id");
    $stmt->execute([$asignatura_id]);
    $resultados = $stmt->fetchAll();
}
?>

<div class="container mt-4">
    <h2 class="mb-4">Resultados de Aprendizaje y Criterios</h2>

    <form method="GET" class="mb-4 row g-2">
        <div class="col-md-6">
            <label class="form-label">Asignatura</label>
            <select name="asignatura_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Selecciona una asignatura --</option>
                <?php foreach ($asignaturas as $a): ?>
                    <option value="<?= $a['id'] ?>" <?= $a['id'] == $asignatura_id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($a['curso'] . ' - ' . $a['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <?php if ($asignatura_id && $resultados): ?>
        <?php foreach ($resultados as $ra): ?>
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <strong><?= htmlspecialchars($ra['codigo']) ?>:</strong>
                    <?= htmlspecialchars($ra['descripcion']) ?>
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Criterios de evaluación:</h6>
                    <ul>
                        <?php
                        $stmt = $pdo->prepare("SELECT * FROM criterios_evaluacion WHERE resultado_aprendizaje_id = ?");
                        $stmt->execute([$ra['id']]);
                        $criterios = $stmt->fetchAll();
                        foreach ($criterios as $ce): ?>
                            <li><?= htmlspecialchars($ce['descripcion']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    <?php elseif ($asignatura_id): ?>
        <div class="alert alert-warning">No se encontraron resultados de aprendizaje para esta asignatura.</div>
    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-secondary mt-4">← Volver al panel</a>
</div>

<?php require_once '../includes/footer.php'; ?>
