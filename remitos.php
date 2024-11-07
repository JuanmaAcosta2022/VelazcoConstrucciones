<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
  header("Location: index.php?error=Debe iniciar sesión para acceder a esta página");
  exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stock_constructora";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario de agregar remito
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fecha = $_POST['fecha'];
  $origen = $_POST['origen'];
  $destino = $_POST['destino'];
  $codigo = $_POST['codigo'];
  $detalle = $_POST['detalle'];
  $unidad = $_POST['unidad'];
  $cantidad = $_POST['cantidad'];
  $observacion = $_POST['observacion'];
  $responsable = $_POST['responsable'];

  // Insertar los datos en la tabla remitos
  $sqlInsert = "INSERT INTO remitos (fecha, origen, destino, codigo_material, detalle, unidad, cantidad, observacion, id_encargado)
                VALUES ('$fecha', '$origen', '$destino', '$codigo', '$detalle', '$unidad', $cantidad, '$observacion', '$responsable')";

  if ($conn->query($sqlInsert) === TRUE) {
    echo "<script>alert('Remito agregado exitosamente');</script>";
  } else {
    echo "Error al agregar el remito: " . $conn->error;
  }
}

// Consulta para obtener los datos de la tabla remitos
$sql = "SELECT id_remito, numero_remito, fecha, origen, destino, codigo_material, unidad, cantidad, id_encargado FROM remitos";
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if (!$result) {
  die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema para empresa constructora</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <style>
    .navegacion {
      padding: 10px;
      background-color: black;
    }

    .logo {
      height: 40px;
      margin-right: 10px;
    }

    .menu {
      list-style: none;
      padding-left: 0;
    }

    .menu li {
      margin-left: 15px;
    }

    .menu li a {
      color: white;
      text-decoration: none;
    }

    .menu li a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .navegacion {
        flex-direction: column;
        align-items: center;
      }

      .menu {
        flex-direction: column;
        align-items: center;
      }

      .menu li {
        margin: 5px 0;
      }
    }

    /* Estilos para la tabla */
    table th {
      font-weight: bold;
      background-color: #f0f0f0 !important;
    }
  </style>
</head>

<body>
  <header>
    <div class="navegacion d-flex justify-content-between align-items-center">
      <div>
        <img src="logo.jpg" alt="Logo" class="logo">
      </div>
      <ul class="menu d-flex mb-0">
      <li><a href="inicio.php">Inicio</a></li>
      <li><a href="gestionstock.php">Gestionar stock</a></li>
      <li><a href="remitosdepositero.php">Gestionar y visualizar remitos</a></li>
      <li><a href="formulariofechas.php">Consultar stock por intervalos de fechas</a></li>
      <li><a href="formulario_auditoria.php">Auditoria de materiales</a></li>
      <li><a href="inicio.php">Ayuda</a></li>
      <li class="nav-item"><a class="nav-link" href="logout.php">Salir</a></li>
      </ul>
    </div>
  </header>
  <div class="container">
    <h1 class="text-center">Remitos</h1>
    <form id="remitoForm" method="POST">
      <div class="form-group">
        <label for="fecha">Fecha</label>
        <input type="date" class="form-control" id="fecha" name="fecha" required>
      </div>
      <div class="form-group">
        <label for="origen">Origen</label>
        <input type="text" class="form-control" id="origen" name="origen" required>
      </div>
      <div class="form-group">
        <label for="destino">Destino</label>
        <input type="text" class="form-control" id="destino" name="destino" required>
      </div>
      <div class="form-group">
        <label for="codigo">Código</label>
        <input type="text" class="form-control" id="codigo" name="codigo" required>
      </div>
      <div class="form-group">
        <label for="detalle">Detalle</label>
        <textarea class="form-control" id="detalle" name="detalle" rows="3" required></textarea>
      </div>
      <div class="form-group">
        <label for="unidad">Unidad</label>
        <input type="text" class="form-control" id="unidad" name="unidad" required>
      </div>
      <div class="form-group">
        <label for="cantidad">Cantidad</label>
        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
      </div>
      <div class="form-group">
        <label for="observacion">Observación</label>
        <textarea class="form-control" id="observacion" name="observacion" rows="3"></textarea>
      </div>
      <div class="form-group">
        <label for="responsable">Responsable</label>
        <input type="text" class="form-control" id="responsable" name="responsable" required><br><br>
      </div>
      <button type="submit" class="btn btn-primary">Agregar Remito</button>
    </form>

    <h2 class="my-4">Lista de Remitos</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Origen</th>
          <th>Destino</th>
          <th>Código</th>
          <th>Material</th>
          <th>Unidad</th>
          <th>Cantidad</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["fecha"] . "</td>";
            echo "<td>" . $row["origen"] . "</td>";
            echo "<td>" . $row["destino"] . "</td>";
            echo "<td>" . $row["codigo_material"] . "</td>";
            echo "<td>" . $row["detalle"] . "</td>";
            echo "<td>" . $row["unidad"] . "</td>";
            echo "<td>" . $row["cantidad"] . "</td>";
            echo "<td>
                    <a href='imprimir_remito.php?id=" . $row['id_remito'] . "' class='btn btn-primary btn-sm'>Imprimir</a>
                    <a href='editar_remito.php?id=" . $row['id_remito'] . "' class='btn btn-warning btn-sm'>Editar</a>
                    <a href='eliminar_remito.php?id=" . $row['id_remito'] . "' class='btn btn-danger btn-sm'>Eliminar</a>
                  </td>";
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>
</body>

</html>

<?php
$conn->close();
?>