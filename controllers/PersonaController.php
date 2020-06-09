<?php 
require "../models/Persona.php";

$persona = new Persona();

$idpersona = isset($_POST['idpersona'])? limpiarCadena($_POST['idpersona']):"";
$nombre = isset($_POST['nombre'])? limpiarCadena($_POST['nombre']):"";
$tipo_persona = isset($_POST['tipo_persona'])? limpiarCadena($_POST['tipo_persona']):"";
$tipo_documento = isset($_POST['tipo_documento'])? limpiarCadena($_POST['tipo_documento']):"";
$num_documento = isset($_POST['num_documento'])? limpiarCadena($_POST['num_documento']):"";
$direccion = isset($_POST['direccion'])? limpiarCadena($_POST['direccion']):"";
$telefono = isset($_POST['telefono'])? limpiarCadena($_POST['telefono']):"";
$email = isset($_POST['email'])? limpiarCadena($_POST['email']):"";

switch($_GET['op'])
{
   case 'guardaryeditar':
      if(empty($idpersona))
      {
         $respuesta = $persona->insertar($tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email);
         echo $respuesta ? "Persona registrada" : "Persona no se pudo registrar";
      } else {
         $respuesta = $persona->editar($idpersona, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email);
         echo $respuesta ? "Persona actualizada" : "Persona no se pudo actualizar";
      }
   break;

   case 'eliminar':
      $respuesta = $persona->eliminar($idpersona);
      echo $respuesta ? "Persona eliminada" : "Persona no se pudo eliminar";
   break;

   case 'mostrar':
      $respuesta = $persona->mostrar($idpersona);
      // Codificamos el resultado utilizando json
      echo json_encode($respuesta);
   break;

   case 'listarp':
      $respuesta = $persona->listarp();
      $data = Array();
      //print_r($respuesta); exit();
      while($reg = $respuesta->fetch_object())
      {
         $data[] = array(
            "0" => '<button class="btn btn-sm btn-warning" onclick="mostrar('.$reg->idpersona.')"title="Editar"><i class="fa fa-pencil-alt"></i><button>'.
                   '<button class="btn btn-sm btn-danger" onclick="eliminar('.$reg->idpersona.')" title="Eliminar"><i class="fa fa-trash"></i><button>',
            "1" => $reg->nombre,
            "2" => $reg->tipo_documento,
            "3" => $reg->num_documento,
            "4" => $reg->telefono,
            "5" => $reg->email
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

   case 'listarc':
      $respuesta = $persona->listarc();
      $data = Array();
      //print_r($respuesta); exit();
      while($reg = $respuesta->fetch_object())
      {
         $data[] = array(
            "0" => '<button class="btn btn-sm btn-warning" onclick="mostrar('.$reg->idpersona.')"title="Editar"><i class="fa fa-pencil-alt"></i><button>'.
                   '<button class="btn btn-sm btn-danger" onclick="eliminar('.$reg->idpersona.')" title="Eliminar"><i class="fa fa-trash"></i><button>',
            "1" => $reg->nombre,
            "2" => $reg->tipo_documento,
            "3" => $reg->num_documento,
            "4" => $reg->telefono,
            "5" => $reg->email
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