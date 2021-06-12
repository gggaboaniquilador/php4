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
    $this->Cell(55,0,'',0,0,'C');
    //Título
    $this->Cell(90,20,'Tabla Unidades',1,0,'C');
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
$this->SetFillColor(0, 129, 161);
$this->SetTextColor(255);
$this->SetDrawColor(0, 159, 197);
$this->SetLineWidth(.3);
$this->SetFont('','B',10);
$this->Cell(50,0,'',0,0,'C');
//Cabecera

for($i=0;$i<count($header);$i++)

$this->Cell(50,7,$header[$i],1,0,'C',1);
$this->Ln();
//Restauración de colores y fuentes
$this->SetFillColor(224,231,255);
$this->SetTextColor(0);
$this->SetFont('');
$this->Cell(50,0,'',0,0,'C');
//Datos
   $fill=true;
   include_once'../db/connect_db.php';
  $select = $pdo->prepare("SELECT * FROM tbl_satuan WHERE deleteS=0");
	$select->execute();
	$row = $select->fetchAll();
   foreach ($row as $counter => $value) {
   	$this->Cell(50,6,$value["kd_satuan"],'LR',0,'L',$fill);
   	$this->Cell(50,6,$value["nm_satuan"],'LR',1,'L',$fill);
    $this->Cell(50,0,'',0,0,'C');
   }
$this->Cell(100,0,'','T');
}

   
   
}

$pdf=new PDF('P','mm','a4');
//Títulos de las columnas
$header=array('Codigo de unidad','Nombre de unidad');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetY(65);
$pdf->TablaColores($header);
$pdf->Output();