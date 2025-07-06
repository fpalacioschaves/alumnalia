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

// Obtener datos del alumno
$stmt = $pdo->prepare("SELECT u.id, u.nombre, u.apellido, u.email, a.curso_id
                       FROM usuarios u
                       JOIN alumnos a ON u.id = a.id
                       WHERE u.id = ?");
$stmt->execute([$alumno_id]);
$alumno = $stmt->fetch();

if (!$alumno) {
    header("Location: alumnos.php");
    exit;
}

// Obtener cursos disponibles
$cursos = $pdo->query("SELECT id, nombre FROM cursos ORDER BY nombre")->fetchAll();

// Guardar cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $curso_id = $_POST['curso_id'] ?? null;
    $password = $_POST['password'] ?? '';

    // Actualizar usuarios
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, email = ?, password_hash = ? WHERE id = ?");
        $stmt->execute([$nombre, $apellido, $email, $password_hash, $alumno_id]);
    } else {
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, email = ? WHERE id = ?");
        $stmt->execute([$nombre, $apellido, $email, $alumno_id]);
    }

    // Actualizar alumnos
    $stmt = $pdo->prepare("UPDATE alumnos SET curso_id = ? WHERE id = ?");
    $stmt->execute([$curso_id,$alumno_id]);


}
?>


    <h2 class="mt-5">Editar alumno</h2>

    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($alumno['nombre']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Apellido:</label>
            <input type="text" name="apellido" value="<?= htmlspecialchars($alumno['apellido']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($alumno['email']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Contraseña nueva (opcional):</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>Curso:</label>
            <select name="curso_id" class="form-select" required>
                <option value="">-- Selecciona curso --</option>
                <?php foreach ($cursos as $curso): ?>
                    <option value="<?= $curso['id'] ?>" <?= $curso['id'] == $alumno['curso_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($curso['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>


        <button class="btn btn-primary">Guardar cambios</button>
        <a href="alumnos.php" class="btn btn-secondary">Cancelar</a>
    </form>


    <hr>
<h4 class="mt-5">Información de empresa en Dual</h4>

<?php
// Obtener información de empresa y tutor
$stmt = $pdo->prepare("SELECT ae.*, e.nombre AS empresa_nombre 
                       FROM alumnos_empresas ae 
                       JOIN empresas e ON ae.empresa_id = e.id 
                       WHERE ae.alumno_id = ?");
$stmt->execute([$alumno_id]);
$empresa_asignada = $stmt->fetch();

// Obtener lista de empresas
$empresas = $pdo->query("SELECT id, nombre FROM empresas ORDER BY nombre")->fetchAll();
?>

<form method="POST" action="guardar_empresa_dual.php">
    <input type="hidden" name="alumno_id" value="<?= $alumno_id ?>">

    <div class="mb-3">
        <label>Empresa:</label>
        <select name="empresa_id" class="form-select" required>
            <option value="">-- Selecciona empresa --</option>
            <?php foreach ($empresas as $empresa): ?>
                <option value="<?= $empresa['id'] ?>" <?= $empresa_asignada && $empresa_asignada['empresa_id'] == $empresa['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($empresa['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Tutor de empresa (nombre):</label>
        <input type="text" name="tutor_nombre" value="<?= htmlspecialchars($empresa_asignada['tutor_nombre'] ?? '') ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label>Tutor de empresa (email):</label>
        <input type="email" name="tutor_email" value="<?= htmlspecialchars($empresa_asignada['tutor_email'] ?? '') ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label>Tutor de empresa (teléfono):</label>
        <input type="text" name="tutor_telefono" value="<?= htmlspecialchars($empresa_asignada['tutor_telefono'] ?? '') ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label>Fecha de inicio:</label>
        <input type="date" name="fecha_inicio" value="<?= $empresa_asignada['fecha_inicio'] ?? '' ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label>Fecha de fin:</label>
        <input type="date" name="fecha_fin" value="<?= $empresa_asignada['fecha_fin'] ?? '' ?>" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Guardar datos empresa</button>
</form>

<hr>
<h4 class="mt-5">Resultados de Aprendizaje en empresa</h4>

<?php
// Obtener RA del curso del alumno
$stmt = $pdo->prepare("SELECT ra.id, ra.descripcion, a.nombre AS asignatura
                       FROM resultados_aprendizaje ra
                       JOIN asignaturas a ON ra.asignatura_id = a.id
                       WHERE a.curso_id = ?
                       ORDER BY a.nombre, ra.id");
$stmt->execute([$alumno['curso_id']]);
$resultados = $stmt->fetchAll();

// Obtener RA ya marcados como trabajados
$stmt = $pdo->prepare("SELECT ra_id FROM ra_empresa_alumno WHERE alumno_id = ?");
$stmt->execute([$alumno_id]);
$ra_trabajados = array_column($stmt->fetchAll(), 'ra_id');
?>

<form method="POST" action="guardar_ra_alumno.php">
    <input type="hidden" name="alumno_id" value="<?= $alumno_id ?>">
    <input type="hidden" name="empresa_id" value="<?= $empresa_asignada['empresa_id'] ?>">

    <?php foreach ($resultados as $ra): ?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="ra_ids[]" value="<?= $ra['id'] ?>" 
                <?= in_array($ra['id'], $ra_trabajados) ? 'checked' : '' ?>>
            <label class="form-check-label">
                <strong><?= htmlspecialchars($ra['asignatura']) ?>:</strong> <?= htmlspecialchars($ra['descripcion']) ?>
            </label>
        </div>
    <?php endforeach; ?>

    <button type="submit" class="btn btn-primary mt-3">Guardar RA trabajados</button>
</form>




</body>
</html>
