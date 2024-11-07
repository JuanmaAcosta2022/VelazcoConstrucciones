<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?error=Debe iniciar sesión para acceder a esta página");
    exit();
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema para empresas constructoras</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <style>
    /* Estilos para el header */
    header {
      background-color: #000;
      color: #fff;
      padding: 10px 20px;
    }

    .header-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
    }

    .logo-container {
      flex-shrink: 0;
    }

    .logo {
    height: 50px;
    max-width: 100%;
    margin-right: 20px; /* Ajusta el valor según la separación que necesites */
    }

    .menu {
      display: flex;
      gap: 20px;
    }

    .menu a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
    }

    .menu a:hover {
      color: #ddd;
    }

    /* Contenedor de la página principal */
    .contenido {
      padding: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    h2 {
      color: #333;
    }

    /* Estilos de formulario */
    .form-container {
      margin: 20px auto;
      max-width: 1000px;
    }

    form {
      display: grid;
      grid-template-columns: auto 1fr;
      gap: 10px;
      align-items: center;
    }

    label {
      font-size: 16px;
      text-align: right;
      padding-right: 10px;
    }

    input,
    textarea {
      font-size: 16px;
      padding: 6px;
      width: 100%;
    }

    /* Estilos para los botones de formulario */
    .form-button {
      font-size: 14px;
      padding: 4px 8px;
      /* Tamaño reducido */
      cursor: pointer;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 4px;
    }

    .form-button:hover {
      background-color: #0056b3;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table,
    th,
    td {
      border: 1px solid #ddd;
      padding: 8px;
    }

    th {
      background-color: #f2f2f2;
      text-align: left;
    }
  </style>
</head>
  
<body>

<?php include 'navbarrr.php'; ?>

<div class="container mt-5">
<h2>Consulta de Materiales por Fechas</h2>
<form action="consulta.php" method="post">
    <label for="fecha_inicio">Fecha de Inicio:</label>
    <input type="date" id="fecha_inicio" name="fecha_inicio" required style="width: 150px;">
    
    <label for="fecha_fin">Fecha de Fin:</label>
    <input type="date" id="fecha_fin" name="fecha_fin" required style="width: 150px;">
    
    <input type="submit" value="Consultar">
</form>

</div>
</body>
</html>


