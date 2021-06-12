<?php
require('../fpdf/fpdf.php');

class PDF extends FPDF
{

//Cabecera de página
   function Header()
   {
    //Logo

    //Arial bold 15
    $this->SetFont('Arial','B',15);
    //Movernos a la derecha
    $this->Cell(80);
    //Título
    $this->Cell(90,20,'Tabla Transacciones',1,0,'C');
    //Salto de línea
   }
   
   //Pie de página
   function Footer()
   {
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
   }
   
   //Tabla coloreada
function TablaColores($header)
{
//Colores, ancho de línea y fuente en negrita
$this->SetFillColor(206, 61, 0);
$this->SetTextColor(255);
$this->SetDrawColor(159, 47, 0);
$this->SetLineWidth(.3);
$this->SetFont('','B',10);
//Cabecera

for($i=0;$i<count($header);$i++)
$this->Cell(39,7,$header[$i],1,0,'C',1);
$this->Ln();
//Restauración de colores y fuentes
$this->SetFillColor(224,247,255);
$this->SetTextColor(0);
$this->SetFont('');
//Datos
   $fill=true;
   include_once'../db/connect_db.php';
   	$select = $pdo->prepare("SELECT * FROM tbl_invoice WHERE deleteI=0");
	$select->execute();
	$row = $select->fetchAll();
	$select = $pdo->prepare("SELECT * FROM tbl_invoice_detail");
	$select->execute();
	$detail = $select->fetchAll();
   foreach ($row as $counter => $value) {
   	$this->Cell(39,6,$value["invoice_id"],'LR',0,'L',$fill);
   	$this->Cell(39,6,$value["cashier_name"],'LR',0,'L',$fill);
   	$this->Cell(39,6,$value["order_date"],'LR',0,'L',$fill);
   	$this->Cell(39,6,$value["time_order"],'LR',0,'R',$fill);
   	$this->Cell(39,6,$value["total"],'LR',0,'R',$fill);
   	$this->Cell(39,6,$value["paid"],'LR',0,'R',$fill);
   	$this->Cell(39,6,$value["due"],'LR',1,'R',$fill);
   }
$this->Cell(273,0,'','T');
}

   
   
}

$pdf=new PDF('P','mm','a3');
//Títulos de las columnas
$header=array('#','Vendedor','Fecha de venta','Hora de la venta','Total','Pagado','Deudas');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetY(65);
$pdf->TablaColores($header);
$pdf->Output();