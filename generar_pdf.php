<?php
require('fpdf.php');

// Obtener los datos de la solicitud POST
$numeroRemito = $_POST['numeroRemito'];
$fecha = $_POST['fechaMaterial']; // Obtener la fecha del formulario
$fechaFormateada = date('Y-m-d', strtotime($fecha)); // Formatear la fecha al formato de MySQL
$origen = $_POST['origen'];
$destino = $_POST['destino'];
$codigo = $_POST['codigo'];
$detalle = $_POST['detalle'];
$unidad = $_POST['unidad'];
$cantidad = $_POST['cantidad'];
$observacion = $_POST['observacion'];

// Crear un nuevo objeto FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Escribir los datos en el PDF
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Número de Remito: ' . $numeroRemito, 0, 1);
$pdf->Cell(0, 10, 'Fecha: ' . $fechaFormateada, 0, 1); // Utilizar la fecha formateada
$pdf->Cell(0, 10, 'Origen: ' . $origen, 0, 1);
$pdf->Cell(0, 10, 'Destino: ' . $destino, 0, 1);
$pdf->Cell(0, 10, 'Código: ' . $codigo, 0, 1);
$pdf->Cell(0, 10, 'Detalle: ' . $detalle, 0, 1);
$pdf->Cell(0, 10, 'Unidad: ' . $unidad, 0, 1);
$pdf->Cell(0, 10, 'Cantidad: ' . $cantidad, 0, 1);
$pdf->Cell(0, 10, 'Observación: ' . $observacion, 0, 1);

// Generar el PDF
$pdf->Output();

// Crear conexión a la base de datos
$servername = "localhost"; // Nombre del servidor MySQL
$username = "root"; // Nombre de usuario de MySQL
$password = ""; // Contraseña de MySQL (en este caso, vacía)
$database = "stock_constructora"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Preparar la consulta SQL para insertar datos en la base de datos
$sql = "INSERT INTO nombre_de_tu_tabla (numeroRemito, fecha, origen, destino, codigo, detalle, unidad, cantidad, observacion) 
        VALUES ('$numeroRemito', '$fechaFormateada', '$origen', '$destino', '$codigo', '$detalle', '$unidad', '$cantidad', '$observacion')";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    echo "Los datos se han insertado correctamente.";
} else {
    echo "Error al insertar datos: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

