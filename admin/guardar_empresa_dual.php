
<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

redirigir_si_no_autenticado();
solo_admin();

$alumno_id = $_POST['alumno_id'];
$empresa_id = $_POST['empresa_id'];
$tutor_nombre = $_POST['tutor_nombre'] ?? '';
$tutor_email = $_POST['tutor_email'] ?? '';
$tutor_telefono = $_POST['tutor_telefono'] ?? '';
$fecha_inicio = $_POST['fecha_inicio'] ?? null;
$fecha_fin = $_POST['fecha_fin'] ?? null;

// Comprobar si ya existe asignación
$stmt = $pdo->prepare("SELECT COUNT(*) FROM alumnos_empresas WHERE alumno_id = ?");
$stmt->execute([$alumno_id]);
$existe = $stmt->fetchColumn();

if ($existe) {
    // Actualizar
    $stmt = $pdo->prepare("UPDATE alumnos_empresas 
        SET empresa_id = ?, tutor_nombre = ?, tutor_email = ?, tutor_telefono = ?, fecha_inicio = ?, fecha_fin = ?
        WHERE alumno_id = ?");
    $stmt->execute([$empresa_id, $tutor_nombre, $tutor_email, $tutor_telefono, $fecha_inicio, $fecha_fin, $alumno_id]);
} else {
    // Insertar
    $stmt = $pdo->prepare("INSERT INTO alumnos_empresas 
        (alumno_id, empresa_id, tutor_nombre, tutor_email, tutor_telefono, fecha_inicio, fecha_fin)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$alumno_id, $empresa_id, $tutor_nombre, $tutor_email, $tutor_telefono, $fecha_inicio, $fecha_fin]);
}

header("Location: alumno_editar.php?id=" . $alumno_id);
exit;
?>
