<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'stock_constructora');

// Verifica si hay error en la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Consulta para obtener los materiales
$sql_materiales = "SELECT codigo_material, nombre_material FROM materiales";
$resultado_materiales = $conexion->query($sql_materiales);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Orden de Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <h1>Crear Orden de Compra</h1>
    <div class="form-container">
        <form action="guardar_orden.php" method="POST">
            <div class="form-group">
                <label for="codigo_material">Material:</label>
                <select id="codigo_material" name="codigo_material" required><br><br>
                    <option value="">Seleccione un material</option>
                    <?php
                    if ($resultado_materiales->num_rows > 0) {
                        while ($fila = $resultado_materiales->fetch_assoc()) {
                            echo "<option value='" . $fila['codigo_material'] . "'>" . $fila['nombre_material'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div><br><br>

            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" required>
            </div><br><br>

            <div class="form-group">
                <label for="persona_solicitante">Nombre de la persona solicitante:</label>
                <input type="text" id="persona_solicitante" name="persona_solicitante" required>
            </div><br><br>

            <div class="form-group">
                <label for="deposito">Nombre del depósito:</label>
                <input type="text" id="deposito" name="deposito" required>
            </div><br><br>

            <div class="form-group">
                <label for="empresa">Nombre del proveedor:</label>
                <input type="text" id="empresa" name="empresa" required>
            </div><br><br>

            <button type="submit">Crear Orden</button>
        </form>
        <a href="orden_compra.php" class="back-link">Volver a la lista de órdenes</a>
    </div>

    <?php $conexion->close(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>