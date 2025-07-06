
<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';

// Obtener todos los alumnos con su empresa
$stmt = $pdo->query("
    SELECT u.id AS alumno_id, u.nombre, u.apellido, c.nombre AS curso, e.nombre AS empresa
    FROM alumnos a
    JOIN usuarios u ON a.id = u.id
    LEFT JOIN cursos c ON a.curso_id = c.id
    LEFT JOIN alumnos_empresas ae ON a.id = ae.alumno_id
    LEFT JOIN empresas e ON ae.empresa_id = e.id
    ORDER BY u.apellido, u.nombre
");
$alumnos = $stmt->fetchAll();

// Obtener todos los RA trabajados
$stmt = $pdo->query("
    SELECT r.empresa_id, r.alumno_id, ra.descripcion, a.nombre AS asignatura
    FROM ra_empresa_alumno r
    JOIN resultados_aprendizaje ra ON r.ra_id = ra.id
    JOIN asignaturas a ON ra.asignatura_id = a.id
");
$ra_trabajados = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_UNIQUE);

?>

<div class="container mt-4">
    <h2>Resumen de RA trabajados por alumno</h2>

    <table class="table table-bordered table-hover mt-3">
        <thead class="table-light">
            <tr>
                <th>Alumno</th>
                <th style="width: 15%;">Curso</th>
                <th style="width: 15%;">Empresa</th>
                <th>RA trabajados</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($alumnos as $al): ?>
            <tr>
                <td>
                    <a href="alumno_editar.php?id=<?= $al['alumno_id'] ?>">
                        <?= htmlspecialchars($al['nombre']) . ' ' . htmlspecialchars($al['apellido']) ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($al['curso']) ?></td>
                <td><?= htmlspecialchars($al['empresa'] ?? 'Sin empresa') ?></td>
                <td>
                    <ul class="mb-0">
                        <?php
                        $stmt = $pdo->prepare("
                            SELECT ra.descripcion, a.nombre AS asignatura
                            FROM ra_empresa_alumno rea
                            JOIN resultados_aprendizaje ra ON rea.ra_id = ra.id
                            JOIN asignaturas a ON ra.asignatura_id = a.id
                            WHERE rea.alumno_id = ?
                            ORDER BY a.nombre, ra.id
                        ");
                        $stmt->execute([$al['alumno_id']]);
                        $ras = $stmt->fetchAll();
                        foreach ($ras as $ra): ?>
                            <li><strong><?= htmlspecialchars($ra['asignatura']) ?>:</strong> <?= htmlspecialchars($ra['descripcion']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>
