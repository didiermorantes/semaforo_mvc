<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Compromiso</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
  <h4 class="mb-4">Editar Compromiso</h4>
  <form method="POST" enctype="multipart/form-data" class="border p-4 bg-white rounded shadow-sm">
    <div class="mb-3">
      <label class="form-label">Compromiso</label>
      <textarea name="compromiso" class="form-control" required><?= htmlspecialchars($compromiso['compromiso_especifico']) ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Dirección</label>
      <input type="text" name="direccion" class="form-control" value="<?= $_SESSION['direccion'] ?>" readonly>
    </div>
    <div class="mb-3">
      <label class="form-label">Archivo PDF</label>
      <?php if ($compromiso['evidencia_pdf']): ?>
        <p>Actual: <a href="<?= BASE_URL ?>/uploads/<?= $compromiso['evidencia_pdf'] ?>">📄 Ver</a></p>
      <?php endif; ?>
      <input type="file" name="pdf" class="form-control" accept="application/pdf">
      <input type="hidden" name="pdf_actual" value="<?= $compromiso['evidencia_pdf'] ?>">
    </div>
    <button class="btn btn-primary">Actualizar</button>
    <a href="<?= BASE_URL ?>/?route=compromisos/index" class="btn btn-secondary ms-2">Cancelar</a>
  </form>
</div>
</body>
</html>
