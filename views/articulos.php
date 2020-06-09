<?php 
//Activar almacenamiento en buffer
ob_start();
session_start();

if(!isset($_SESSION['nombre']))
{
    header("Location: login.php");
} else {

require "pages/header.php";

if($_SESSION['almacen'] == 1)
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
                    <h1 class="m-0 text-dark">Articulos</h1>
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
                                 <th>Nombre</th>
                                 <th>Categoría</th>
                                 <th>Código</th>
                                 <th>Stock</th>
                                 <th>Imagen</th>
                                 <th>Estado</th>
                              </thead>
                              <tbody>
                              </tbody>
                              <tfoot>
                                 <th>Opciones</th>
                                 <th>Nombre</th>
                                 <th>Categoría</th>
                                 <th>Código</th>
                                 <th>Stock</th>
                                 <th>Imagen</th>
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
                                 <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="nombre">Nombre:</label>
                                    <input type="hidden" name="idarticulo" id="idarticulo">
                                    <input type="text" class="form-control" name="nombre" id="nombre" maxLength="50" placeholder="nombre" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="nombre">Categoria:</label>
                                    <select name="idcategoria" id="idcategoria" class="form-control selectpicker" data-live-search="true" title="--Seleccione una Categoria--" required></select>
                                </div>
                              </div>
                              <div class="row">
                                 <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="stock">Stock:</label>
                                    <input type="number" class="form-control" name="stock" id="stock" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="descripcion">Descripcion:</label>
                                    <input type="text" class="form-control" name="descripcion" id="descripcion" maxLength="50" placeholder="descripcion" required>
                                </div>
                              </div>
                              <div class="row">
                                 <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="imagen">Imagen:</label>
                                    <input type="file" class="form-control" name="imagen" id="imagen">

                                    <input type="hidden" name="imagenactual" id="imagenactual">
                                    <img src="" width="150px" height="120px" id="imagenmuestra">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="codigo">Código:</label>
                                    <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Código Barras">
                                    <button class="btn btn-sm btn-success" type="button" onclick="generarbarcode()">Generar</button>
                                    <button class="btn btn-sm btn-info" type="button" onclick="imprimir()">Imprimir</button>
                                    <div id="print">
                                        <svg id="barcode"></svg>   
                                    </div>
                                </div>
                              </div>
                                
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <button class="btn btn-primary" type="submit" id="btnGuardar"> <i class="fa fa-save"></i> Guardar</button>
                                    <button class="btn btn-danger" type="button" onclick="cancelarForm()"> <i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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


<?php
} else {
    require 'noacceso.php';
}

require "pages/footer.php";
?>

<script src="../public/js/JsBarcode.all.min.js"></script>
<script src="../public/js/jquery.PrintArea.js"></script>
<script src="scripts/articulos.js"></script>

<?php 
}
ob_end_flush();
?>