<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Compromisos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>📊 Panel - <?= htmlspecialchars($_SESSION['direccion']) ?></h2>
    <a href="<?= BASE_URL ?>/?route=auth/logout" class="btn btn-outline-danger">Cerrar sesión</a>
  </div>

  <div class="mb-4">
    <a href="<?= BASE_URL ?>/?route=compromisos/create" class="btn btn-success me-2">+ Nuevo Compromiso</a>
    <?php if ($_SESSION['direccion'] === 'Administrador'): ?>
      <a href="<?= BASE_URL ?>/?route=bitacora/index" class="btn btn-secondary me-2">📘 Ver Bitácora</a>
      <a href="<?= BASE_URL ?>/?route=log/index" class="btn btn-dark">🪵 Ver Log de Errores</a>
    <?php endif; ?>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-primary">
        <tr>
          <th>ID</th>
          <th>Compromiso</th>
          <th>Dirección</th>
          <th>PDF</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($compromisos as $c): ?>
        <tr>
          <td><?= $c['id'] ?></td>
          <td><?= htmlspecialchars($c['compromiso_especifico']) ?></td>
          <td><?= htmlspecialchars($c['direccion_responsable']) ?></td>
          <td>
            <?php if ($c['evidencia_pdf']): ?>
              <a href="<?= BASE_URL ?>/uploads/<?= $c['evidencia_pdf'] ?>" target="_blank">📄 Ver PDF</a>
            <?php else: ?>
              Sin archivo
            <?php endif; ?>
          </td>
          <td>
            <a href="<?= BASE_URL ?>/?route=compromisos/edit&id=<?= $c['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
