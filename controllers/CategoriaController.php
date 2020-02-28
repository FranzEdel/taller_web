<?php 
require_once "../models/Categoria.php";

$categoria = new Categoria();

$idcategoria = isset($_POST['idcategoria'])? limpiarCadena($_POST['idcategoria']): "";

$nombre = isset($_POST['nombre'])? limpiarCadena($_POST['nombre']): "";

$descripcion = isset($_POST['descripcion'])? limpiarCadena($_POST['descripcion']): "";

switch($_GET['op'])
{
   case 'insertaryeditar':
      if(empty($idcategoria))
      {
         $respuesta = $categoria->insertar($nombre, $descripcion);
         echo $respuesta ? "Categoria Registrada" : "Categoria No se pudo registrar" ;
      } else {
         $respuesta = $categoria->editar($idcategoria,$nombre, $descripcion);
         echo $respuesta ? "Categoria actualizada" : "Categoria No se pudo actualizar" ;
      }
   break;

   case 'desactivar':
      $respuesta = $categoria->desactivar($idcategoria);
      echo $respuesta ? "Categoria desactivada" : "Categoria No se pudo desactivar" ;
   break;

   case 'activar':
      $respuesta = $categoria->activar($idcategoria);
      echo $respuesta ? "Categoria activada" : "Categoria No se pudo activar" ;
   break;

   case 'mostrar':
      $respuesta = $categoria->mostrar($idcategoria);
      // Codificacion utilizando JSON
      echo json_encode($respuesta);
   break;

   case 'listar':
      $respuesta = $categoria->listar();
      $data = Array();
      echo "<pre>";
      var_dump($respuesta);
      echo "</pre>";
   break;
}

?>