<?php 
require_once "../models/Articulo.php";

$articulo = new Articulo();

$idarticulo = isset($_POST['idarticulo'])? limpiarCadena($_POST['idarticulo']): "";
$idcategoria = isset($_POST['idcategoria'])? limpiarCadena($_POST['idcategoria']): "";
$codigo = isset($_POST['codigo'])? limpiarCadena($_POST['codigo']): "";
$nombre = isset($_POST['nombre'])? limpiarCadena($_POST['nombre']): "";
$stock = isset($_POST['stock'])? limpiarCadena($_POST['stock']): "";
$descripcion = isset($_POST['descripcion'])? limpiarCadena($_POST['descripcion']): "";
$imagen = isset($_POST['imagen'])? limpiarCadena($_POST['imagen']): "";

switch($_GET['op'])
{
   case 'insertaryeditar':

      //Validar imagen
      
      if(!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
      {
         $imagen = $_POST['imagenactual'];
      }
      else
      {
         $ext = explode(".", $_FILES['imagen']['name']);
         if($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
         {
            $imagen = round(microtime(true)) . '.' . end($ext);
            move_uploaded_file($_FILES['imagen']['tmp_name'], '../files/articulos/'.$imagen);
         }
      }

      if(empty($idarticulo))
      {
         $respuesta = $articulo->insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
         echo $respuesta ? "Articulo Registrado" : "Articulo No se pudo registrar" ;
      } else {
         $respuesta = $articulo->editar($idarticulo,$idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
         echo $respuesta ? "Articulo actualizado" : "Articulo No se pudo actualizar" ;
      }
   break;

   case 'desactivar':
      $respuesta = $articulo->desactivar($idarticulo);
      echo $respuesta ? "Articulo desactivado" : "Articulo No se pudo desactivar" ;
   break;

   case 'activar':
      $respuesta = $articulo->activar($idarticulo);
      echo $respuesta ? "Articulo activado" : "Articulo No se pudo activar" ;
   break;

   case 'mostrar':
      $respuesta = $articulo->mostrar($idarticulo);
      // Codificacion utilizando JSON
      echo json_encode($respuesta);
   break;

   case 'listar':
      $respuesta = $articulo->listar();
      $data = Array();
      
      while($reg = $respuesta->fetch_object())
      {
         $data[] = array(
            "0" => $reg->condicion ?
                     '<button class="btn btn-sm btn-warning" title="Editar" onclick="mostrar('.$reg->idarticulo.')">
                        <i class="fa fa-pencil-alt"></i>
                     </button>
                     <button class="btn btn-sm btn-danger" title="Desactivar" onclick="desactivar('.$reg->idarticulo.')">
                        <i class="fa fa-window-close"></i>
                     </button>':
                     '<button class="btn btn-sm btn-warning" title="Editar" onclick="mostrar('.$reg->idarticulo.')">
                        <i class="fa fa-pencil-alt"></i>
                     </button>
                     <button class="btn btn-sm btn-primary" title="Activar" onclick="activar('.$reg->idarticulo.')">
                        <i class="fa fa-check"></i>
                     </button>',
            "1" => $reg->nombre,
            "2" => $reg->categoria,
            "3" => $reg->codigo,
            "4" => $reg->stock,
            "5" => '<img src="../files/articulos/'.$reg->imagen.'" height="50px" width="50px">',
            "6" => $reg->condicion ? '<span class="label bg-green">Activado</span>': 
                                     '<span class="label bg-red">Desactivado</span>',
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

   case "selectCategoria":
      require_once "../models/Categoria.php";
      $categoria = new Categoria();

      $respuesta = $categoria->select();

      while($reg = $respuesta->fetch_object())
      {
         echo '<option value='.$reg->idcategoria.'>'.$reg->nombre.'</option>';
      }
   break;
}

?>