<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO empresas (nombre, cif, responsable_nombre, email_contacto, telefono)
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['nombre'],
        $_POST['cif'],
        $_POST['responsable_nombre'],
        $_POST['email_contacto'],
        $_POST['telefono']
    ]);
    header("Location: empresas.php");
    exit;
}

require_once '../includes/header.php';
?>

<div class="container mt-4">
  <h2>Nueva empresa</h2>

  <form method="POST" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Nombre</label>
      <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">CIF</label>
      <input type="text" name="cif" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Responsable</label>
      <input type="text" name="responsable_nombre" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Email de contacto</label>
      <input type="email" name="email_contacto" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Teléfono</label>
      <input type="text" name="telefono" class="form-control">
    </div>
    <div class="col-12">
      <button class="btn btn-success">Guardar empresa</button>
      <a href="empresas.php" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>
</div>

<?php require_once '../includes/footer.php'; ?>
