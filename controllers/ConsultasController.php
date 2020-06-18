<?php 
require_once "../models/Consultas.php";

$consulta = new Consultas();

switch($_GET['op'])
{
    case 'comprasFecha':

        $fecha_inicio = $_GET['fecha_inicio'];
        $fecha_fin = $_GET['fecha_fin'];

        $respuesta = $consulta->comprasFecha($fecha_inicio,$fecha_fin);
        $data = Array();
        
        while($reg = $respuesta->fetch_object())
        {
            $fecha = date("d/m/Y", strtotime($reg->fecha));
            $data[] = array(
                "0" => $fecha,
                "1" => $reg->usuario,
                "2" => $reg->proveedor,
                "3" => $reg->tipo_comprobante,
                "4" => $reg->serie_comprobante.'-'.$reg->num_comprobante,
                "5" => $reg->total_compra.' Bs',
                "6" => $reg->impuesto.' Bs',
                "7" => ($reg->estado == 'Aceptado') ? '<span class="label bg-green">Aceptado</span>': 
                        '<span class="label bg-red">Anunlado</span>',
            );
        }

        $result = array(
            "sEcho" => 1, //Informacion para el datatable
            "iTotalRecords" => count($data), // enviar el total registros al datatable
            "iTotalDisplayRecords" => count($data), // enviar total registos a visualizar
            "aaData" => $data 
        );

        echo json_encode($result);
    break;

    case 'ventasFecha':

        $fecha_inicio = $_GET['fecha_inicio'];
        $fecha_fin = $_GET['fecha_fin'];
        $idcliente = $_GET['idcliente'];

        $respuesta = $consulta->ventasFecha($fecha_inicio,$fecha_fin,$idcliente);
        $data = Array();
        
        while($reg = $respuesta->fetch_object())
        {
            $fecha = date("d/m/Y", strtotime($reg->fecha));
            $data[] = array(
                "0" => $fecha,
                "1" => $reg->usuario,
                "2" => $reg->cliente,
                "3" => $reg->tipo_comprobante,
                "4" => $reg->serie_comprobante.'-'.$reg->num_comprobante,
                "5" => $reg->total_venta.' Bs',
                "6" => $reg->impuesto.' Bs',
                "7" => ($reg->estado == 'Aceptado') ? '<span class="label bg-green">Aceptado</span>': 
                        '<span class="label bg-red">Anunlado</span>',
            );
        }

        $result = array(
            "sEcho" => 1, //Informacion para el datatable
            "iTotalRecords" => count($data), // enviar el total registros al datatable
            "iTotalDisplayRecords" => count($data), // enviar total registos a visualizar
            "aaData" => $data 
        );

        echo json_encode($result);
    break;
}

?>