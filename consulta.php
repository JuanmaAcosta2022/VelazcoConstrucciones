<?php
$host = 'localhost'; // Cambia esto si tu base de datos está en otro servidor
$dbname = 'stock_constructora';
$user = 'root'; // Cambia esto si tu usuario de la base de datos es diferente
$pass = ''; // Cambia esto si tu contraseña de la base de datos es diferente

try {
    // Conectar a la base de datos
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los valores del formulario
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // Preparar la consulta SQL
    $sql = "SELECT 
                s.codigo_material,
                s.nombre_material,
                s.unidad,
                s.fecha,
                s.detalle,
                s.ingreso,
                s.salida,
                s.stock,
                s.observacion
            FROM 
                stock s
            WHERE 
                s.fecha BETWEEN :fecha_inicio AND :fecha_fin";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':fecha_inicio', $fecha_inicio);
    $stmt->bindParam(':fecha_fin', $fecha_fin);

    // Ejecutar la consulta
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de la Consulta</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2; /* Fondo gris para el encabezado */
        font-weight: bold; /* Texto en negrita para el encabezado */
    }
    </style>
</head>
<body>
<?php include 'navbarrr.php'; ?>

<div class="container mt-5">

<h2>Resultados de la Consulta</h2>

<?php
if (isset($error)) {
    echo "<p>$error</p>";
} else {
    if ($result) {
        echo "<table>
                <tr>
                    <th>Material</th>
                    <th>Unidad</th>
                    <th>Fecha</th>
                    <th>Detalle</th>
                    <th>Ingreso</th>
                    <th>Salida</th>
                    <th>Stock</th>
                    <th>Observación</th>
                </tr>";
                foreach ($result as $row) {
                    $fecha_formateada = date('d-m-Y', strtotime($row['fecha']));
                    echo "<tr>
                            <td>{$row['nombre_material']}</td>
                            <td>{$row['unidad']}</td>
                            <td>{$fecha_formateada}</td>
                            <td>{$row['detalle']}</td>
                            <td>{$row['ingreso']}</td>
                            <td>{$row['salida']}</td>
                            <td>{$row['stock']}</td>
                            <td>{$row['observacion']}</td>
                        </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No se encontraron resultados para el rango de fechas proporcionado.</p>";
    }
}
?>
</div>
</body>
</html>