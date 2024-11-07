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

// Verificar si se recibió el ID del material a eliminar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para eliminar el material
    $sql = "DELETE FROM stock WHERE id_stock = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Material eliminado correctamente.";
    } else {
        echo "Error al eliminar el material: " . $conn->error;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();

// Redireccionar de nuevo a la página de gestión de stock
header("Location: gestionstock.php");
exit();
