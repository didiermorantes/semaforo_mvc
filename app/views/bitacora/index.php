<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Bitácora</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container">
  <!-- Barra de filtros y exportación PDF en una sola fila -->
  <div class="row mb-3">
    <div class="col">
      <form method="GET" action="" class="d-flex gap-2 align-items-center">
        <input type="hidden" name="route" value="bitacora/index">
        <input type="text" name="filtro" placeholder="Filtrar por responsable..." class="form-control" value="<?= isset($_GET['filtro']) ? htmlspecialchars($_GET['filtro']) : '' ?>">
        <button type="submit" class="btn btn-outline-primary">Filtrar</button>
      </form>
    </div>
    <div class="col-auto">
      <form method="GET" action="<?= BASE_URL ?>/exportar_pdf.php" class="d-flex">
          <input type="hidden" name="filtro" value="<?= isset($_GET['filtro']) ? htmlspecialchars($_GET['filtro']) : '' ?>">
          <button type="submit" class="btn btn-success">Exportar PDF</button>
      </form>
    </div>
  </div>

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
