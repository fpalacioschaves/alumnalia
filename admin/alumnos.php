<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';

// Obtener cursos para el filtro
$cursos = $pdo->query("SELECT id, nombre FROM cursos ORDER BY nombre")->fetchAll();
$curso_id = $_GET['curso_id'] ?? '';

// Consulta con filtro si está seleccionado
if ($curso_id && is_numeric($curso_id)) {
    $stmt = $pdo->prepare("SELECT u.id, u.nombre, u.apellido, u.email, c.nombre AS curso
        FROM alumnos a
        JOIN usuarios u ON a.id = u.id
        LEFT JOIN cursos c ON a.curso_id = c.id
        WHERE a.curso_id = ?
        ORDER BY u.nombre");
    $stmt->execute([$curso_id]);
} else {
    $stmt = $pdo->query("SELECT u.id, u.nombre, u.apellido, u.email, c.nombre AS curso
        FROM alumnos a
        JOIN usuarios u ON a.id = u.id
        LEFT JOIN cursos c ON a.curso_id = c.id
        ORDER BY u.nombre");
}
$alumnos = $stmt->fetchAll();
?>

<h1 class="mt-4">Gestión de Alumnos</h1>

<form method="GET" class="mb-3 row g-2 align-items-end">
    <div class="col-md-4">
        <label class="form-label">Filtrar por curso:</label>
        <select name="curso_id" class="form-select">
            <option value="">-- Todos los cursos --</option>
            <?php foreach ($cursos as $curso): ?>
                <option value="<?= $curso['id'] ?>" <?= $curso_id == $curso['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($curso['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary" type="submit">Filtrar</button>
    </div>
    <div class="col-md-2">
        <a href="alumnos.php" class="btn btn-secondary">Reset</a>
    </div>
</form>

<a href="alumno_nuevo.php" class="btn btn-success mb-3">
    <i class="bi bi-person-plus"></i> Añadir alumno
</a>

<a href="importar_alumnos.php" class="btn btn-outline-primary mb-3 ms-2">
    <i class="bi bi-upload"></i> Importar desde CSV
</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Curso</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($alumnos as $al): ?>
        <tr>
            <td><?= htmlspecialchars($al['nombre'] . ' ' . $al['apellido']) ?></td>
            <td><?= htmlspecialchars($al['email']) ?></td>
            <td><?= htmlspecialchars($al['curso']) ?></td>
            <td>
                <a href="alumno_editar.php?id=<?= $al['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a href="alumno_eliminar.php?id=<?= $al['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este alumno?');">
                    <i class="bi bi-trash"></i>
                </a>
                <a href="progreso_alumno.php?alumno_id=<?= $al['id'] ?>" class="btn btn-outline-success btn-sm" title="Informe de progreso">
                    <i class="bi bi-bar-chart-line"></i> Progreso
                </a>
                <a href="alumno_examenes.php?id=<?= $al['id'] ?>" class="btn btn-outline-info btn-sm">
                    <i class="bi bi-journal-check"></i> Exámenes
                </a>
                <a href="alumno_refuerzo.php?id=<?= $al['id'] ?>" class="btn btn-outline-info btn-sm">
                    <i class="bi bi-lightbulb"></i> Debilidades
                </a>
                <a href="alumno_tareas.php?id=<?= $al['id'] ?>" class="btn btn-outline-primary btn-sm" title="Ver tareas asignadas">
                    <i class="bi bi-list-task"></i> Tareas
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>
</body>
</html>