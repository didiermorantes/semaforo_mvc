<?php
require_once '../config.php';
require_once __DIR__ . '/../app/models/Bitacora.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['direccion']) || $_SESSION['direccion'] !== 'Administrador') {
    echo "Acceso denegado. Funcionalidad solo disponible para el Administrador.";
    exit;
}

$modelo = new Bitacora();

$filtro = isset($_GET['filtro']) ? trim($_GET['filtro']) : '';
if ($filtro !== '') {
    $bitacora = $modelo->filtrarPorDireccion($filtro);
} else {
    $bitacora = $modelo->obtenerTodas();
}

// --- Incluye FPDF ---
require_once __DIR__ . '/../vendor/fpdf/fpdf.php';

// --- Crear PDF ---
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Reporte de Bitacora',0,1,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15,8,'ID',1);
$pdf->Cell(25,8,'Compromiso',1);
$pdf->Cell(40,8,'Direccion',1);
$pdf->Cell(35,8,'Accion',1);
$pdf->Cell(50,8,'Fecha',1);
$pdf->Ln();

$pdf->SetFont('Arial','',9);
if ($bitacora && count($bitacora) > 0) {
    foreach ($bitacora as $row) {
        $pdf->Cell(15,7, $row['id'], 1);
        $pdf->Cell(25,7, $row['compromiso_id'], 1);
        $pdf->Cell(40,7, $row['direccion_responsable'], 1);
        $pdf->Cell(35,7, $row['accion'], 1);
        $pdf->Cell(50,7, $row['fecha'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0,10,'No hay registros en la bitacora.',1,1,'C');
}

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="bitacora_'.date('Ymd_His').'.pdf"');
$pdf->Output('D', 'bitacora_'.date('Ymd_His').'.pdf');
exit;
