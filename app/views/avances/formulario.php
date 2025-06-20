<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Avance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
  <h4 class="mb-4">Registrar Avance - Compromiso #<?= htmlspecialchars($compromiso['id']) ?></h4>

  <div class="mb-3">
    <strong>Compromiso:</strong><br>
    <?= htmlspecialchars($compromiso['compromiso_especifico']) ?>
  </div>

  <?php if ($finalizado): ?>
    <div class="alert alert-success">Este compromiso ya ha sido finalizado. No puede registrar más avances.</div>
    <a href="<?= BASE_URL ?>/?route=compromisos/index" class="btn btn-secondary">Volver</a>
  <?php else: ?>
    <form method="POST" enctype="multipart/form-data" action="<?= BASE_URL ?>/?route=avances/guardar">
      <input type="hidden" name="compromiso_id" value="<?= $compromiso['id'] ?>">
      <div class="mb-3">
        <label class="form-label">Resumen del avance <span class="text-danger">*</span></label>
        <textarea name="resumen" class="form-control" required></textarea>
      </div>
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="finalizar" id="finalizarCheckbox" value="1"
               onchange="document.getElementById('pdfFinalizacionDiv').style.display = this.checked ? 'block' : 'none'">
        <label class="form-check-label" for="finalizarCheckbox">¿Desea finalizar el compromiso?</label>
      </div>
      <div class="mb-3" id="pdfFinalizacionDiv" style="display:none;">
        <label class="form-label">Suba el PDF de finalización <span class="text-danger">*</span></label>
        <input type="file" name="pdf_finalizacion" class="form-control" accept="application/pdf">
      </div>
      <button class="btn btn-primary">Guardar avance</button>
      <a href="<?= BASE_URL ?>/?route=compromisos/index" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
  <?php endif; ?>
</div>
</body>
</html>
