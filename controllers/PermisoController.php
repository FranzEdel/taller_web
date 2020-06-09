<?php 
require "../models/Permiso.php";

$permiso = new Permiso();

switch($_GET['op'])
{
   case 'listar':
      $respuesta = $permiso->listar();
      $data = Array();
      //print_r($respuesta); exit();
      while($reg = $respuesta->fetch_object())
      {
         $data[] = array(
            "0" => $reg->nombre
         );
      }

      $results = array(
         "sEcho" => 1, // Informacion para el datatablas
         "iTotalRecords" => count($data), // enviamos el total de registros al datatables
         "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
         "aaData" => $data
      );
      echo json_encode($results);
   break;
}

?>