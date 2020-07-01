<?php 
require "../config/Conexion.php";

class Venta
{
   // Constructor
   public function __construct()
   {

   }

   // Metodo para instertar
   public function insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$idarticulo,$cantidad,$precio_venta,$descuento)
	{
		$sql = "INSERT INTO ventas(idcliente,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_venta,estado)
		VALUES ('$idcliente','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_venta','Aceptado')";
		//return ejecutarConsulta($sql);
		$idventanew = ejecutarConsulta_retornarID($sql);

		$num_elementos = 0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle = "INSERT INTO detalle_venta(idventa, idarticulo,cantidad,precio_venta,descuento) VALUES ('$idventanew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

   // Metodo para desactivar usuarios
   public function anular($idventa)
   {
      $sql = "UPDATE ventas SET estado = 'Anulado'
      WHERE idventa = '$idventa'";

      return ejecutarConsulta($sql);
   }


   // Metodo para mostrar los datos de un registro a modificar
   public function mostrar($idventa)
   {
      $sql = "SELECT v.idventa,DATE(v.fecha_hora) AS fecha,v.idcliente,p.nombre AS cliente,u.idusuario,u.nombre AS usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM ventas v JOIN personas p ON v.idcliente = p.idpersona JOIN usuarios u ON v.idusuario = u.idusuario WHERE v.idventa = '$idventa'";

      return ejecutarConsultaSimpleFila($sql);
   }

   public function listarDetalle($idventa)
   {
      $sql = "SELECT dv.idventa, dv.idarticulo,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) AS subtotal FROM detalle_venta dv JOIN articulos a ON dv.idarticulo = a.idarticulo WHERE dv.idventa = '$idventa'";
      return ejecutarConsulta($sql);
   }

   // Metodo para listar
   public function listar()
   {
      $sql = "SELECT v.idventa,DATE(v.fecha_hora) AS fecha,v.idcliente,p.nombre AS cliente,u.idusuario,u.nombre AS usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM ventas v JOIN personas p ON v.idcliente = p.idpersona JOIN usuarios u ON v.idusuario = u.idusuario
      ORDER BY v.idventa DESC";

      return ejecutarConsulta($sql);
   }

   public function ventaCabecera($idventa)
   {
      $sql = "SELECT v.idventa,
                     v.idcliente,
                     DATE(v.fecha_hora) AS fecha,
                     p.nombre AS cliente,
                     p.direccion,
                     p.tipo_documento,
                     p.num_documento,
                     p.email,
                     p.telefono,
                     v.idusuario,
                     u.nombre AS usuario,
                     v.tipo_comprobante,
                     v.serie_comprobante,
                     v.num_comprobante,
                     DATE(v.fecha_hora) AS fecha,
                     v.impuesto,
                     v.total_venta
               FROM ventas v JOIN personas p ON v.idcliente = p.idpersona 
                              JOIN usuarios u ON v.idusuario = u.idusuario
               WHERE v.idventa = '$idventa'";

      return ejecutarConsulta($sql);
   }

   public function ventaDetalle($idventa)
   {
      $sql = "SELECT a.nombre AS articulo,
                     a.codigo,
                     dv.cantidad,
                     dv.precio_venta,
                     dv.descuento,
                     (dv.cantidad * dv.precio_venta - dv.descuento) AS subtotal
               FROM detalle_venta dv JOIN articulos a ON dv.idarticulo = a.idarticulo 	  
               WHERE dv.idventa = '$idventa'";

      return ejecutarConsulta($sql);
   }

}

?>