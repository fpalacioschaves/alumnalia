<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once '../includes/header.php';
redirigir_si_no_autenticado();
solo_admin();

$mensaje = '';
$profesor_id = $_GET['id'] ?? null;

if (!$profesor_id) {
    header("Location: profesores.php");
    exit;
}

// Obtener profesor actual
$stmt = $pdo->prepare("SELECT u.id, u.nombre, u.apellido, u.email, p.departamento
                       FROM usuarios u
                       JOIN profesores p ON u.id = p.id
                       WHERE u.id = ?");
$stmt->execute([$profesor_id]);
$profesor = $stmt->fetch();

if (!$profesor) {
    header("Location: profesores.php");
    exit;
}

// Obtener asignaturas
$asignaturas = $pdo->query("SELECT id, nombre FROM asignaturas ORDER BY nombre")->fetchAll();

// Asignaturas del profesor
$stmt = $pdo->prepare("SELECT asignatura_id FROM profesor_asignatura WHERE profesor_id = ?");
$stmt->execute([$profesor_id]);
$asignaturas_actuales = array_column($stmt->fetchAll(), 'asignatura_id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $nueva_password = $_POST['password'] ?? '';
    $asignaturas_seleccionadas = $_POST['asignaturas'] ?? [];

    // Actualizar usuario
    if (!empty($nueva_password)) {
        $hash = password_hash($nueva_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, email = ?, password_hash = ? WHERE id = ?");
        $stmt->execute([$nombre, $apellido, $email, $hash, $profesor_id]);
    } else {
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, email = ? WHERE id = ?");
        $stmt->execute([$nombre, $apellido, $email, $profesor_id]);
    }

    // Actualizar profesor
    $stmt = $pdo->prepare("UPDATE profesores SET departamento = ? WHERE id = ?");
    $stmt->execute([$departamento, $profesor_id]);

    // Actualizar asignaturas
    $pdo->prepare("DELETE FROM profesor_asignatura WHERE profesor_id = ?")->execute([$profesor_id]);

    $stmt = $pdo->prepare("INSERT INTO profesor_asignatura (profesor_id, asignatura_id) VALUES (?, ?)");
    foreach ($asignaturas_seleccionadas as $asig_id) {
        $stmt->execute([$profesor_id, $asig_id]);
    }

    header("Location: profesores.php");
    exit;
}
?>

    <h2 class="mt-5">Editar profesor</h2>

    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($profesor['nombre']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Apellido:</label>
            <input type="text" name="apellido" value="<?= htmlspecialchars($profesor['apellido']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($profesor['email']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Contraseña nueva (opcional):</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>Departamento:</label>
            <input type="text" name="departamento" value="<?= htmlspecialchars($profesor['departamento']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Asignaturas:</label>
            <select name="asignaturas[]" class="form-select" multiple required>
                <?php foreach ($asignaturas as $asig): ?>
                    <option value="<?= $asig['id'] ?>" <?= in_array($asig['id'], $asignaturas_actuales) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($asig['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="btn btn-primary">Guardar cambios</button>
        <a href="profesores.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
