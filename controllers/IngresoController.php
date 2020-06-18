<?php 
if(strlen(session_id()) < 1)
   session_start();
require_once "../models/Ingreso.php";

$ingreso = new Ingreso();

$idingreso = isset($_POST['idingreso'])? limpiarCadena($_POST['idingreso']): "";
$idproveedor = isset($_POST['idproveedor'])? limpiarCadena($_POST['idproveedor']): "";
$idusuario = $_SESSION['idusuario'];
$tipo_comprobante = isset($_POST['tipo_comprobante'])? limpiarCadena($_POST['tipo_comprobante']): "";
$serie_comprobante = isset($_POST['serie_comprobante'])? limpiarCadena($_POST['serie_comprobante']): "";
$num_comprobante = isset($_POST['num_comprobante'])? limpiarCadena($_POST['num_comprobante']): "";
$fecha_hora = isset($_POST['fecha_hora'])? limpiarCadena($_POST['fecha_hora']): "";
$impuesto = isset($_POST['impuesto'])? limpiarCadena($_POST['impuesto']): "";
$total_compra = isset($_POST['total_compra'])? limpiarCadena($_POST['total_compra']): "";

switch($_GET['op'])
{
   case 'insertaryeditar':
      if(empty($idingreso))
      {
         $respuesta = $ingreso->insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$_POST['idarticulo'],$_POST['cantidad'],$_POST['precio_compra'],$_POST['precio_venta']);
         echo $respuesta ? "Ingreso Registrado" : "No se pudieron registrar todos los datos del ingreso";
      } else {
         
      }
   break;

   case 'anular':
      $respuesta = $ingreso->anular($idingreso);
      echo $respuesta ? "Ingreso anulado" : "Ingreso No se pudo anular" ;
   break;

   case 'mostrar':
      $respuesta = $ingreso->mostrar($idingreso);
      // Codificacion utilizando JSON
      echo json_encode($respuesta);
   break;

   case 'listarDetalle':
      //Recibimos el idingreso
      $id = $_GET['id'];

      $respuesta = $ingreso->listarDetalle($id);
      $total = 0;

      echo '<thead style="background-color:#A9D0F5">
         <th>Opciones</th>
         <th>Artículo</th>
         <th>Cantidad</th>
         <th>Precio Compra</th>
         <th>Precio Venta</th>
         <th>Subtotal</th>
         <th></th>
      </thead>';
      while($reg = $respuesta->fetch_object())
      {
         echo '<tr class="filas">
            <td></td>
            <td>'.$reg->nombre.'</td>
            <td>'.$reg->cantidad.'</td>
            <td>'.$reg->precio_compra.'</td>
            <td>'.$reg->precio_venta.'</td>
            <td>'.$reg->precio_compra * $reg->cantidad.'</td>
         </tr>';
         $total += $reg->precio_compra * $reg->cantidad;
      }
      echo '<tfoot>
            <th colspan="5"><h4>TOTAL</h4></th>

            <th colspan="2"><h4 id="total">Bs/. '.$total.'</h4><input type="hidden" name="total_compra" id=total_compra></th>
      </tfoot>';

   break;

   case 'listar':
      $respuesta = $ingreso->listar();
      $data = Array();
      
      while($reg = $respuesta->fetch_object())
      {
         $fecha = date("d/m/Y", strtotime($reg->fecha));
         $data[] = array(
            "0" => ($reg->estado == 'Aceptado') ?
                     '<button class="btn btn-sm btn-warning" title="Mostrar" onclick="mostrar('.$reg->idingreso.')">
                        <i class="fa fa-eye"></i>
                     </button>
                     <button class="btn btn-sm btn-danger" title="Anular" onclick="anular('.$reg->idingreso.')">
                        <i class="fa fa-window-close"></i>
                     </button>':
                     '<button class="btn btn-sm btn-warning" title="Mostrar" onclick="mostrar('.$reg->idingreso.')">
                        <i class="fa fa-eye"></i>
                     </button>',
            "1" => $fecha,
            "2" => $reg->proveedor,
            "3" => $reg->usuario,
            "4" => $reg->tipo_comprobante,
            "5" => $reg->serie_comprobante.'-'.$reg->num_comprobante,
            "6" => $reg->total_compra.' Bs',
            "7" => ($reg->estado == 'Aceptado') ? '<span class="label bg-green">Aceptado</span>': 
                  '<span class="label bg-red">Anulado</span>',
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

   case 'selectProveedor':
      require_once "../models/Persona.php";
      $persona = new Persona();

      $respuesta = $persona->listarP();

      while($reg = $respuesta->fetch_object())
      {
         echo '<option value='.$reg->idpersona.'>'.$reg->nombre.'</option>';
      }
   break;

   case 'listarArticulos':
      require_once "../models/Articulo.php";
      $articulo = new Articulo();

      $respuesta = $articulo->listarActivos();

      $data = Array();
      
      while($reg = $respuesta->fetch_object())
      {
         $data[] = array(
            "0" => '<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\')"><i class="fa fa-plus"></i> Agregar</button>',
            "1" => $reg->nombre,
            "2" => $reg->categoria,
            "3" => $reg->codigo,
            "4" => $reg->stock,
            "5" => '<img src="../files/articulos/'.$reg->imagen.'" height="50px" width="50px">',
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