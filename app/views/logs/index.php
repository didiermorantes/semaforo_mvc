<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Log de Errores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
  <h3 class="mb-4">🪵 Log de Errores</h3>
  <div class="mb-3">
    <a href="<?= BASE_URL ?>/?route=compromisos/index" class="btn btn-secondary me-2">← Volver</a>
    <a href="<?= BASE_URL ?>/descargar_log.php" class="btn btn-success me-2">⬇️ Descargar</a>
    <a href="<?= BASE_URL ?>/?route=log/limpiar" class="btn btn-danger" onclick="return confirm('¿Limpiar el log?');">🧹 Limpiar</a>
  </div>
  <div class="border bg-white p-3 rounded shadow-sm" style="max-height: 500px; overflow-y: auto;">
    <pre><?= htmlspecialchars($contenido) ?></pre>
  </div>
</div>
</body>
</html>
