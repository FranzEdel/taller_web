<?php 
require_once "../config/Conexion.php";

class Categoria
{
   // Metodo para insertar
   public function insertar($nombre, $descripcion)
   {
      $sql = "INSERT INTO categorias(nombre,descripcion,condicion) VALUES('$nombre','$descripcion','1')";

      return ejecutarConsulta($sql);
   }

   // Metodo para editar
   public function editar($idcategoria,$nombre, $descripcion)
   {
      $sql = "UPDATE categorias SET nombre = '$nombre' , descripcion = '$descripcion' WHERE idcategoria = '$idcategoria' ";

      return ejecutarConsulta($sql);
   }

   // Metodo para desactivar
   public function desactivar($idcategoria)
   {
      $sql = "UPDATE categorias SET condicion = '0'
         WHERE idcategoria = '$idcategoria' ";

      return ejecutarConsulta($sql);
   }

   // Metodo para activar
   public function activar($idcategoria)
   {
      $sql = "UPDATE categorias SET condicion = '1'
         WHERE idcategoria = '$idcategoria' ";

      return ejecutarConsulta($sql);
   }

   // Metodo para mostrar datos de un registro a editar
   public function mostrar($idcategoria)
   {
      $sql = "SELECT * FROM categorias WHERE idcategoria = '$idcategoria' ";

      return ejecutarConsultaSimpleFila($sql);
   }

   // Metodo para listar
   public function listar()
   {
      $sql = "SELECT * FROM categorias ORDER BY idcategoria DESC";

      return ejecutarConsulta($sql);
   }

   // Metodo para listar y mostrar en un select
   public function select()
   {
      $sql = "SELECT * FROM categorias WHERE condicion = '1' ";

      return ejecutarConsulta($sql);
   }
}



?>