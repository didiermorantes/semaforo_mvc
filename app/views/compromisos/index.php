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
<?php if (!empty($compromisos) && is_array($compromisos)): ?>
    <?php foreach ($compromisos as $c): ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><?= htmlspecialchars($c['compromiso_especifico']) ?></td>
        <td><?= htmlspecialchars($c['direccion_responsable']) ?></td>
        <td>
          <?php if (!empty($c['evidencia_pdf'])): ?>
            <a href="<?= BASE_URL ?>/uploads/<?= $c['evidencia_pdf'] ?>" target="_blank">📄 Ver PDF</a>
          <?php else: ?>
            Sin archivo
          <?php endif; ?>
        </td>
        <td>
          <!-- Semaforización: Verde si finalizado, Rojo si no -->
          <?php if (!empty($c['finalizado']) && $c['finalizado']): ?>
            <span class="badge bg-success px-3 py-2">✔️ Finalizado</span>
          <?php else: ?>
            <span class="badge bg-danger px-3 py-2">Pendiente</span>
          <?php endif; ?>

          <?php if (
              $_SESSION['direccion'] !== 'Administrador'
              && (
                  empty($c['finalizado'])
                  || !$c['finalizado']
              )
          ): ?>
            <a href="<?= BASE_URL ?>/?route=avances/formulario&compromiso_id=<?= $c['id'] ?>" class="btn btn-primary btn-sm ms-2">
              Registrar Avance
            </a>
          <?php endif; ?>

          <!-- Admin puede seguir editando si así lo decides -->
          <?php if ($_SESSION['direccion'] === 'Administrador'): ?>
            <a href="<?= BASE_URL ?>/?route=compromisos/edit&id=<?= $c['id'] ?>" class="btn btn-warning btn-sm ms-2">Editar</a>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
      <td colspan="5" class="text-center">No hay compromisos registrados.</td>
    </tr>
<?php endif; ?>
</tbody>

    </table>
  </div>
</div>
</body>
</html>
