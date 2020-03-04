<?php 
require "pages/header.php";
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
                    <h1 class="m-0 text-dark">Categorias</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Categorias</li>
                    </ol>
                </div>
                <!-- /.col -->
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
                    

                    <div class="card card-primary card-outline table-responsive">
                        <div class="card-body">
                           <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                              <thead>
                                 <th>ID</th>
                                 <th>Nombre</th>
                                 <th>Descripcion</th>
                                 <th>Estado</th>
                              </thead>
                              <tbody>
                              </tbody>
                              <tfoot>
                                 <th>ID</th>
                                 <th>Nombre</th>
                                 <th>Descripcion</th>
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
require "pages/footer.php";
?>

<script src="scripts/categorias.js"></script>