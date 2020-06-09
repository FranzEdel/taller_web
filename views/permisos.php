<?php
//Activar almacenamiento en buffer
ob_start();
session_start();

if(!isset($_SESSION['nombre']))
{
    header("Location: login.php");
} else {
    
require "pages/header.php";

if($_SESSION['acceso'] == 1)
{

require "pages/sidebar.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Administración de Permisos</h1>
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

                  <div class="card card-primary card-outline table-responsive" id="listadoregistros">
                    <div class="card-header">
                        <button class="btn btn-success" onclick="mostrarForm(true)" id="btnagregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                    </div>
                     <div class="card-body">
                        <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                           <thead>
                              <th>Nombre</th>
                           </thead>
                           <tbody>
                           </tbody>
                           <tfoot>
                              <th>Nombre</th>
                           </tfoot>
                        </table>
                     </div>
                  </div>
                  <!-- /.card -->

               </div>
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
<script src="scripts/permisos.js"></script>

<?php 
}
ob_end_flush();
?>