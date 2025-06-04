<?php
require('fpdf/fpdf.php');
require_once('../funciones.php'); // tu archivo de conexión

if (!isset($_GET['id'])) {
    die("Falta el ID de la factura.");
}

$id_venta = intval($_GET['id']);
$conn = db_connect();

// Consulta para obtener datos de la factura
    $sql = "SELECT ventas.id_venta AS ventaID, total, fecha, unidades, juegos_venta.precio, juegos_venta.precio AS precio, usuarios.nombre AS usuario, apellido1, apellido2, NIF, telefono, email, juegos.nombre AS juego
                FROM ventas JOIN juegos_venta ON ventas.id_venta=juegos_venta.id_venta
                JOIN usuarios ON usuarios.id_usuario=ventas.id_usuario
                JOIN juegos ON juegos.id_juego=juegos_venta.id_juego
                WHERE ventas.id_venta = $id_venta";
    $results = db_query($conn, $sql);

    $numeroFactura = htmlspecialchars($results[0]["ventaID"]);
    $total = $results[0]["total"];
    $fecha = $results[0]["fecha"];
    $nombre = $results[0]["usuario"];
    $apellido1 = $results[0]["apellido1"];
    $apellido2 = $results[0]["apellido2"] ?? "";
    $nif = $results[0]["NIF"];
    $telefono = $results[0]["telefono"];
    $email = $results[0]["email"];


function conv($texto) {
    return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $texto);
}

class PDF extends FPDF {
    function Footer() {
        $this->SetY(-30); // A 30 unidades del fondo
        $this->SetFont('Arial', 'I', 9);
        $this->MultiCell(0, 5, conv("Gracias por su compra.\nGament S.L. - www.gament.com - contacto@gament.com\nEste documento es válido como justificante de compra."), 0, 'C');
    }
}

// Iniciar PDF
$pdf = new PDF();
$pdf->AddPage();

// LOGO
$pdf->Image('../img/logo.png', 10, 10, 30); // (ruta, x, y, tamaño en mm)
$pdf->SetXY(45, 10); // Mover cursor a la derecha del logo

// TÍTULO
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Gament S.L.', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Factura de Venta', 0, 1);

$pdf->Ln(5);

// FECHA (con IntlDateFormatter moderno)
$formatter = new \IntlDateFormatter(
    'es_ES',
    \IntlDateFormatter::LONG,
    \IntlDateFormatter::NONE,
    'Europe/Madrid',
    \IntlDateFormatter::GREGORIAN
);
$fecha_obj = new DateTime($fecha);
$fecha_formateada = $formatter->format($fecha_obj);

// Info factura
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Factura Nº:', 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, conv($numeroFactura), 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Fecha:', 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, conv($fecha_formateada), 0, 1);
$pdf->Ln(5);

// Cliente
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(0, 10, 'Datos del Cliente', 0, 1);
$pdf->SetDrawColor(0, 0, 0);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(3);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, conv("Nombre: $nombre $apellido1 $apellido2"), 0, 1);
$pdf->Cell(0, 8, conv("NIF: $nif"), 0, 1);
$pdf->Cell(0, 8, conv("Teléfono: $telefono"), 0, 1);
$pdf->Cell(0, 8, conv("Email: $email"), 0, 1);

$pdf->Ln(10);

// Tabla productos
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Detalle de productos', 0, 1);
$pdf->SetFillColor(230, 230, 230);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(80, 10, 'Juego', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Unidades', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Precio unitario (EUR)', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Subtotal (EUR)', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 11);
$fill = false;
foreach ($results as $linea) {
    $juego = conv($linea["juego"]);
    $unidades = conv($linea["unidades"]);
    $precio = number_format($linea["precio"], 2);
    $subtotal = number_format($linea["precio"] * $unidades, 2);

    $pdf->SetFillColor(245, 245, 245);
    $pdf->Cell(80, 10, $juego, 1, 0, 'L', $fill);
    $pdf->Cell(30, 10, $unidades, 1, 0, 'C', $fill);
    $pdf->Cell(40, 10, $precio, 1, 0, 'R', $fill);
    $pdf->Cell(40, 10, $subtotal, 1, 1, 'R', $fill);
    $fill = !$fill;
}

$pdf->Ln(5);

// Total final
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(150, 12, 'Total pagado:', 0, 0, 'R');
$pdf->Cell(40, 12, number_format($total, 2) . " EUR", 0, 1, 'R');

$pdf->Ln(10);

// Salida del PDF
$pdf->Output();
?>