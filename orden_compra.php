<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'stock_constructora');

// Verifica si hay error en la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Variables de búsqueda
$empresa = isset($_GET['empresa']) ? $_GET['empresa'] : '';
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';

// Convertir la fecha al formato YYYY-MM-DD
if ($fecha) {
    $fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha);
    $fecha = $fecha_obj ? $fecha_obj->format('Y-m-d') : '';
}

// Consulta para obtener las órdenes de compra con filtros opcionales (empresa y/o fecha)
$sql = "SELECT oc.*, m.nombre_material 
        FROM ordenes_compra oc
        JOIN materiales m ON oc.codigo_material = m.codigo_material
        WHERE (oc.empresa LIKE ? OR ? = '')
        AND (oc.fecha = ? OR ? = '')
        ORDER BY oc.fecha DESC";

$stmt = $conexion->prepare($sql);
$empresa_param = '%' . $empresa . '%';
$stmt->bind_param('ssss', $empresa_param, $empresa, $fecha, $fecha);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Órdenes de Compra</title>
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
        <h1 class="mb-4">Órdenes de Compra</h1>
        
        <a href="crear_orden.php" class="btn btn-primary mb-4">Crear nueva orden</a>

        <!-- Formulario de búsqueda -->
        <br><br><H3>Buscar por proveedor o fecha</H3>
        <form method="GET" class="row mb-4">
            <div class="col-md-6">
                <input type="text" name="empresa" class="form-control" placeholder="Buscar por proveedor" value="<?php echo htmlspecialchars($empresa); ?>">
            </div>
            <div class="col-md-4">
                <input type="date" name="fecha" class="form-control" value="<?php echo htmlspecialchars($fecha); ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">Buscar</button>
            </div>
        </form>

        <!-- Botón para imprimir en PDF -->
        <a href="imprimir_orden_compra.php?empresa=<?php echo urlencode($empresa); ?>&fecha=<?php echo urlencode($fecha); ?>" target="_blank" class="btn btn-danger mb-4">Imprimir PDF</a>

        <?php
        if ($resultado->num_rows > 0) {
            echo "<table class='table table-bordered table-striped'>
                    <thead class='table-dark'>
                        <tr>
                            <th>ID</th>
                            <th>Código Material</th>
                            <th>Nombre Material</th>
                            <th>Cantidad</th>
                            <th>Persona Solicitante</th>
                            <th>Depósito</th>
                            <th>Proveedor</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>";
            
            while ($fila = $resultado->fetch_assoc()) {
                // Formatear la fecha como día-mes-año
                $fechaFormateada = date("d-m-Y", strtotime($fila['fecha']));
                
                echo "<tr>
                        <td>" . $fila['id'] . "</td>
                        <td>" . $fila['codigo_material'] . "</td>
                        <td>" . $fila['nombre_material'] . "</td>
                        <td>" . $fila['cantidad'] . "</td>
                        <td>" . $fila['persona_solicitante'] . "</td>
                        <td>" . $fila['deposito'] . "</td>
                        <td>" . $fila['empresa'] . "</td>
                        <td>" . $fechaFormateada . "</td>
                      </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p class='alert alert-info'>No hay órdenes de compra registradas o que coincidan con los criterios de búsqueda.</p>";
        }

        // Cerrar la conexión
        $stmt->close();
        $conexion->close();
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

