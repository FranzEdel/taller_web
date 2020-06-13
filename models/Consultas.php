<?php 
require_once "../config/Conexion.php";

class Consultas
{
   // Constructor
   public function __construct()
   {
      
   }

   // Metodo para listar
   public function comprasFecha($fecha_inicio,$fecha_fin)
   {
      $sql = "SELECT DATE(i.fecha_hora) AS fecha,u.nombre AS usuario,
            p.nombre AS proveedor,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,
            i.total_compra,i.impuesto,i.estado
            FROM ingresos i JOIN personas p ON i.idproveedor = p.idpersona
                            JOIN usuarios u ON i.idusuario = u.idusuario
            WHERE DATE(i.fecha_hora) >= '$fecha_inicio' AND DATE(i.fecha_hora) <= '$fecha_fin'";

      return ejecutarConsulta($sql);
   }

}



?>