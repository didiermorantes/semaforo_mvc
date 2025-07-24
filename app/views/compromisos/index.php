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
  <?php if ($_SESSION['direccion'] === 'Administrador'): ?>
    <a href="<?= BASE_URL ?>/?route=compromisos/create" class="btn btn-success me-2">+ Nuevo Compromiso</a>
    <a href="<?= BASE_URL ?>/?route=bitacora/index" class="btn btn-secondary me-2">📘 Ver Bitácora</a>
    <a href="<?= BASE_URL ?>/?route=log/index" class="btn btn-dark">🪵 Ver Log de Errores</a>
  <?php endif; ?>
</div>

<!-- FORMULARIO DE FILTROS SOLO PARA ADMIN -->
<?php if ($_SESSION['direccion'] === 'Administrador'): ?>
  <form method="get" class="mb-3 d-flex gap-2">
    <input type="hidden" name="route" value="compromisos/index">
    <select name="filtro_direccion" class="form-select" style="max-width:220px;">
      <option value="">Todas las Direcciones</option>
      <?php foreach ($direcciones_responsables as $dir): ?>
        <option value="<?= htmlspecialchars($dir['nombre']) ?>" <?= ($dir['nombre'] == ($_GET['filtro_direccion'] ?? '')) ? 'selected' : '' ?>>
          <?= htmlspecialchars($dir['nombre']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <select name="filtro_estado" class="form-select" style="max-width:160px;">
      <option value="">Todos los Estados</option>
      <option value="Pendiente" <?= (($_GET['filtro_estado'] ?? '') == 'Pendiente') ? 'selected' : '' ?>>Pendiente</option>
      <option value="Vencido" <?= (($_GET['filtro_estado'] ?? '') == 'Vencido') ? 'selected' : '' ?>>Vencido</option>
      <option value="Finalizado" <?= (($_GET['filtro_estado'] ?? '') == 'Finalizado') ? 'selected' : '' ?>>Finalizado</option>
    </select>
    <button class="btn btn-primary">Filtrar</button>
  </form>
<?php endif; ?>

<div class="table-responsive">
  <table class="table table-bordered table-hover align-middle">

  <thead class="table-primary">
  <tr>
    <th>ID</th>
    <th>Compromiso</th>
    <th>Dirección</th>
    <th>Fecha Límite</th>
    <th>PDF</th>
    <th>Estado</th>
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
          <?php if (!empty($c['fecha_limite'])): ?>
            <?= date('d/m/Y', strtotime($c['fecha_limite'])) ?>
          <?php else: ?>
            <span class="text-muted">No asignada</span>
          <?php endif; ?>
        </td>
        <td>
          <?php if (!empty($c['pdf_finalizacion'])): ?>
            <a href="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($c['pdf_finalizacion']) ?>" target="_blank">📄 Ver PDF</a>
          <?php else: ?>
            Sin archivo
          <?php endif; ?>
        </td>
        <!-- Columna ESTADO -->
        <td>
          <?php
            $fechaLimite = isset($c['fecha_limite']) ? $c['fecha_limite'] : null;
            $vencido = false;
            if ($fechaLimite && strtotime($fechaLimite) < strtotime('today') && !$c['finalizado']) {
              $vencido = true;
            }
          ?>
          <?php if (!empty($c['finalizado']) && $c['finalizado']): ?>
            <span class="badge bg-success px-3 py-2">✔️ Finalizado</span>
          <?php elseif ($vencido): ?>
            <span class="badge bg-danger px-3 py-2">Vencido</span>
          <?php else: ?>
            <span class="badge bg-warning text-dark px-3 py-2">Pendiente</span>
          <?php endif; ?>
        </td>
        <!-- Columna ACCIONES -->
        <td>
          <?php if (
              $_SESSION['direccion'] !== 'Administrador'
              && (empty($c['finalizado']) || !$c['finalizado'])
          ): ?>
            <a href="<?= BASE_URL ?>/?route=avances/formulario&compromiso_id=<?= $c['id'] ?>" class="btn btn-primary btn-sm mb-1">
              Registrar Avance
            </a>
          <?php endif; ?>

          <?php if ($_SESSION['direccion'] === 'Administrador'): ?>
            <a href="<?= BASE_URL ?>/?route=compromisos/edit&id=<?= $c['id'] ?>" class="btn btn-warning btn-sm mb-1">Editar</a>
            <a href="<?= BASE_URL ?>/?route=avances/timeline&compromiso_id=<?= $c['id'] ?>" class="btn btn-info btn-sm mb-1">Ver historial</a>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
      <td colspan="7" class="text-center">No hay compromisos registrados.</td>
    </tr>
<?php endif; ?>
</tbody>


  </table>
</div>

</div>
</body>
</html>
