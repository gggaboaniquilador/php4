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
   $select = $pdo->prepare("SELECT * FROM tbl_invoice WHERE order_date BETWEEN :fromdate AND :todate");
   $select->bindParam(':fromdate', $_POST['date_1']);
   $select->bindParam(':todate', $_POST['date_2']);
   $select->execute();
   while($row=$select->fetch(PDO::FETCH_OBJ)){
                         
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