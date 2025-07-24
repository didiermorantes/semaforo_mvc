<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nuevo Compromiso</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
  <h4 class="mb-4">Nuevo Compromiso</h4>
  <form method="POST" class="border p-4 bg-white rounded shadow-sm">
    <div class="mb-3">
      <label class="form-label">Compromiso</label>
      <textarea name="compromiso" class="form-control" required></textarea>
    </div>

    <?php if ($_SESSION['direccion'] === 'Administrador'): ?>
      
<div class="mb-3">
  <label class="form-label">Dirección Responsable</label>
  <select name="direccion" class="form-select" required>
    <option value="">Seleccione...</option>
    <?php foreach ($direcciones_responsables as $dir): ?>
      <option value="<?= htmlspecialchars($dir['nombre']) ?>"
        <?php
          // Si estás editando y la dirección coincide, selecciónala
          if (isset($compromiso) && $compromiso['direccion_responsable'] === $dir['nombre']) {
            echo 'selected';
          }
        ?>
      >
        <?= htmlspecialchars($dir['nombre']) ?>
      </option>
    <?php endforeach; ?>
  </select>
</div>

    <?php else: ?>
      <div class="mb-3">
        <label class="form-label">Dirección</label>
        <input type="text" name="direccion" class="form-control" value="<?= htmlspecialchars($_SESSION['direccion']) ?>" readonly>
      </div>
    <?php endif; ?>


<div class="mb-3">
  <label class="form-label">Fecha límite</label>
  <input
    type="date"
    name="fecha_limite"
    class="form-control"
    required
    min="<?= date('Y-m-d') ?>"
    value="<?= isset($_POST['fecha_limite']) ? htmlspecialchars($_POST['fecha_limite']) : '' ?>"
  >
</div>



    <button class="btn btn-success">Guardar</button>
    <a href="<?= BASE_URL ?>/?route=compromisos/index" class="btn btn-secondary ms-2">Cancelar</a>
  </form>
</div>
</body>
</html>