<?php 
require "../config/Conexion.php";

class Usuario
{
   // Constructor
   public function __construct()
   {

   }

   // Metodo para instertar
   public function insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $imagen, $permisos)
   {
      $sql = "INSERT INTO usuarios(nombre, tipo_documento, num_documento, direccion, telefono, email, cargo, login, clave, imagen) 
      VALUES ('$nombre', '$tipo_documento', '$num_documento', '$direccion', '$telefono', '$email', '$cargo', '$login', '$clave', '$imagen')";

      //return ejecutarConsulta($sql);
      $idusuario_new = ejecutarConsulta_retornarID($sql);

      $num_elementos = 0;
      $sw = true;

      while($num_elementos < count($permisos))
      {
         $sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) 
                        VALUES('$idusuario_new', '$permisos[$num_elementos]')";
         ejecutarConsulta($sql_detalle) or $sw = false;
         $num_elementos++;
      }

      return $sw;
   }

   // Metodo para editar
   public function editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $imagen, $permisos)
   {
      $sql = "UPDATE usuarios SET nombre = '$nombre', tipo_documento = '$tipo_documento', num_documento = '$num_documento', direccion = '$direccion', telefono = '$telefono', email = '$email', cargo = '$cargo', login = '$login', clave = '$clave', imagen = '$imagen'
      WHERE idusuario = '$idusuario'";

      ejecutarConsulta($sql);

      //Eliminamos todos los permisos asignados del usuario para volver a registrarlo
      $sqldel = "DELETE FROM usuario_permiso WHERE idusuario = '$idusuario'";
      ejecutarConsulta($sqldel);

      $num_elementos = 0;
      $sw = true;

      while($num_elementos < count($permisos))
      {
         $sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) 
                        VALUES('$idusuario', '$permisos[$num_elementos]')";
         ejecutarConsulta($sql_detalle) or $sw = false;
         $num_elementos++;
      }

      return $sw;
   }

   // Metodo para desactivar usuarios
   public function desactivar($idusuario)
   {
      $sql = "UPDATE usuarios SET condicion = '0'
      WHERE idusuario = '$idusuario'";

      return ejecutarConsulta($sql);
   }

   // Metodo para sactivar usuarios
   public function activar($idusuario)
   {
      $sql = "UPDATE usuarios SET condicion = '1'
      WHERE idusuario = '$idusuario'";

      return ejecutarConsulta($sql);
   }

   // Metodo para mostrar los datos de un registro a modificar
   public function mostrar($idusuario)
   {
      $sql = "SELECT * FROM usuarios WHERE idusuario = '$idusuario'";

      return ejecutarConsultaSimpleFila($sql);
   }

   // Metodo para listar
   public function listar()
   {
      $sql = "SELECT * FROM usuarios";

      return ejecutarConsulta($sql);
   }

   //Metodo para listar los permisos marcados
   public function listarMarcados($idusuario)
   {
      $sql = "SELECT * FROM usuario_permiso WHERE idusuario = '$idusuario'";

      return ejecutarConsulta($sql);
   }

   //Funcion para verificar el acceso al sistema
   public function verificar($login,$clave)
   {
      $sql = "SELECT idusuario,nombre,tipo_documento,num_documento,telefono,email,cargo,imagen,login FROM usuarios WHERE login = '$login' AND clave = '$clave' AND condicion = '1'";
      return ejecutarConsulta($sql);
   }

}

?>