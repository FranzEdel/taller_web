<?php
//Activar almacenamiento en buffer
ob_start();
session_start();

if(!isset($_SESSION['nombre']))
{
    header("Location: login.php");
} else {

require "pages/header.php";

if($_SESSION['consultac'] == 1)
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
                    <h1 class="m-0 text-dark">Consultas de Compras por fecha</h1>
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
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="fecha_inicio"> Fecha Inicio</label>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?= date("Y-m-d"); ?>">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="fecha_fin"> Fecha Fin</label>
                                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="<?= date("Y-m-d"); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                           <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                              <thead>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Proveedor</th>
                                <th>Comprobante</th>
                                <th>Número</th>
                                <th>Total Compra</th> 
                                <th>Impuesto</th>
                                <th>Estado</th>
                              </thead>
                              <tbody>
                              </tbody>
                              <tfoot>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Proveedor</th>
                                <th>Comprobante</th>
                                <th>Número</th>
                                <th>Total Compra</th> 
                                <th>Impuesto</th>
                                <th>Estado</th>
                              </tfoot>
                           </table>
                        </div>
                    </div>
                    <!-- /.card -->
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

<script src="scripts/comprasfecha.js"></script>

<?php 
}
ob_end_flush();
?>