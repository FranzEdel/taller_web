CREATE TRIGGER tr_updStockVenta
AFTER INSERT 
ON detalle_venta FOR EACH ROW 
BEGIN
    UPDATE articulos SET stock = stock - NEW.cantidad
    WHERE articulos.idarticulo = NEW.idarticulo;
END
