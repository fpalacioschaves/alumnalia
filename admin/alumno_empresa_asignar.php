<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';

// Obtener lista de cursos y empresas
$cursos = $pdo->query("SELECT id, nombre FROM cursos ORDER BY nombre")->fetchAll();
$empresas = $pdo->query("SELECT id, nombre FROM empresas ORDER BY nombre")->fetchAll();

$curso_id = $_GET['curso_id'] ?? null;
$alumnos = [];

if ($curso_id && is_numeric($curso_id)) {
    $stmt = $pdo->prepare("SELECT u.id, u.nombre, u.apellido FROM alumnos a JOIN usuarios u ON a.id = u.id WHERE a.curso_id = ?");
    $stmt->execute([$curso_id]);
    $alumnos = $stmt->fetchAll();
}

// Procesar asignación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alumno_id = $_POST['alumno_id'];
    $empresa_id = $_POST['empresa_id'];
    $fecha_inicio = $_POST['fecha_inicio'] ?? null;
    $fecha_fin = $_POST['fecha_fin'] ?? null;
    $tutor_nombre = $_POST['tutor_nombre'];
    $tutor_email = $_POST['tutor_email'];
    $tutor_telefono = $_POST['tutor_telefono'];

    // Evitar duplicados
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM alumnos_empresas WHERE alumno_id = ? AND empresa_id = ?");
    $stmt->execute([$alumno_id, $empresa_id]);
    if ($stmt->fetchColumn() == 0) {
        $stmt = $pdo->prepare("
            INSERT INTO alumnos_empresas 
            (alumno_id, empresa_id, fecha_inicio, fecha_fin, tutor_nombre, tutor_email, tutor_telefono)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $alumno_id,
            $empresa_id,
            $fecha_inicio ?: null,
            $fecha_fin ?: null,
            $tutor_nombre,
            $tutor_email,
            $tutor_telefono
        ]);
        echo "<div class='alert alert-success container mt-3'>✅ Alumno asignado correctamente a la empresa.</div>";
    } else {
        echo "<div class='alert alert-warning container mt-3'>ℹ️ Este alumno ya está asignado a esta empresa.</div>";
    }
}
?>

<div class="container mt-4">
    <h2>Asignar alumno a empresa</h2>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-6">
            <label class="form-label">Seleccionar curso</label>
            <select name="curso_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Elegir curso --</option>
                <?php foreach ($cursos as $curso): ?>
                    <option value="<?= $curso['id'] ?>" <?= $curso_id == $curso['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($curso['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <?php if ($curso_id && $alumnos): ?>
    <form method="POST" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Alumno</label>
            <select name="alumno_id" class="form-select" required>
                <?php foreach ($alumnos as $a): ?>
                    <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nombre'] . ' ' . $a['apellido']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Empresa</label>
            <select name="empresa_id" class="form-select" required>
                <option value="">-- Elegir empresa --</option>
                <?php foreach ($empresas as $e): ?>
                    <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label">Fecha inicio</label>
            <input type="date" name="fecha_inicio" class="form-control">
        </div>

        <div class="col-md-2">
            <label class="form-label">Fecha fin</label>
            <input type="date" name="fecha_fin" class="form-control">
        </div>

        <hr class="mt-4">

        <div class="col-md-4">
            <label class="form-label">Tutor de empresa</label>
            <input type="text" name="tutor_nombre" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Email del tutor</label>
            <input type="email" name="tutor_email" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Teléfono del tutor</label>
            <input type="text" name="tutor_telefono" class="form-control">
        </div>

        <div class="col-12">
            <button class="btn btn-primary">Asignar empresa</button>
        </div>
    </form>
    <?php elseif ($curso_id): ?>
        <div class="alert alert-info mt-3">Este curso no tiene alumnos registrados.</div>
    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-outline-secondary mt-4">← Volver</a>
</div>

<?php require_once '../includes/footer.php'; ?>
