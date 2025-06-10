<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
<div class="card shadow p-4">
  <h4 class="mb-4">Iniciar sesión</h4>
  <form method="POST">
    <div class="mb-3">
      <label for="direccion" class="form-label">Dirección Responsable</label>
      <select name="direccion" id="direccion" class="form-select" required>
        <option value="">Seleccione...</option>
        <option>Administrador</option>
        <option>Administrativa y Financiera</option>
        <option>Buen Gobierno</option>
        <option>Calidad Educativa</option>
        <option>Cobertura Educativa</option>
        <option>Despacho</option>
        <option>Educación Superior</option>
        <option>Infraestructura Educativa</option>
        <option>Medios y Nuevas Tecnologías</option>
        <option>Oficina Asesora de Planeación</option>
        <option>Oficina Asesora Jurídica</option>
        <option>Personal Docente</option>
        <option>Subsecretaría</option>
        <option>Transporte</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
  </form>
</div>
</body>
</html>
