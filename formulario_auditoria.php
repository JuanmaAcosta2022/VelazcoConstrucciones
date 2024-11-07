<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?error=Debe iniciar sesión para acceder a esta página");
    exit();
}

// Variables de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stock_constructora";

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditoría de Materiales</title>

    <!-- CSS de Bootstrap y DataTables -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
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
      gap: 10px;
      align-items: center;
    }

    label {
      font-size: 16px;
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
      cursor: pointer;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 4px;
    }

    .form-button:hover {
      background-color: #0056b3;
    }

    /* Estilos para la lista de selección de materiales */
    .material-container {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    .material-item {
      display: flex;
      align-items: center;
    }

    .material-item label {
      margin-left: 5px;
      font-size: 14px;
    }

    .material-item input[type="checkbox"] {
      margin-right: 10px;
      transform: scale(1.2);
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
    <h1>Auditoría de Materiales</h1>
    
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ¡Los datos se han cargado correctamente!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="table-responsive mt-4">
        <table class="table table-bordered" id="auditoriaTable">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Nombre de la Obra</th>
                    <th>Material</th>
                    <th>Total Necesario</th>
                    <th>Ingreso</th>
                    <th>Salió a otra obra</th>
                    <th>Disponible</th>
                    <th>Falta</th>
                    <th>Sobra</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT a.fecha, a.nombre_obra, m.nombre_material, a.total_necesario, a.ingreso, a.salio_a_otra_obra, a.disponible, a.falta, a.sobra 
                        FROM auditoria_materiales a 
                        JOIN materiales m ON a.id_material = m.id 
                        ORDER BY a.fecha DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $fechaFormateada = date("d-m-Y", strtotime($row['fecha']));
                        echo "<tr>
                                <td>{$fechaFormateada}</td>
                                <td>{$row['nombre_obra']}</td>
                                <td>{$row['nombre_material']}</td>
                                <td>{$row['total_necesario']}</td>
                                <td>{$row['ingreso']}</td>
                                <td>{$row['salio_a_otra_obra']}</td>
                                <td>{$row['disponible']}</td>
                                <td>{$row['falta']}</td>
                                <td>{$row['sobra']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No hay registros de auditoría.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Formulario para cargar auditoría -->
    <form id="auditoria-form" action="procesar_auditoria.php" method="POST">
        <div class="mb-3">
            <label for="nombre_obra" class="form-label">Nombre de la Obra</label>
            <input type="text" class="form-control" id="nombre_obra" name="nombre_obra" required>
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>

        <!-- Selección de materiales -->
        <div class="mb-3">
            <label for="materiales" class="form-label">Seleccionar Materiales</label>
            <div id="materiales" class="material-container">
                <?php
                $sql = "SELECT codigo_material, nombre_material, unidad FROM materiales";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <div class="material-item">
                            <input type="checkbox" name="materiales[]" value="' . $row['codigo_material'] . '">
                            <label>' . $row['nombre_material'] . ' - ' . $row['codigo_material'] . ' - ' . $row['unidad'] . '</label>
                        </div>';
                    }
                }
                ?>
            </div>
        </div>

        <div class="mb-3">
            <label for="total_necesario" class="form-label">Total Necesario</label>
            <input type="number" class="form-control" id="total_necesario" name="total_necesario" required>
        </div>
        <div class="mb-3">
            <label for="ingreso" class="form-label">Ingreso</label>
            <input type="number" class="form-control" id="ingreso" name="ingreso" required>
        </div>
        <div class="mb-3">
            <label for="salio_a_otra_obra" class="form-label">Salió a otra obra</label>
            <input type="number" class="form-control" id="salio_a_otra_obra" name="salio_a_otra_obra" required>
        </div>
        <button type="submit" class="form-button">Cargar Auditoría</button>
    </form>
</div>

<!-- Scripts de Bootstrap y DataTables -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    // Inicialización de DataTable
    $(document).ready(function() {
        $('#auditoriaTable').DataTable();
    });
</script>

</body>
</html>

<?php $conn->close(); ?>







