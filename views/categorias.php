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
                    

                    <div class="card card-primary card-outline table-responsive" id="listado">
                        <div class="card-header">
                            <button class="btn btn-success" onclick="mostrarForm(true)">
                                <i class="fa fa-plus-circle"></i> Agregar
                            </button>
                        </div>
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
                    <div class="card card-primary card-outline table-responsive" id="formularioregistros">
                        <div class="card-body">
                            <form name="formulario" id="formulario" method="POST">
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="nombre">Nombre:</label>
                                    <input type="hidden" name="idcategoria" id="idcategoria">
                                    <input type="text" class="form-control" name="nombre" id="nombre" maxLength="50" placeholder="nombre" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="descripcion">Descripcion:</label>
                                    <input type="text" class="form-control" name="descripcion" id="descripcion" maxLength="50" placeholder="descripcion" required>
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
require "pages/footer.php";
?>

<script src="scripts/categorias.js"></script>