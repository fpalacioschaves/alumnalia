<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$alumnos = $_POST['alumnos'] ?? [];
$ejercicios = $_POST['ejercicios'] ?? [];
$etiqueta_id = $_POST['etiqueta_id'] ?? null;
$curso_id = $_POST['curso_id'] ?? null;

if (empty($alumnos) || empty($ejercicios)) {
    header("Location: asignacion_manual.php?error=1");
    exit;
}

$insertados = 0;

foreach ($alumnos as $alumno_id) {
    foreach ($ejercicios as $ejercicio_id) {
        try {
            $stmt = $pdo->prepare("
                INSERT IGNORE INTO tareas_asignadas (alumno_id, ejercicio_id)
                VALUES (?, ?)
            ");
            $stmt->execute([$alumno_id, $ejercicio_id]);
            if ($stmt->rowCount() > 0) {
                $insertados++;
            }
        } catch (PDOException $e) {
            // podrías loguear el error si lo necesitas
        }
    }
}

// Redirige de vuelta a la página de origen
header("Location: alumnos.php");
exit;
