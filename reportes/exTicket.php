<?php 
//Activar almacenamiento en buffer
ob_start();
if(strlen(session_id()) < 1){
  session_start();
}

if(!isset($_SESSION['nombre']))
{
    echo 'Debe ingresar al sistema correctamente para visualizar el Ticket';
} else {
	if($_SESSION['ventas'] == 1)
	{
		require('../fpdf182/fpdf.php');

		//Datos de la Empresa
		$empresa = "Soluciones FeTb";
		$NIT = "1122334455";
		$direccion = "Av. Sucre 1000";
		$telefono = "6412345";
		$email = "empresa@mail.com";


		$pdf = new FPDF($orientation='P',$unit='mm', array(45,350));
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',8);    //Letra Arial, negrita (Bold), tam. 20
		$textypos = 5;

		$pdf->setY(2);
		$pdf->setX(7);
		$pdf->Cell(5,$textypos,".:: Soluciones FeTb ::.","C");
		$pdf->SetFont('Arial','',5);    //Letra Arial, negrita (Bold), tam. 20
		$textypos+=6;
		$pdf->setX(2);
		$pdf->Cell(5,$textypos,"NIT: ".$NIT);
		$pdf->setY(5);
		$pdf->setX(2);
		$pdf->Cell(5,$textypos,utf8_decode("DIRECCIÓN: ").$direccion);
		$pdf->setY(8);
		$pdf->setX(2);
		$pdf->Cell(5,$textypos,utf8_decode("TELÉFONO: ").$telefono);
		$pdf->setY(11);
		$pdf->setX(2);
		$pdf->Cell(5,$textypos,"EMAIL: ".$email);
		$pdf->SetFont('Arial','',5);    //Letra Arial, negrita (Bold), tam. 20
		$textypos+=6;
		$pdf->setX(2);
		$pdf->Cell(5,$textypos,'-------------------------------------------------------------------');
		//Obtenemos datos para la cabecera
		require_once "../models/Venta.php";
		$venta = new Venta();

		$respuestaC = $venta->ventaCabecera($_GET['id']);
		$regC = $respuestaC->fetch_object();

		$pdf->setY(14);
		$pdf->setX(2);
		$pdf->Cell(5,$textypos,"CLIENTE: ".utf8_decode($regC->cliente));
		$pdf->setY(17);
		$pdf->setX(2);
		$pdf->Cell(5,$textypos,$regC->tipo_documento.': '.$regC->num_documento);
		$pdf->setY(20);
		$pdf->setX(2);
		$pdf->Cell(5,$textypos,"FECHA: ".date("d/m/Y", strtotime($regC->fecha)));
		$pdf->SetFont('Arial','',5);    //Letra Arial, negrita (Bold), tam. 20
		$textypos+=6;
		$pdf->setX(2);
		$pdf->Cell(5,$textypos,'-------------------------------------------------------------------');

		$textypos+=6;
		$pdf->setX(2);
		$pdf->Cell(5,$textypos,'ARTICULO                     CANT.   PRECIO   TOTAL');

		$total =0;
		$off = $textypos+6;

		$respuestaD = $venta->ventaDetalle($_GET['id']);

		//Recorremos las filas
		while($regD = $respuestaD->fetch_object())
		{
			$pdf->setX(2);
			$pdf->Cell(5,$off,$regD->articulo);
			$pdf->setX(23);
			$pdf->Cell(35,$off,strtoupper($regD->cantidad) );
			$pdf->setX(25);
			$pdf->Cell(11,$off,number_format($regD->precio_venta,2,".",",") ,0,0,"R");
			$pdf->setX(33);
			$pdf->Cell(11,$off,number_format($regD->precio_venta*$regD->cantidad,2,".",",") ,0,0,"R");

			$total += $regD->subtotal;
			$off+=6;
		}

		$textypos=$off+6;

		$pdf->setX(2);
		$pdf->Cell(5,$textypos,"TOTAL: " );
		$pdf->setX(38);
		$pdf->Cell(5,$textypos,"Bs. ".number_format($total,2,".",","),0,0,"R");


		$textypos+=6;
		$pdf->setX(2);
		$pdf->Cell(5,$textypos,'-------------------------------------------------------------------');
		$pdf->setX(10);
		$pdf->Cell(5,$textypos+6,'GRACIAS POR TU COMPRA ');

		$pdf->output();		

	} else {
    	echo 'No tiene permisos para visualizar el Ticket';
	}
}
ob_end_flush();
?>