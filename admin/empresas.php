<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
redirigir_si_no_autenticado();
solo_admin();
require_once '../includes/header.php';

// Borrar empresa (si se recibe una solicitud por GET)
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $stmt = $pdo->prepare("DELETE FROM empresas WHERE id = ?");
    $stmt->execute([$_GET['eliminar']]);
    echo "<div class='alert alert-success'>✅ Empresa eliminada correctamente.</div>";
}

// Obtener todas las empresas
$stmt = $pdo->query("SELECT * FROM empresas ORDER BY nombre");
$empresas = $stmt->fetchAll();
?>

<div class="container mt-4">
  <h2>Empresas colaboradoras</h2>

  <a href="empresa_nueva.php" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Nueva empresa
  </a>

  <?php if ($empresas): ?>
    <table class="table table-bordered table-hover">
      <thead class="table-light">
        <tr>
          <th>Nombre</th>
          <th>CIF</th>
          <th>Responsable</th>
          <th>Email</th>
          <th>Teléfono</th>
          <th style="width: 120px;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($empresas as $e): ?>
        <tr>
          <td><?= htmlspecialchars($e['nombre']) ?></td>
          <td><?= htmlspecialchars($e['cif']) ?></td>
          <td><?= htmlspecialchars($e['responsable_nombre']) ?></td>
          <td><?= htmlspecialchars($e['email_contacto']) ?></td>
          <td><?= htmlspecialchars($e['telefono']) ?></td>
          <td>
            <a href="empresa_editar.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-warning">
              <i class="bi bi-pencil-square"></i>
            </a>
            <a href="empresas.php?eliminar=<?= $e['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta empresa?');">
              <i class="bi bi-trash"></i>
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info">No hay empresas registradas aún.</div>
  <?php endif; ?>

  <a href="dashboard.php" class="btn btn-outline-secondary mt-4">← Volver</a>
</div>

<?php require_once '../includes/footer.php'; ?>
