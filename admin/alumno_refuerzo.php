<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$alumno_id = $_GET['id'] ?? null;
if (!$alumno_id || !is_numeric($alumno_id)) {
    header("Location: alumnos.php");
    exit;
}

// Obtener datos del alumno
$stmt = $pdo->prepare("
    SELECT u.nombre, u.apellido, c.nombre AS curso
    FROM alumnos a
    JOIN usuarios u ON a.id = u.id
    JOIN cursos c ON a.curso_id = c.id
    WHERE a.id = ?
");
$stmt->execute([$alumno_id]);
$alumno = $stmt->fetch();
if (!$alumno) {
    header("Location: alumnos.php");
    exit;
}

// Ejercicios tradicionales fallados
$stmt = $pdo->prepare("
    SELECT 
        e.enunciado,
        r.puntuacion_obtenida,
        e.puntuacion AS puntuacion_maxima,
        ex.titulo AS examen,
        ex.asignatura_id AS asignatura_id,
        et.nombre AS etiqueta, et.id AS etiqueta_id,
        asignatura.nombre AS asignatura,
        t.nombre AS tema
    FROM resoluciones r
    JOIN ejercicios e ON r.ejercicio_id = e.id
    JOIN examenes ex ON e.examen_id = ex.id
    LEFT JOIN etiquetas et ON e.etiqueta_id = et.id
    LEFT JOIN temas t ON e.tema_id = t.id
    LEFT JOIN asignaturas asignatura ON ex.asignatura_id = asignatura.id
    WHERE r.alumno_id = ?
      AND r.puntuacion_obtenida <= (e.puntuacion / 2)
");
$stmt->execute([$alumno_id]);
$fallos_ejercicios = $stmt->fetchAll();

// Preguntas del banco de preguntas falladas
$stmt = $pdo->prepare("
    SELECT 
        bp.enunciado,
        r.puntuacion_obtenida,
        bpe.puntuacion AS puntuacion_maxima,
        ex.titulo AS examen,
        bp.dificultad,
        et.nombre AS etiqueta, et.id AS etiqueta_id,
        asignatura.nombre AS asignatura,
        tm.nombre AS tema
    FROM resoluciones_banco_preguntas r
    JOIN banco_preguntas bp ON r.ejercicio_id = bp.id
    JOIN banco_preguntas_en_examen bpe ON bp.id = bpe.pregunta_id
    JOIN examenes ex ON bpe.examen_id = ex.id
    LEFT JOIN etiquetas et ON bp.etiqueta_id = et.id
    LEFT JOIN temas tm ON bp.tema_id = tm.id
    LEFT JOIN asignaturas asignatura ON ex.asignatura_id = asignatura.id
    WHERE r.alumno_id = ?
    AND r.puntuacion_obtenida <= (bpe.puntuacion / 2)
");
$stmt->execute([$alumno_id]);
$fallos_banco = $stmt->fetchAll();

require_once '../includes/header.php';
?>

<h2 class="mt-4">Ejercicios fallados por <?= htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']) ?></h2>
<p class="text-muted">Curso: <?= htmlspecialchars($alumno['curso']) ?></p>

<?php if (empty($fallos_ejercicios) && empty($fallos_banco)): ?>
    <div class="alert alert-success">Este alumno no presenta errores por debajo del 50%.</div>
<?php else: ?>

    <?php if (!empty($fallos_ejercicios)): ?>
        <h4 class="mt-4">❌ Ejercicios tradicionales fallados</h4>
        <ul class="list-group mb-4">
            <?php foreach ($fallos_ejercicios as $ej): ?>
                <li class="list-group-item">
                    <strong>Examen:</strong> <?= htmlspecialchars($ej['examen']) ?><br>
                    <strong>Enunciado:</strong> <?= htmlspecialchars($ej['enunciado']) ?><br>
                    <strong>Puntuación:</strong> <?= $ej['puntuacion_obtenida'] ?> / <?= $ej['puntuacion_maxima'] ?><br>
                    <?php if ($ej['etiqueta']): ?>
                        <span class="badge bg-warning text-dark">Etiqueta: <?= htmlspecialchars($ej['etiqueta']) ?></span>
                        
                    <?php endif; ?>
                    <span class="badge bg-warning text-dark">Asignatura: <?= htmlspecialchars($ej['asignatura']) ?> </span>
                    <?php if ($ej['tema']): ?>
                        <span class="badge bg-info text-dark">Tema: <?= htmlspecialchars($ej['tema']) ?> </span>
                    <?php endif; ?>
                    <form method="POST" action="generar_actividad_ia.php" class="d-inline">
                        <input type="hidden" name="alumno_id" value="<?= $alumno_id ?>">
                        <input type="hidden" name="etiqueta_id" value="<?= $ej['etiqueta_id'] ?>">
                        <input type="hidden" name="etiqueta_nombre" value="<?= htmlspecialchars($ej['etiqueta']) ?>">
                        <input type="hidden" name="tema" value="<?= $ej['tema'] ?>">
                        <input type="hidden" name="asignatura" value="<?= $ej['asignatura'] ?>">
                        <button class="btn btn-sm btn-outline-primary" title="Generar actividad IA">
                            <i class="bi bi-robot"></i> Generar actividad IA
                        </button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($fallos_banco)): ?>
        <h4 class="mt-4">❌ Preguntas del banco falladas</h4>
        <ul class="list-group">
            <?php foreach ($fallos_banco as $bp): ?>
                <li class="list-group-item">
                    <strong>Examen:</strong> <?= htmlspecialchars($bp['examen']) ?><br>
                    <strong>Pregunta:</strong> <?= htmlspecialchars($bp['enunciado']) ?><br>
                    <strong>Puntuación:</strong> <?= $bp['puntuacion_obtenida'] ?> / <?= $bp['puntuacion_maxima'] ?><br>
                    <?php if ($bp['etiqueta']): ?>
                        <span class="badge bg-warning text-dark">Etiqueta: <?= htmlspecialchars($bp['etiqueta']) ?></span>
                    <?php endif; ?>
                    <span class="badge bg-warning text-dark">Asignatura: <?= htmlspecialchars($bp['asignatura']) ?> </span>
                    <?php if ($bp['tema']): ?>
                        <span class="badge bg-info text-dark">Tema: <?= htmlspecialchars($bp['tema']) ?></span>
                    <?php endif; ?>
                    <form method="POST" action="generar_actividad_ia.php" class="d-inline">
                        <input type="hidden" name="alumno_id" value="<?= $alumno_id ?>">
                        <input type="hidden" name="etiqueta_id" value="<?= $bp['etiqueta_id'] ?>">
                        <input type="hidden" name="etiqueta_nombre" value="<?= htmlspecialchars($bp['etiqueta']) ?>">
                        <button class="btn btn-sm btn-outline-primary" title="Generar actividad IA">
                            <i class="bi bi-robot"></i> Generar actividad IA
                        </button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

<?php endif; ?>



<br>

<a href="alumnos.php" class="btn btn-secondary mt-4">← Volver a alumnos</a>

<?php require_once '../includes/footer.php'; ?>
