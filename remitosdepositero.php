<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?error=Debe iniciar sesión para acceder a esta página");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stock_constructora";

// Crear la conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Inserción de datos en la tabla remitos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'];
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $codigo = $_POST['codigo_material'];
    $detalle = $_POST['detalle'];
    $unidad = $_POST['unidad'];
    $cantidad = $_POST['cantidad'];
    $observacion = $_POST['observacion'];

    $sql_insert = "INSERT INTO remitos (fecha, origen, destino, codigo_material, detalle, unidad, cantidad, observacion) 
                   VALUES ('$fecha', '$origen', '$destino', '$codigo', '$detalle', '$unidad', '$cantidad', '$observacion')";

    if ($conexion->query($sql_insert) === TRUE) {
        echo "<div class='alert alert-success text-center'>Remito insertado correctamente</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error al insertar remito: " . $conexion->error . "</div>";
    }
}

// Consulta SQL para obtener los datos de la tabla remitos
$query = "SELECT id_remito, fecha, origen, destino, codigo_material, detalle, unidad, cantidad, observacion FROM remitos";
$result = $conexion->query($query);

if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Remitos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
<h2 class="text-center">Insertar Nuevo Remito</h2>
    <form method="POST" action="" class="mb-4">
        <div class="form-row">
            <!-- Campos del formulario para insertar remito -->
            <div class="form-group col-md-3">
                <label for="fecha">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="form-group col-md-3">
                <label for="origen">Origen</label>
                <input type="text" class="form-control" id="origen" name="origen" required>
            </div>
            <div class="form-group col-md-3">
                <label for="destino">Destino</label>
                <input type="text" class="form-control" id="destino" name="destino" required>
            </div>
            <div class="form-group col-md-3">
                <label for="codigo_material">Código</label>
                <input type="text" class="form-control" id="codigo_material" name="codigo_material" required>
            </div>
            <div class="form-group col-md-3">
                <label for="detalle">Detalle</label>
                <input type="text" class="form-control" id="detalle" name="detalle" required>
            </div>
            <div class="form-group col-md-3">
                <label for="unidad">Unidad</label>
                <input type="text" class="form-control" id="unidad" name="unidad" required>
            </div>
            <div class="form-group col-md-3">
                <label for="cantidad">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>
            <div class="form-group col-md-3">
                <label for="observacion">Observación</label>
                <input type="text" class="form-control" id="observacion" name="observacion">
            </div>
        </div><br><br>
        <div class="text-center">
    <button type="submit" class="btn btn-primary btn-sm">Insertar Remito</button>
</div>
    </form>

    <h2 class="text-center">Listado de Remitos</h2>
<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>Fecha</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Código</th>
            <th>Detalle</th>
            <th>Unidad</th>
            <th>Cantidad</th>
            <th>Observación</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Convertir la fecha al formato deseado
                $fechaFormateada = date("d-m-Y", strtotime($row['fecha']));

                echo "<tr>";
                echo "<td>" . $fechaFormateada . "</td>";
                echo "<td>" . $row['origen'] . "</td>";
                echo "<td>" . $row['destino'] . "</td>";
                echo "<td>" . $row['codigo_material'] . "</td>";
                echo "<td>" . $row['detalle'] . "</td>";
                echo "<td>" . $row['unidad'] . "</td>";
                echo "<td>" . $row['cantidad'] . "</td>";
                echo "<td>" . $row['observacion'] . "</td>";
                echo "<td>
                    <button onclick='editarRemito(" . $row['id_remito'] . ")' class='btn btn-warning btn-sm'>Editar</button>
                    <a href='eliminar_remito.php?id=" . $row['id_remito'] . "' class='btn btn-danger btn-sm'>Eliminar</a>
                    <a href='imprimir_remito.php?id=" . $row['id_remito'] . "' class='btn btn-primary btn-sm'>Imprimir</a>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9' class='text-center'>No hay remitos disponibles</td></tr>";
        }
        ?>
    </tbody>
</table>

</div>

<!-- Modal de edición -->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formEditarRemito" method="POST" action="actualizar_remito.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Remito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Campos de formulario -->
                    <input type="hidden" name="id_remito" id="edit_id_remito">
                    <div class="form-group">
                        <label for="edit_fecha">Fecha</label>
                        <input type="date" class="form-control" id="edit_fecha" name="fecha">
                    </div>
                    <div class="form-group">
                        <label for="edit_origen">Origen</label>
                        <input type="text" class="form-control" id="edit_origen" name="origen">
                    </div>
                    <div class="form-group">
                        <label for="edit_destino">Destino</label>
                        <input type="text" class="form-control" id="edit_destino" name="destino">
                    </div>
                    <div class="form-group">
                        <label for="edit_codigo_material">Código</label>
                        <input type="text" class="form-control" id="edit_codigo_material" name="codigo_material">
                    </div>
                    <div class="form-group">
                        <label for="edit_detalle">Detalle</label>
                        <input type="text" class="form-control" id="edit_detalle" name="detalle">
                    </div>
                    <div class="form-group">
                        <label for="edit_unidad">Unidad</label>
                        <input type="text" class="form-control" id="edit_unidad" name="unidad">
                    </div>
                    <div class="form-group">
                        <label for="edit_cantidad">Cantidad</label>
                        <input type="number" class="form-control" id="edit_cantidad" name="cantidad">
                    </div>
                    <div class="form-group">
                        <label for="edit_observacion">Observación</label>
                        <input type="text" class="form-control" id="edit_observacion" name="observacion">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editarRemito(id) {
    $.ajax({
        url: 'obtener_remitos.php',
        type: 'GET',
        data: { id: id },
        success: function(response) {
            let remito = JSON.parse(response);
            $('#edit_id_remito').val(remito.id_remito);
            $('#edit_fecha').val(remito.fecha);
            $('#edit_origen').val(remito.origen);
            $('#edit_destino').val(remito.destino);
            $('#edit_codigo_material').val(remito.codigo_material);
            $('#edit_detalle').val(remito.detalle);
            $('#edit_unidad').val(remito.unidad);
            $('#edit_cantidad').val(remito.cantidad);
            $('#edit_observacion').val(remito.observacion);
            $('#modalEditar').modal('show');
        }
    });
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>




