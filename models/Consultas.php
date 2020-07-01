<?php 
require_once "../config/Conexion.php";

class Consultas
{
   // Constructor
   public function __construct()
   {
      
   }

   // Metodo para listar las compras entre dos fechas
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



   public function totalCompraHoy()
   {
      $sql = "SELECT IFNULL(SUM(total_compra),0) AS total_compra
               FROM ingresos WHERE DATE(fecha_hora) = DATE(NOW())";
      return ejecutarConsulta($sql);
   }



   public function comprasUltimos10dias()
   {
      $sql = "SELECT CONCAT(DAY(fecha_hora),'-',ELT(MONTH(fecha_hora),'Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic')) AS fecha,
         SUM(total_compra) as total 
         FROM ingresos GROUP BY fecha_hora ORDER BY fecha_hora LIMIT 0,10";

      return ejecutarConsulta($sql);
   }

   public function ventasUltimos12meses()
   {
      $sql = "SELECT YEAR(fecha_hora) AS anio,
               MONTH(fecha_hora) AS mes,
               SUM(total_venta) AS total
         FROM ventas
         WHERE DATE(fecha_hora) BETWEEN DATE(NOW() - INTERVAL 12 MONTH) AND DATE(NOW())
         GROUP BY YEAR(fecha_hora),MONTH(fecha_hora)
         ORDER BY YEAR(fecha_hora),MONTH(fecha_hora)";

         return ejecutarConsulta($sql);

   }

}



?>