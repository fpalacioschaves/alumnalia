<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';


redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';
// Obtener todos los alumnos
$stmt = $pdo->query("SELECT u.id, u.nombre, u.apellido, u.email, c.nombre AS curso, a.fecha_nacimiento
FROM alumnos a
JOIN usuarios u ON a.id = u.id
LEFT JOIN cursos c ON a.curso_id = c.id
ORDER BY u.nombre;");
$alumnos = $stmt->fetchAll();
?>


    <h1 class="mt-4">Gestión de Alumnos</h1>
    
    <a href="alumno_nuevo.php" class="btn btn-success mb-3">
        <i class="bi bi-person-plus"></i> Añadir alumno
    </a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Curso</th>
              <!--  <th>Fecha Nacimiento</th> --->
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($alumnos as $al): ?>
            <tr>
                <td><?= htmlspecialchars($al['nombre'] . ' ' . $al['apellido']) ?></td>
                <td><?= htmlspecialchars($al['email']) ?></td>
                <td><?= htmlspecialchars($al['curso']) ?></td>
             <!--   <td><?= htmlspecialchars($al['fecha_nacimiento']) ?></td>-->
                <td>
                    <a href="alumno_editar.php?id=<?= $al['id'] ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="alumno_eliminar.php?id=<?= $al['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este alumno?');">
                        <i class="bi bi-trash"></i>
                    </a>
                    <a href="alumno_examenes.php?id=<?= $al['id'] ?>" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-journal-check"></i> Exámenes
                    </a>
                    <a href="alumno_refuerzo.php?id=<?= $al['id'] ?>" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-lightbulb"></i> Debilidades
                    </a>
                    <a href="tareas_alumno.php?id=<?= $al['id'] ?>"  class="btn btn-outline-info btn-sm">
                        <i class="bi bi-journal-check"></i> Refuerzo
                    </a>

                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php require_once '../includes/footer.php'; ?>

</body>
</html>
