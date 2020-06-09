<?php 
require "../config/Conexion.php";

class Venta
{
   // Constructor
   public function __construct()
   {

   }

   // Metodo para instertar
   public function insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$idarticulo,$cantidad,$precio_compra,$precio_venta)
	{
		$sql = "INSERT INTO ventas (idcliente,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_venta,estado)
		VALUES ('$idcliente','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_venta','Aceptado')";
		//return ejecutarConsulta($sql);
		$idventanew = ejecutarConsulta_retornarID($sql);

		$num_elementos = 0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle = "INSERT INTO detalle_venta(idventa, idarticulo,cantidad,precio_compra,precio_venta) VALUES ('$idventanew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]','$precio_venta[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

   // Metodo para desactivar usuarios
   public function anular($idventa)
   {
      $sql = "UPDATE ingresos SET estado = 'Anulado'
      WHERE idventa = '$idventa'";

      return ejecutarConsulta($sql);
   }


   // Metodo para mostrar los datos de un registro a modificar
   public function mostrar($idventa)
   {
      $sql = "SELECT i.idventa,DATE(i.fecha_hora) AS fecha,i.idcliente,p.nombre AS proveedor,u.idusuario,u.nombre AS usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_venta,i.impuesto,i.estado FROM ingresos i JOIN personas p ON i.idcliente = p.idpersona JOIN usuarios u ON i.idusuario = u.idusuario WHERE i.idventa = '$idventa'";

      return ejecutarConsultaSimpleFila($sql);
   }

   public function listarDetalle($idventa)
   {
      $sql = "SELECT dv.idventa, dv.idarticulo,a.nombre,dv.cantidad,dv.precio_compra,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) AS subtotal FROM detalle_venta dv JOIN articulos a ON dv.idarticulo = a.idarticulo WHERE dv.idventa = '$idventa'";
      return ejecutarConsulta($sql);
   }

   // Metodo para listar
   public function listar()
   {
      $sql = "SELECT i.idventa,DATE(i.fecha_hora) AS fecha,i.idcliente,p.nombre AS proveedor,u.idusuario,u.nombre AS usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_venta,i.impuesto,i.estado FROM ingresos i JOIN personas p ON i.idcliente = p.idpersona JOIN usuarios u ON i.idusuario = u.idusuario
      ORDER BY i.idventa DESC";

      return ejecutarConsulta($sql);
   }

}

?>