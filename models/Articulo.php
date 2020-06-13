<?php 
require_once "../config/Conexion.php";

class Articulo
{
   // Metodo para insertar
   public function insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen)
   {
      $sql = "INSERT INTO articulos(idcategoria,codigo,nombre,stock,descripcion,imagen,condicion) VALUES('$idcategoria','$codigo', '$nombre', '$stock', '$descripcion', '$imagen','1')";

      return ejecutarConsulta($sql);
   }

   // Metodo para editar
   public function editar($idarticulo,$idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen)
   {
      $sql = "UPDATE articulos SET idcategoria = '$idcategoria' , codigo = '$codigo',nombre = '$nombre', stock = '$stock', descripcion = '$descripcion', imagen = '$imagen'
      WHERE idarticulo = '$idarticulo' ";

      return ejecutarConsulta($sql);
   }

   // Metodo para desactivar
   public function desactivar($idarticulo)
   {
      $sql = "UPDATE articulos SET condicion = '0'
         WHERE idarticulo = '$idarticulo' ";

      return ejecutarConsulta($sql);
   }

   // Metodo para activar
   public function activar($idarticulo)
   {
      $sql = "UPDATE articulos SET condicion = '1'
         WHERE idarticulo = '$idarticulo' ";

      return ejecutarConsulta($sql);
   }

   // Metodo para mostrar datos de un registro a editar
   public function mostrar($idarticulo)
   {
      $sql = "SELECT * FROM articulos WHERE idarticulo = '$idarticulo' ";

      return ejecutarConsultaSimpleFila($sql);
   }


   // Metodo para listar
   public function listar()
   {
      $sql = "SELECT a.idarticulo, a.idcategoria, c.nombre as categoria, a.codigo, a.nombre , a.stock, a.descripcion, a.imagen, a.condicion
      FROM articulos a INNER JOIN categorias c 
      ON a.idcategoria = c.idcategoria ";

      return ejecutarConsulta($sql);
   }

   // Metodo para listar los registros activos
   public function listarActivos()
   {
      $sql = "SELECT a.idarticulo, a.idcategoria, c.nombre as categoria, a.codigo, a.nombre , a.stock, a.descripcion, a.imagen, a.condicion
      FROM articulos a INNER JOIN categorias c 
      ON a.idcategoria = c.idcategoria WHERE a.condicion = '1'";

      return ejecutarConsulta($sql);
   }

   //Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_ingreso)
	public function listarActivosVenta()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo ORDER BY iddetalle_ingreso DESC LIMIT 0,1) as precio_venta,a.descripcion,a.imagen,a.condicion FROM articulos a INNER JOIN categorias c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
      return ejecutarConsulta($sql);
   }
}



?>