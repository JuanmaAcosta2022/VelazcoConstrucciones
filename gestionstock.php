<?php
session_start();

if (!isset($_SESSION['usuario'])) {
  header("Location: index.php?error=Debe iniciar sesión para acceder a esta página");
  exit();
}

$conexion = new mysqli("localhost", "root", "", "stock_constructora");

if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $codigo_material = $_POST["codigo_material"];
  $nombre_material = $_POST["nombre_material"];
  $unidad = $_POST["unidad"];
  $fecha = $_POST["fecha"];
  $detalle = $_POST["detalle"];
  $ingreso = $_POST["ingreso"];
  $salida = $_POST["salida"];
  $stock = $ingreso - $salida;
  $observacion = $_POST["observacion"];

  $sql = "INSERT INTO stock (codigo_material, nombre_material, unidad, fecha, detalle, ingreso, salida, observacion) 
          VALUES ('$codigo_material', '$nombre_material', '$unidad', '$fecha', '$detalle', '$ingreso', '$salida', '$observacion')";

  if ($conexion->query($sql) === TRUE) {
    echo "Registro agregado exitosamente";
  } else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
  }
}

$resultado = $conexion->query("SELECT * FROM stock");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Stock</title>
  <link rel="stylesheet" href="estilos.css">
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

<div class="contenido">
<h2>Tabla de Stock</h2>
    <form method="POST">
      <label for="nombre_material">Material</label>
      <input type="text" id="nombre_material" name="nombre_material" required>

      <label for="unidad">Unidad</label>
      <input type="text" id="unidad" name="unidad" required>

      <label for="fecha">Fecha</label>
      <input type="date" id="fecha" name="fecha" required>

      <label for="detalle">Detalle</label>
      <input type="text" id="detalle" name="detalle" required>

      <label for="ingreso">Ingreso</label>
      <input type="number" id="ingreso" name="ingreso" required>

      <label for="salida">Salida</label>
      <input type="number" id="salida" name="salida" required>

      <label for="observacion">Observación</label>
      <textarea id="observacion" name="observacion"></textarea><br><br><br>
      <center>
        <div style="display: flex; gap: 20px;">
          <button type="submit" class="form-button" style="display: inline-block;">Guardar</button>
          <button type="reset" class="form-button" style="display: inline-block;">Cancelar</button>
        </div>
      </center>
    </form>
  </div>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Material</th>
          <th>Unidad</th>
          <th>Ingreso</th>
          <th>Salida</th>
          <th>Stock</th>
          <th>Observación</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($resultado->num_rows > 0) {
          while ($row = $resultado->fetch_assoc()) {
            echo "<tr>
              <td>" . date("d-m-Y", strtotime($row["fecha"])) . "</td>
              <td>" . $row["nombre_material"] . "</td>
              <td>" . $row["unidad"] . "</td>
              <td>" . $row["ingreso"] . "</td>
              <td>" . $row["salida"] . "</td>
              <td>" . ($row["ingreso"] - $row["salida"]) . "</td>
              <td>" . $row["observacion"] . "</td>
              <td>
    <a href='editar_material.php?id=" . $row["id_stock"] . "'>Editar</a> | 
    <a href='eliminar_material.php?id=" . $row["id_stock"] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este material?\");'>Eliminar</a> | 
    <a href='imprimir_material.php?id=" . $row["id_stock"] . "' target='_blank'>Imprimir</a>
</td>
            </tr>";
          }
        } else {
          echo "<tr><td colspan='8'>No hay registros</td></tr>";
        }
        ?>
      </tbody>

    </table>

</div>

</body>
</html>
<?php
// Cerrar la conexión
$conexion->close();
?>
