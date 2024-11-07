<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stock_constructora";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario
$fecha = $_POST['fecha'];
$materiales = $_POST['materiales'];
$total_necesario = $_POST['total_necesario'];
$ingreso = $_POST['ingreso'];
$salio_a_otra_obra = $_POST['salio_a_otra_obra'];
$nombre_obra = $_POST['nombre_obra'];
$id_encargado = 1; // Asigna el ID del encargado aquí o reemplaza por una variable si se obtiene dinámicamente

foreach ($materiales as $codigo_material) {
    // Calcular los valores para Disponible, Falta y Sobra
    $disponible = $total_necesario + $ingreso - $salio_a_otra_obra;
    $falta = max(0, $total_necesario - $disponible);
    $sobra = max(0, $disponible - $total_necesario);

    // Obtener el ID del material
    $sql_material = "SELECT id, nombre_material, unidad FROM materiales WHERE codigo_material = '$codigo_material'";
    $result_material = $conn->query($sql_material);

    if ($result_material->num_rows > 0) {
        $row_material = $result_material->fetch_assoc();
        $id_material = $row_material['id'];

        // Insertar los datos en la tabla auditoria_materiales
        $sql = "INSERT INTO auditoria_materiales (
                    fecha, 
                    id_material, 
                    disponible, 
                    falta, 
                    sobra, 
                    observacion, 
                    id_encargado, 
                    total_necesario, 
                    ingreso, 
                    salio_a_otra_obra, 
                    nombre_obra
                ) VALUES (
                    '$fecha', 
                    '$id_material', 
                    '$disponible', 
                    '$falta', 
                    '$sobra', 
                    '', 
                    '$id_encargado', 
                    '$total_necesario', 
                    '$ingreso', 
                    '$salio_a_otra_obra', 
                    '$nombre_obra'
                )";

        if (!$conn->query($sql)) {
            echo "Error al insertar datos: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: Material no encontrado para el código $codigo_material.";
    }
}

// Cerrar la conexión
$conn->close();

// Redirigir al formulario de auditoría después de guardar
header("Location: formulario_auditoria.php?success=1");
exit();
?>
