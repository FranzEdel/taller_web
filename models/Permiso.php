<?php 
require "../config/Conexion.php";

class Permiso
{
   // Constructor
   public function __construct()
   {

   }

   // Metodo para listar
   public function listar()
   {
      $sql = "SELECT * FROM permisos";

      return ejecutarConsulta($sql);
   }
}


?>