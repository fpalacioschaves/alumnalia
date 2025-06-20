<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actividad_id = $_POST['actividad_id'] ?? null;
    $notas = $_POST['notas'] ?? [];

    if ($actividad_id && is_numeric($actividad_id)) {
        foreach ($notas as $alumno_id => $nota) {
            if (!is_numeric($alumno_id) || $nota === '') {
                continue;
            }

            // Verificar si ya existe una entrada
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM actividades_alumnos WHERE actividad_id = ? AND alumno_id = ?");
            $stmt->execute([$actividad_id, $alumno_id]);
            $existe = $stmt->fetchColumn();

            if ($existe) {
                // Actualizar
                $stmt = $pdo->prepare("UPDATE actividades_alumnos SET nota = ? WHERE actividad_id = ? AND alumno_id = ?");
                $stmt->execute([$nota, $actividad_id, $alumno_id]);
            } else {
                // Insertar
                $stmt = $pdo->prepare("INSERT INTO actividades_alumnos (actividad_id, alumno_id, nota) VALUES (?, ?, ?)");
                $stmt->execute([$actividad_id, $alumno_id, $nota]);
            }
        }
    }

    header("Location: actividad_calificar.php?id=" . urlencode($actividad_id));
    exit;
}
?>