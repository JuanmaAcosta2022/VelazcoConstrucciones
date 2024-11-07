<?php
// Incluye la librería FPDF
require('fpdf/fpdf.php');

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stock_constructora";
$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener el ID del remito desde la URL
$id_remito = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_remito > 0) {
    // Consulta para obtener los detalles del remito principal
    $query = "SELECT * FROM remitos WHERE id_remito = $id_remito";
    $resultado = $conexion->query($query);

    if ($resultado && $resultado->num_rows > 0) {
        // Obtener los datos del remito principal
        $remito = $resultado->fetch_assoc();

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();

// Logo
$pdf->Image('logo.jpg', 10, 10, 30);

// Encabezado del remito
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('REMITO'), 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, utf8_decode('NO VÁLIDO COMO FACTURA'), 0, 1, 'C');
$pdf->Ln(5); // Pequeño espacio debajo del encabezado

// Información del remito (Remito N° y Fecha alineados a la derecha)
$pdf->SetY(35); // Ajusta este valor según necesites para alinearlo verticalmente
$pdf->Cell(0, 10, utf8_decode('Remito N°: ') . $remito['id_remito'], 0, 1, 'R');

// Formato de fecha a "día-mes-año"
$fecha_formateada = date("d-m-Y", strtotime($remito['fecha']));
$pdf->Cell(0, 10, utf8_decode('Fecha: ') . $fecha_formateada, 0, 1, 'R');

// Coloca la información "Responsable:", "Origen:", y "Destino:" a la misma altura
$pdf->SetY(35); // Mismo valor de Y para alinear en la misma línea
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, utf8_decode('Responsable:'), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Origen: ') . utf8_decode($remito['origen']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Destino: ') . utf8_decode($remito['destino']), 0, 1);
$pdf->Ln(5); // Espacio antes de la siguiente sección

// Consulta para obtener los detalles del material asociado al remito
$queryDetalles = "SELECT detalle, unidad, cantidad, observacion FROM remitos WHERE id_remito = $id_remito";
$resultadoDetalles = $conexion->query($queryDetalles);

// Tabla de detalles
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(60, 10, utf8_decode('Detalle'), 1);
$pdf->Cell(30, 10, utf8_decode('Unidad'), 1);
$pdf->Cell(30, 10, utf8_decode('Cantidad'), 1);
$pdf->Cell(70, 10, utf8_decode('Observación'), 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);

// Verificar si hay detalles asociados al remito
if ($resultadoDetalles && $resultadoDetalles->num_rows > 0) {
    // Agregar cada detalle a la tabla
    while ($detalle = $resultadoDetalles->fetch_assoc()) {
        $pdf->Cell(60, 10, utf8_decode($detalle['detalle']), 1);
        $pdf->Cell(30, 10, utf8_decode($detalle['unidad']), 1);
        $pdf->Cell(30, 10, $detalle['cantidad'], 1);
        $pdf->Cell(70, 10, utf8_decode($detalle['observacion']), 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(190, 10, utf8_decode('No se encontraron detalles para este remito.'), 1, 1, 'C');
}

// Salida del PDF
$pdf->Output();


    } else {
        echo "Error: No se encontró el remito.";
    }
} else {
    echo "Error: ID de remito no válido.";
}

// Cerrar la conexión
$conexion->close();
