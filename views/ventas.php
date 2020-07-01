<?php
//Activar almacenamiento en buffer
ob_start();
session_start();

if(!isset($_SESSION['nombre']))
{
    header("Location: login.php");
} else {

require "pages/header.php";

if($_SESSION['ventas'] == 1)
{

?>
<!-- Main Sidebar Container -->
<?php 
require "pages/sidebar.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Ventas</h1>
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    

                    <div class="card card-primary card-outline table-responsive" id="listado">
                        <div class="card-header">
                            <button class="btn btn-success" onclick="mostrarForm(true)">
                                <i class="fa fa-plus-circle"></i> Agregar
                            </button>
                        </div>
                        <div class="card-body">
                           <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                    <th>Opciones</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Usuario</th>
                                    <th>Documento</th>
                                    <th>Número</th>
                                    <th>Total Venta</th>
                                    <th>Estado</th>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <th>Opciones</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Usuario</th>
                                    <th>Documento</th>
                                    <th>Número</th>
                                    <th>Total Venta</th>
                                    <th>Estado</th>
                                </tfoot>
                           </table>
                        </div>
                    </div>
                    <!-- /.card -->
                    <div class="card card-primary card-outline table-responsive" id="formularioregistros">
                        <div class="card-body">
                            <form name="formulario" id="formulario" method="POST">
                                <div class="row">
                                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <label for="idcliente">Cliente(*):</label>
                                        <input type="hidden" name="idventa" id="idventa">
                                        <select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true" title="--Seleccione un Cliente--" required></select>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label for="fecha_hora">Fecha(*):</label>
                                        <input type="date" name="fecha_hora" id="fecha_hora" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label for="tipo_comprobante">Tipo Comprobante(*):</label>
                                        <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required>
                                            <option value="Boleta">Boleta</option>
                                            <option value="Factura">Factura</option>
                                            <option value="Ticket">Ticket</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label for="serie_comprobante">Serie:</label>
                                        <input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" maxLength="7" placeholder="Serie">
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label for="num_comprobante">Número:</label>
                                        <input type="text" class="form-control" name="num_comprobante" id="num_comprobante" maxLength="10" placeholder="Número" required>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label for="impuesto">Impuesto:</label>
                                        <input type="text" class="form-control" name="impuesto" id="impuesto" maxLength="10" placeholder="Impuesto" required>
                                    </div>  
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button id="btnAgregarArt" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                            <span class="fa fa-plus"></span> Agregar Articulo
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover table-sm">
                                            <thead style="background-color:#A9D0F5">
                                                <th>Opciones</th>
                                                <th>Artículo</th>
                                                <th>Cantidad</th>
                                                <th>Precio Venta</th>
                                                <th>Descuento</th>
                                                <th>Subtotal</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <th colspan="5"><h4>TOTAL</h4></th>

                                                <th colspan="2"><h4 id="total">Bs/. 0.00</h4><input type="hidden" name="total_venta" id=total_venta></th>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <button class="btn btn-primary" type="submit" id="btnGuardar"> <i class="fa fa-save"></i> Guardar</button>
                                    <button id="btnCancelar" class="btn btn-danger" type="button" onclick="cancelarForm()"> <i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Seleccione un Artículo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>  
            </div>
            <div class="modal-body">
                <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover" style="width:100% !important;">
                    <thead>
                        <th>Opciones</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Código</th>
                        <th>Stock</th>
                        <th>Precio Venta</th>
                        <th>Imagen</th>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <th>Opciones</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Código</th>
                        <th>Stock</th>
                        <th>Precio Venta</th>
                        <th>Imagen</th>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal -->

<?php 
} else {
    require 'noacceso.php';
}

require "pages/footer.php";
?>

<script src="scripts/ventas.js"></script>

<?php 
}
ob_end_flush();
?>