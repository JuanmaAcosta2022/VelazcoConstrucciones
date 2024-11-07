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

$id_stock = $_GET['id'];
$sql = "SELECT * FROM stock WHERE id_stock = $id_stock";
$resultado = $conexion->query($sql);

if ($resultado->num_rows == 1) {
  $fila = $resultado->fetch_assoc();
} else {
  echo "No se encontró el registro.";
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $codigo_material = $_POST["codigo_material"];
  $nombre_material = $_POST["nombre_material"];
  $unidad = $_POST["unidad"];
  $fecha = $_POST["fecha"];
  $detalle = $_POST["detalle"];
  $ingreso = $_POST["ingreso"];
  $salida = $_POST["salida"];
  $observacion = $_POST["observacion"];

  $sql_update = "UPDATE stock SET 
                 codigo_material='$codigo_material', 
                 nombre_material='$nombre_material', 
                 unidad='$unidad', 
                 fecha='$fecha', 
                 detalle='$detalle', 
                 ingreso='$ingreso', 
                 salida='$salida', 
                 observacion='$observacion' 
                 WHERE id_stock = $id_stock";

  if ($conexion->query($sql_update) === TRUE) {
    echo "Registro actualizado exitosamente.";
    header("Location: gestionstock.php");
    exit();
  } else {
    echo "Error al actualizar: " . $conexion->error;
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Stock</title>
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
<h2>Editar Stock</h2>
        <form method="POST">
            <label>Material</label>
            <input type="text" name="nombre_material" value="<?php echo $fila['nombre_material']; ?>" required>

            <label>Unidad</label>
            <input type="text" name="unidad" value="<?php echo $fila['unidad']; ?>" required>

            <label>Fecha</label>
            <input type="date" name="fecha" value="<?php echo $fila['fecha']; ?>" required>

            <label>Detalle</label>
            <input type="text" name="detalle" value="<?php echo $fila['detalle']; ?>" required>

            <label>Ingreso</label>
            <input type="number" name="ingreso" value="<?php echo $fila['ingreso']; ?>" required>

            <label>Salida</label>
            <input type="number" name="salida" value="<?php echo $fila['salida']; ?>" required>

            <label>Observación</label>
            <textarea name="observacion"><?php echo $fila['observacion']; ?></textarea>

            <button type="submit">Actualizar</button>
            <a href="gestionstock.php"><button type="button">Cancelar</button></a>
        </form>

</div>

</body>
</html>
<?php
// Cerrar la conexión
$conexion->close();
?>