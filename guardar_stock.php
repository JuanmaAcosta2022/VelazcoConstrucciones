<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "stock_constructora";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $material = $_POST['material'];
    $unidad = $_POST['unidad'];
    $fecha = $_POST['fecha'];
    $detalle = $_POST['detalle'];
    $ingreso = $_POST['ingreso'];
    $salida = $_POST['salida'];
    $observacion = $_POST['observacion'];

    // Recuperar el stock actual del material especificado
    $sql_select = "SELECT stock FROM stock WHERE nombre_material = '$material' ORDER BY fecha DESC LIMIT 1";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        // El material ya existe en el stock, actualizar el stock actual
        $row = $result->fetch_assoc();
        $stock_actual = $row['stock'];

        // Realizar la operación de suma o resta en el campo stock
        if (!empty($ingreso)) {
            $stock_actual += $ingreso;
        } elseif (!empty($salida)) {
            $stock_actual -= $salida;
        }

    } else {
        // El material no existe en el stock, iniciar con el stock inicial proporcionado
        if (!empty($ingreso)) {
            $stock_actual = $ingreso;
        } else {
            $stock_actual = 0;
        }
    }

    // Insertar los datos en la base de datos
    $sql_insert = "INSERT INTO stock (nombre_material, unidad, fecha, detalle, ingreso, salida, stock, observacion)
                   VALUES ('$material', '$unidad', '$fecha', '$detalle', '$ingreso', '$salida', '$stock_actual', '$observacion')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Nuevo material agregado con éxito";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>