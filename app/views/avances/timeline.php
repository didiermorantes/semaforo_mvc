<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Histórico de Avances</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .timeline { border-left: 3px solid #0d6efd; margin-left: 30px; }
    .timeline-item { margin-bottom: 2rem; position: relative; }
    .timeline-dot {
      width: 18px; height: 18px; background: #0d6efd; border-radius: 50%;
      position: absolute; left: -40px; top: 0;
      border: 4px solid #fff; box-shadow: 0 0 0 2px #0d6efd;
    }
    .timeline-date { font-size: .9em; color: #888; }
  </style>
</head>
<body class="bg-light p-4">
<div class="container">
  <h4 class="mb-4">Histórico de Avances</h4>
  <div class="mb-3">
    <strong>Compromiso:</strong> <?= htmlspecialchars($compromiso['compromiso_especifico']) ?><br>
    <span class="text-muted">ID: <?= $compromiso['id'] ?> &mdash; Responsable: <?= htmlspecialchars($compromiso['direccion_responsable']) ?></span>
  </div>
  <a href="<?= BASE_URL ?>/?route=compromisos/index" class="btn btn-secondary mb-4">← Volver</a>

  <?php if (empty($avances)): ?>
    <div class="alert alert-info">Aún no hay avances registrados para este compromiso.</div>
  <?php else: ?>
    <div class="timeline">
      <?php foreach ($avances as $avance): ?>
        <div class="timeline-item">
          <div class="timeline-dot"></div>
          <div>
            <span class="timeline-date"><?= date('d/m/Y H:i', strtotime($avance['fecha_avance'])) ?></span>
            <span class="ms-2"><strong><?= htmlspecialchars($avance['usuario']) ?></strong></span>
            <?php if ($avance['es_finalizacion']): ?>
              <span class="badge bg-success ms-2">Finalización</span>
            <?php endif; ?>
          </div>
          
          <div class="mt-2">
            <?= nl2br(htmlspecialchars($avance['resumen'])) ?>
            <?php if (isset($avance['porcentaje_avance'])): ?>
                <div class="small text-muted">
                    Porcentaje de avance: <strong><?= intval($avance['porcentaje_avance']) ?>%</strong>
                </div>
            <?php endif; ?>
        </div>

          <?php if ($avance['es_finalizacion'] && $avance['pdf_finalizacion']): ?>
            <div class="mt-1">
              <a href="<?= BASE_URL ?>/uploads/<?= $avance['pdf_finalizacion'] ?>" target="_blank" class="btn btn-outline-primary btn-sm">Ver PDF de Finalización</a>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
</body>
</html>
