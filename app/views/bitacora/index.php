<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Bitácora</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<!-- Barra de filtros de la bitácora -->
<form method="GET" action="" class="d-flex align-items-center mb-3">
  <input type="hidden" name="route" value="bitacora/index">
  <input type="text" name="filtro" placeholder="Filtrar por responsable..." class="form-control me-2" value="<?= isset($_GET['filtro']) ? htmlspecialchars($_GET['filtro']) : '' ?>">
  <button type="submit" class="btn btn-outline-primary me-2">Filtrar</button>
</form>

<!-- Botón de exportar PDF (siempre lleva el filtro actual) -->
<form method="GET" action="<?= BASE_URL ?>/exportar_pdf.php" class="d-inline mb-3">
    <input type="hidden" name="filtro" value="<?= isset($_GET['filtro']) ? htmlspecialchars($_GET['filtro']) : '' ?>">
    <button type="submit" class="btn btn-success">Exportar PDF</button>
</form>

<div class="container">
  <h3 class="mb-4">📘 Bitácora de Cambios</h3>

  <a href="<?= BASE_URL ?>/?route=compromisos/index" class="btn btn-secondary mb-3">← Volver</a>

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>ID Compromiso</th>
          <th>Dirección</th>
          <th>Acción</th>
          <th>Fecha</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($bitacora as $b): ?>
        <tr>
          <td><?= $b['id'] ?></td>
          <td><?= $b['compromiso_id'] ?></td>
          <td><?= $b['direccion_responsable'] ?></td>
          <td><?= $b['accion'] ?></td>
          <td><?= $b['fecha'] ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
