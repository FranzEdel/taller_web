<?php 
require "../config/Conexion.php";

class Persona
{
   // Constructor
   public function __construct()
   {

   }

   // Metodo para instertar
   public function insertar($tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email)
   {
      $sql = "INSERT INTO personas(tipo_persona, nombre, tipo_documento, num_documento, direccion, telefono, email) 
      VALUES ('$tipo_persona', '$nombre', '$tipo_documento', '$num_documento', '$direccion', '$telefono', '$email')";

      return ejecutarConsulta($sql);
   }

   // Metodo para editar
   public function editar($idpersona, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email)
   {
      $sql = "UPDATE personas SET tipo_persona = '$tipo_persona', nombre = '$nombre', tipo_documento = '$tipo_documento', num_documento = '$num_documento', direccion = '$direccion', telefono = '$telefono', email = '$email'
      WHERE idpersona = '$idpersona'";

      return ejecutarConsulta($sql);
   }

   // Metodo para eliminar personas
   public function eliminar($idpersona)
   {
      $sql = "DELETE personas WHERE idpersona = '$idpersona'";

      return ejecutarConsulta($sql);
   }

   // Metodo para mostrar los datos de un registro a modificar
   public function mostrar($idpersona)
   {
      $sql = "SELECT * FROM personas WHERE idpersona = '$idpersona'";

      return ejecutarConsultaSimpleFila($sql);
   }

   // Metodo para listar proveedores
   public function listarp()
   {
      $sql = "SELECT * FROM personas WHERE tipo_persona = 'Proveedor'";

      return ejecutarConsulta($sql);
   }

   // Metodo para listar clientes
   public function listarc()
   {
      $sql = "SELECT * FROM personas WHERE tipo_persona = 'Cliente'";

      return ejecutarConsulta($sql);
   }

}

?>