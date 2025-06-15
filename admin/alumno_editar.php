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
$stmt = $pdo->prepare("SELECT u.id, u.nombre, u.apellido, u.email, a.curso_id, a.fecha_nacimiento
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
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
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
    $stmt = $pdo->prepare("UPDATE alumnos SET curso_id = ?, fecha_nacimiento = ? WHERE id = ?");
    $stmt->execute([$curso_id, $fecha_nacimiento, $alumno_id]);

    header("Location: alumnos.php");
    exit;
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
        <div class="mb-3">
            <label>Fecha de nacimiento:</label>
            <input type="date" name="fecha_nacimiento" value="<?= $alumno['fecha_nacimiento'] ?>" class="form-control" required>
        </div>

        <button class="btn btn-primary">Guardar cambios</button>
        <a href="alumnos.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
