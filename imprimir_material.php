<?php
require('fpdf/fpdf.php'); // Asegúrate de incluir FPDF

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "stock_constructora");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el ID del material a imprimir
$id_stock = $_GET['id'];

// Consultar los datos del material específico
$sql = "SELECT * FROM stock WHERE id_stock = '$id_stock'";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Crear PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Agregar el logo en la esquina superior izquierda
    $pdf->Image('logo.jpg', 10, 10, 30); // (ruta, x, y, ancho)

    // Espacio debajo del logo
    $pdf->Ln(20);

    // Añadir título centrado
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Detalle de Material', 0, 1, 'C');
    $pdf->Ln(10);

    // Añadir datos del material
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'Fecha:', 0, 0);
    $pdf->Cell(60, 10, date("d-m-Y", strtotime($row['fecha'])), 0, 1);
    
    $pdf->Cell(40, 10, 'Material:', 0, 0);
    $pdf->Cell(60, 10, $row['nombre_material'], 0, 1);
    
    $pdf->Cell(40, 10, 'Unidad:', 0, 0);
    $pdf->Cell(60, 10, $row['unidad'], 0, 1);
    
    $pdf->Cell(40, 10, 'Ingreso:', 0, 0);
    $pdf->Cell(60, 10, $row['ingreso'], 0, 1);
    
    $pdf->Cell(40, 10, 'Salida:', 0, 0);
    $pdf->Cell(60, 10, $row['salida'], 0, 1);
    
    $pdf->Cell(40, 10, 'Stock:', 0, 0);
    $pdf->Cell(60, 10, ($row['ingreso'] - $row['salida']), 0, 1);
    
    $pdf->Cell(40, 10, 'Observacion:', 0, 0);
    $pdf->MultiCell(0, 10, $row['observacion']);
    
    $pdf->Output();
} else {
    echo "No se encontraron datos para el material seleccionado.";
}

// Cerrar la conexión
$conexion->close();
?>

