<?php 
//Activar almacenamiento en buffer
ob_start();
if(strlen(session_id()) < 1){
  session_start();
}

if(!isset($_SESSION['nombre']))
{
    echo 'Debe ingresar al sistema correctamente para visualizar la Factura';
} else {
	if($_SESSION['ventas'] == 1)
	{
        require('Factura.php');

        //Datos de la Empresa
        $empresa = "Soluciones FeTb";
        $NIT = "1122334455";
        $direccion = "Av. Sucre 1000";
        $telefono = "6412345";
        $email = "empresa@mail.com";

        $pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
        $pdf->AddPage();
        $pdf->addSociete( $empresa,
                        "NIT: ".$NIT."\n" .
                        utf8_decode("Dirección: ").$direccion."\n".
                        utf8_decode("Teléfono: ").$telefono."\n" .
                        "Email: ".$email );

        // Insert a logo in the top-left corner at 300 dpi
        $pdf->Image('logo.png',10,7);

        //Obtenemos datos para la cabecera
        require_once "../models/Venta.php";
        $venta = new Venta();

        $respuestaC = $venta->ventaCabecera($_GET['id']);

        $regC = $respuestaC->fetch_object();

        $pdf->fact_dev( $regC->tipo_comprobante, "$regC->serie_comprobante - $regC->num_comprobante" );

        //Marca de Agua
        $pdf->temporaire( "" );

        $pdf->addDate(date("d/m/Y", strtotime($regC->fecha)));
        //$pdf->addClient("CL01");
        //$pdf->addPageNumber("1");

        $pdf->addClientAdresse("DATOS DEL CLIENTE:\n".
                                utf8_decode($regC->cliente)."\n".
                                utf8_decode('Dirección: ').utf8_decode($regC->direccion)."\n".
                                $regC->tipo_documento.': '.$regC->num_documento."\n".
                                'Email: '.$regC->email."\n".
                                utf8_decode('Teléfono: ').$telefono);


        //CABECERA
        $cols=array( "CODIGO"    => 23,
                    "DESCRIPCION"  => 78,
                    "CANTIDAD"     => 22,
                    "P.U."      => 25,
                    "DSCTO" => 20,
                    "SUBTOTAL"          => 22 );
        $pdf->addCols( $cols);
        $cols=array( "CODIGO"    => "L",
                    "DESCRIPCION"  => "L",
                    "CANTIDAD"     => "C",
                    "P.U."      => "R",
                    "DSCTO" => "R",
                    "SUBTOTAL"          => "C" );
        $pdf->addLineFormat($cols);
        $pdf->addLineFormat($cols);


        //CUERPO
        $y    = 79;
        $respuestaD = $venta->ventaDetalle($_GET['id']);
        $total = 0;
        //Recorremos las filas
        while($regD = $respuestaD->fetch_object())
        {
            $line = array( "CODIGO"    => "$regD->codigo",
                    "DESCRIPCION"  => "$regD->articulo",
                    "CANTIDAD"     => "$regD->cantidad",
                    "P.U."      => "$regD->precio_venta",
                    "DSCTO" => "$regD->descuento",
                    "SUBTOTAL"          => "$regD->subtotal" );
            $size = $pdf->addLine( $y, $line );
            $y   += $size + 2;
            $total += $regD->subtotal;
        }

        if($regC->tipo_comprobante == 'Boleta')
        {
            $iva = 0;
        } else {
            $iva = 0.13;
        }
        $pdf->addCadreEurosFrancs($total,$iva);
        
        $total = number_format($total*0.87+$total*$iva,2,".",",");


        //Transformando en letras
        $formatterES = new NumberFormatter("es-ES", NumberFormatter::SPELLOUT);
        $izquierda = intval(floor($total));
        $derecha = intval(($total - floor($total)) * 100);
        
        $totalLetras = strtoupper($formatterES->format($izquierda) . " bolivianos " . $derecha."/100");

    
        //$totalLetras = "QUINIENTOS CINCUENTA Y CUATRO MIL BOLIVIANOS 00/100";
        $pdf->addCadreTVAs($totalLetras);     

        
        $pdf->Output();
	} else {
    	echo 'No tiene permisos para visualizar la Factura';
	}
}
ob_end_flush();
?>