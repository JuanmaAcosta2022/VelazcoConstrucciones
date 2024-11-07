<?php
require('fpdf/fpdf.php');

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stock_constructora";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Configurar la conexión para que los resultados se obtengan en UTF-8
$conn->set_charset("utf8");

// Obtener el nombre de la obra desde el formulario
$nombre_obra = $_POST['nombre_obra_print'];

// Crear una instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Agregar el logo en la parte superior izquierda
$pdf->Image('logo.jpg', 10, 10, 30); // (ruta, x, y, ancho)

// Posicionar el título "Auditoría de Materiales"
$pdf->SetY(20); // Ajustar la posición vertical para evitar superposición con el logo
$pdf->Cell(0, 10, utf8_decode('Auditoría de Materiales'), 0, 1, 'C');

// Posicionar el nombre de la obra alineado a la izquierda
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode('Nombre de la obra: ' . $nombre_obra), 0, 1, 'L');
$pdf->Ln(10); // Añadir espacio antes de la tabla

// Encabezado de la tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 10, utf8_decode('Fecha'), 1, 0, 'C');
$pdf->Cell(40, 10, utf8_decode('Material'), 1, 0, 'C');

// Usar MultiCell para los encabezados en dos líneas
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(25, 5, utf8_decode("Total\nnecesario"), 1, 'C');
$pdf->SetXY($x + 25, $y);

$x = $pdf->GetX();
$pdf->Cell(20, 10, utf8_decode('Ingreso'), 1, 0, 'C');
$pdf->SetXY($x + 20, $y);

$x = $pdf->GetX();
$pdf->MultiCell(30, 5, utf8_decode("Salió a\notra obra"), 1, 'C');
$pdf->SetXY($x + 30, $y);

$pdf->Cell(20, 10, utf8_decode('Disponible'), 1, 0, 'C');
$pdf->Cell(15, 10, utf8_decode('Falta'), 1, 0, 'C');
$pdf->Cell(15, 10, utf8_decode('Sobra'), 1, 1, 'C');

// Consultar datos de auditoría para la obra especificada
$sql = "SELECT a.fecha, m.nombre_material, a.total_necesario, a.ingreso, a.salio_a_otra_obra, a.disponible, a.falta, a.sobra 
        FROM auditoria_materiales a 
        JOIN materiales m ON a.id_material = m.id 
        WHERE a.nombre_obra = ? 
        ORDER BY a.fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre_obra);
$stmt->execute();
$result = $stmt->get_result();

// Mostrar los datos en el PDF
$pdf->SetFont('Arial', '', 10);
while ($row = $result->fetch_assoc()) {
    $fechaFormateada = date("d-m-Y", strtotime($row['fecha']));
    
    // Celda para la fecha
    $pdf->Cell(30, 10, utf8_decode($fechaFormateada), 1, 0, 'C');

    // MultiCell para el nombre del material (puede tener texto largo)
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 5, utf8_decode($row['nombre_material']), 1, 'C');
    $pdf->SetXY($x + 40, $y);

    // Continuar con las demás celdas de datos
    $pdf->Cell(25, 10, utf8_decode($row['total_necesario']), 1, 0, 'C');
    $pdf->Cell(20, 10, utf8_decode($row['ingreso']), 1, 0, 'C');
    $pdf->Cell(30, 10, utf8_decode($row['salio_a_otra_obra']), 1, 0, 'C');
    $pdf->Cell(20, 10, utf8_decode($row['disponible']), 1, 0, 'C');
    $pdf->Cell(15, 10, utf8_decode($row['falta']), 1, 0, 'C');
    $pdf->Cell(15, 10, utf8_decode($row['sobra']), 1, 1, 'C');
}

// Cerrar conexión
$conn->close();

// Salida del PDF
$pdf->Output('I', 'Auditoria_' . $nombre_obra . '.pdf');
?>









