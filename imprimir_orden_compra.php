<?php
require('fpdf/fpdf.php');

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'stock_constructora');

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Variables de búsqueda
$empresa = isset($_GET['empresa']) ? $_GET['empresa'] : '';
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';

// Consulta para obtener las órdenes de compra
$sql = "SELECT oc.*, m.nombre_material 
        FROM ordenes_compra oc
        JOIN materiales m ON oc.codigo_material = m.codigo_material
        WHERE (? = '' OR oc.empresa LIKE ?)
        AND (? = '' OR oc.fecha = ?)
        ORDER BY oc.fecha DESC";

$stmt = $conexion->prepare($sql);
$empresa_param = '%' . $empresa . '%';
$stmt->bind_param('ssss', $empresa, $empresa_param, $fecha, $fecha);
$stmt->execute();
$resultado = $stmt->get_result();

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();

// Usar Helvetica
$pdf->SetFont('Helvetica', '', 12); // Configurar la fuente para el documento

// Insertar el logo en la parte superior izquierda
$pdf->Image('logo.jpg', 10, 10, 30); // Ajusta la posición y el tamaño (10, 10, 30)

// Añadir un salto de línea para mover el título hacia abajo
$pdf->Ln(25); // Ajusta el valor según sea necesario para separar el logo del título

// Título del documento
$pdf->SetFont('Helvetica', 'B', 16); // Aumentar el tamaño y usar negrita para el título
$pdf->Cell(0, 10, utf8_decode('Órdenes de Compra'), 0, 1, 'C');
$pdf->Ln(5);

// Definir ancho de columnas (ajustados)
$anchos = [25, 35, 25, 35, 20, 25, 24]; // Reducidos para que quepan en la hoja
$alturaEncabezado = 12; // Altura de celdas de encabezado

// Encabezados de la tabla
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->SetFillColor(200, 200, 200); // Color de fondo para encabezados

// Ajustamos cada encabezado
$pdf->Cell($anchos[0], $alturaEncabezado, utf8_decode("Código"), 1, 0, 'C', true);
$pdf->Cell($anchos[1], $alturaEncabezado, utf8_decode("Material"), 1, 0, 'C', true);
$pdf->Cell($anchos[2], $alturaEncabezado, utf8_decode("Cantidad"), 1, 0, 'C', true);
$pdf->Cell($anchos[3], $alturaEncabezado, utf8_decode("Encargado"), 1, 0, 'C', true);
$pdf->Cell($anchos[4], $alturaEncabezado, utf8_decode("Depósito"), 1, 0, 'C', true);
$pdf->Cell($anchos[5], $alturaEncabezado, utf8_decode("Proveedor"), 1, 0, 'C', true);
$pdf->Cell($anchos[6], $alturaEncabezado, utf8_decode("Fecha"), 1, 1, 'C', true);

// Contenido de la tabla
$pdf->SetFont('Helvetica', '', 10);
while ($fila = $resultado->fetch_assoc()) {
    $fechaFormateada = date("d-m-Y", strtotime($fila['fecha']));

    $pdf->Cell($anchos[0], 10, utf8_decode($fila['codigo_material']), 1, 0, 'C');
    $pdf->Cell($anchos[1], 10, utf8_decode($fila['nombre_material']), 1, 0, 'C');
    $pdf->Cell($anchos[2], 10, $fila['cantidad'], 1, 0, 'C');
    $pdf->Cell($anchos[3], 10, utf8_decode($fila['persona_solicitante']), 1, 0, 'C');
    $pdf->Cell($anchos[4], 10, utf8_decode($fila['deposito']), 1, 0, 'C');
    $pdf->Cell($anchos[5], 10, utf8_decode($fila['empresa']), 1, 0, 'C');
    $pdf->Cell($anchos[6], 10, $fechaFormateada, 1, 1, 'C');
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

// Salida del PDF
$pdf->Output('I', 'ordenes_compra.pdf');
?>










