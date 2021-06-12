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
    $this->Cell(90,20,'Tabla Productos',1,0,'C');
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
$this->SetFillColor(24, 186, 0);
$this->SetTextColor(255);
$this->SetDrawColor(18, 144, 0);
$this->SetLineWidth(.3);
$this->SetFont('','B',7);
//Cabecera

for($i=0;$i<count($header);$i++)
$this->Cell(31,7,$header[$i],1,0,'C',1);
$this->Ln();
//Restauración de colores y fuentes
$this->SetFillColor(224,231,255);
$this->SetTextColor(0);
$this->SetFont('');
//Datos
   $fill=true;
   include_once'../db/connect_db.php';
   	$select = $pdo->prepare("SELECT * FROM tbl_product WHERE deleteP=0");
	$select->execute();
	$row = $select->fetchAll();
   foreach ($row as $counter => $value) {
   	$this->Cell(31,6,$value["product_code"],'LR',0,'L',$fill);
   	$this->Cell(31,6,$value["product_name"],'LR',0,'L',$fill);
   	$this->Cell(31,6,$value["product_category"],'LR',0,'R',$fill);
   	$this->Cell(31,6,$value["purchase_price"],'LR',0,'R',$fill);
   	$this->Cell(31,6,$value["sell_price"],'LR',0,'R',$fill);
   	$this->Cell(31,6,$value["stock"],'LR',0,'R',$fill);
    $this->Cell(31,6,$value["min_stock"],'LR',0,'R',$fill);
    $this->Cell(31,6,$value["product_satuan"],'LR',0,'R',$fill);
    $this->Cell(31,6,$value["description"],'LR',1,'R',$fill);
   }
$this->Cell(279,0,'','T');
}

   
   
}

$pdf=new PDF('P','mm','a3');
//Títulos de las columnas
$header=array('Codigo','Producto','Categoria','Precio Compra','Precio Venta','Inventario','Inventario Minimo','Unidad','Descripcion');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetY(65);
$pdf->TablaColores($header);
$pdf->Output();