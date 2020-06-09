CREATE TRIGGER tr_updStockIngreso
AFTER INSERT 
ON detalle_ingreso FOR EACH ROW 
BEGIN
    UPDATE articulos SET stock = stock + NEW.cantidad
    WHERE articulos.idarticulo = NEW.idarticulo;
END
