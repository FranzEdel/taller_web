<?php 
session_start();
require "../models/Usuario.php";

$usuario = new Usuario();

$idusuario = isset($_POST['idusuario'])? limpiarCadena($_POST['idusuario']):"";
$nombre = isset($_POST['nombre'])? limpiarCadena($_POST['nombre']):"";
$tipo_documento = isset($_POST['tipo_documento'])? limpiarCadena($_POST['tipo_documento']):"";
$num_documento = isset($_POST['num_documento'])? limpiarCadena($_POST['num_documento']):"";
$direccion = isset($_POST['direccion'])? limpiarCadena($_POST['direccion']):"";
$telefono = isset($_POST['telefono'])? limpiarCadena($_POST['telefono']):"";
$email = isset($_POST['email'])? limpiarCadena($_POST['email']):"";
$cargo = isset($_POST['cargo'])? limpiarCadena($_POST['cargo']):"";
$login = isset($_POST['login'])? limpiarCadena($_POST['login']):"";
$clave = isset($_POST['clave'])? limpiarCadena($_POST['clave']):"";
$imagen = isset($_POST['imagen'])? limpiarCadena($_POST['imagen']):"";

switch($_GET['op'])
{
   case 'guardaryeditar':
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
            move_uploaded_file($_FILES['imagen']['tmp_name'], '../files/usuarios/'.$imagen);
         }
      }
      //Hash SHA256 en la contraseña
      $clave_hash = hash('SHA256', $clave);

      if(empty($idusuario))
      {
         $respuesta = $usuario->insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave_hash, $imagen, $_POST['permiso']);
         echo $respuesta ? "Usuario registrado" : "Usuario no se pudo registrar";
      } else {
         // print_r($_POST);
         // echo $imagen;
         // exit();
         $respuesta = $usuario->editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave_hash, $imagen, $_POST['permiso']);
         echo $respuesta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
      }
   break;

   case 'desactivar':
      $respuesta = $usuario->desactivar($idusuario);
      echo $respuesta ? "Usuario desactivado" : "Usuario no se pudo desactivar";
   break;

   case 'activar':
      $respuesta = $usuario->activar($idusuario);
      echo $respuesta ? "Usuario activado" : "Usuario no se pudo activar";
   break;

   case 'mostrar':
      $respuesta = $usuario->mostrar($idusuario);
      // Codificamos el resultado utilizando json
      echo json_encode($respuesta);
   break;

   case 'listar':
      $respuesta = $usuario->listar();
      $data = Array();
      //print_r($respuesta); exit();
      while($reg = $respuesta->fetch_object())
      {
         $data[] = array(
            "0" => ($reg->condicion)? 
                     '<button class="btn btn-sm btn-warning" onclick="mostrar('.$reg->idusuario.')" title="Editar">
                        <i class="fa fa-pencil-alt"></i><button>'.
                     '<button class="btn btn-sm btn-danger" onclick="desactivar('.$reg->idusuario.')" title="Desactivar">
                        <i class="fa fa-window-close"></i><button>' :
                     '<button class="btn btn-sm btn-warning" onclick="mostrar('.$reg->idusuario.')" title="Editar">
                        <i class="fa fa-pencil-alt"></i><button>'.
                     '<button class="btn btn-sm btn-primary" onclick="activar('.$reg->idusuario.')" title="Activar">
                        <i class="fa fa-check"></i><button>',
            "1" => $reg->nombre,
            "2" => $reg->tipo_documento,
            "3" => $reg->num_documento,
            "4" => $reg->telefono,
            "5" => $reg->email,
            "6" => $reg->login,
            "7" => '<img src="../files/usuarios/'.$reg->imagen.'" height="50px" width="50px">',
            "8" => ($reg->condicion)?'<span class="label bg-green">Activado</span>':
                                    '<span class="label bg-red">Desactivado</span>',
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

   case "permisos":
      // Obtenemos todos los permisos
      require_once "../models/Permiso.php";
      $permiso = new Permiso();
      $respuesta = $permiso->listar();

      //Obtener los permisos asignados al usuario
      $id = $_GET['id'];
      $marcados = $usuario->listarMarcados($id);

      //Array para almacenar los permisos marcados
      $valores = array();

      //Almacenar los permisos asignados al usuario en el array
      while($per = $marcados->fetch_object())
      {
         array_push($valores, $per->idpermiso);
      }

      //Mostrar la lista de permisos en la vista
      while($reg = $respuesta->fetch_object())
      {
         $sw = in_array($reg->idpermiso, $valores)?'checked':'';
         echo '<li>
                  <input class="form-check-input" type="checkbox" name="permiso[]" value="'.$reg->idpermiso.'" id="'.$reg->idpermiso.'" '.$sw.'>
                  <label for="'.$reg->idpermiso.'" class="form-check-label">'.$reg->nombre.'</label>
               </li>';
      }
   break;

   case 'verificar':

      $logina = $_POST['logina'];
      $clavea = $_POST['clavea'];

      //Hash SHA256 en la clave de envio
      $clavehash = hash('SHA256', $clavea);

      $respuesta = $usuario->verificar($logina,$clavehash);

      $fetch = $respuesta->fetch_object();

      if(isset($fetch))
      {
         //Declaramos las variables de sesion
         $_SESSION['idusuario'] = $fetch->idusuario;
         $_SESSION['nombre'] = $fetch->nombre;
         $_SESSION['imagen'] = $fetch->imagen;
         $_SESSION['login'] = $fetch->login;

         //Obtenemos los permmisos del usuario
         $marcados = $usuario->listarMarcados($fetch->idusuario);

         //Declaramos un array para almacenar todos los permisos marcados
         $valores = array();

         //almacenamos todos los permisos marcados en el array
         while($per = $marcados->fetch_object())
         {
            array_push($valores, $per->idpermiso);
         }

         //Determinamos los accesos del ususario
         in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
         in_array(2,$valores)?$_SESSION['almacen']=1:$_SESSION['almacen']=0;
         in_array(3,$valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
         in_array(4,$valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
         in_array(5,$valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
         in_array(6,$valores)?$_SESSION['consultac']=1:$_SESSION['consultac']=0;
         in_array(7,$valores)?$_SESSION['consultav']=1:$_SESSION['consultav']=0;


      }
      echo json_encode($fetch);

   break;

   case 'salir':
     //Limpiamos las variables de sesion
     session_unset();
     
     //Destruimos la sesión
     session_destroy();

     //Redireccionamos al login
     header('Location: ../index.php');
   break;

}

?>