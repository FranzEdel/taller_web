<?php
//Activar almacenamiento en buffer
ob_start();
session_start();

if(!isset($_SESSION['nombre']))
{
    header("Location: login.php");
} else {

require "pages/header.php";

if($_SESSION['compras'] == 1)
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
                    <h1 class="m-0 text-dark">Administración de Proveedores</h1>
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
                        <button class="btn btn-success" onclick="mostrarForm(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
                    </div>
                     <div class="card-body">
                        <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                           <thead>
                              <th>Opciones</th>
                              <th>Nombre</th>
                              <th>Documento</th>
                              <th>Número</th>
                              <th>Teléfono</th>
                              <th>Email</th>
                           </thead>
                           <tbody>
                           </tbody>
                           <tfoot>
                              <th>Opciones</th>
                              <th>Nombre</th>
                              <th>Documento</th>
                              <th>Número</th>
                              <th>Teléfono</th>
                              <th>Email</th>
                           </tfoot>
                        </table>
                     </div>
                  </div>

                  <div class="card card-primary card-outline" style="height:400px;" id="formularioregistros">
                     <div class="card-body">
                        <form name="formulario" id="formulario" method="POST">
                        <div class="row">
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label for="nombre">Nombre(*):</label>
                                 <input type="hidden" name="idpersona" id="idpersona">
                                 <input type="hidden" name="tipo_persona" id="tipo_persona" value="Proveedor">
                                 <input type="text" class="form-control" name="nombre" id="nombre" maxLength="100" placeholder="nombre" required>
                              </div>

                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label for="tipo_documento">Tipo Documento</label>
                                 <select name="tipo_documento" id="tipo_documento" class="form-control selectpicker" title="--Seleccione una Categoria--" required>
                                    <option value="DNI">DNI</option>
                                    <option value="RUC">RUC</option>
                                    <option value="CEDULA">CEDULA</option>
                                 </select>
                              </div>
                           </div>
                           
                           <div class="row">
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label for="num_documento">Número Documento:</label>
                                 <input type="text" class="form-control" name="num_documento" id="num_documento" maxLength="20" placeholder="Documento">
                              </div>

                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label for="direccion">Dirección:</label>
                                 <input type="text" class="form-control" name="direccion" id="direccion" maxLength="70" placeholder="Dirección">
                              </div>
                           </div>

                           <div class="row">
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label for="telefono">Teléfono:</label>
                                 <input type="text" class="form-control" name="telefono" id="telefono" maxLength="20" placeholder="Teléfono">
                              </div>

                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label for="email">Email:</label>
                                 <input type="text" class="form-control" name="email" id="email" maxLength="50" placeholder="Email">
                              </div>
                           </div>

                           <div class="form-group col-lg-12 col-md-12 col-sm-12 col-sx-12">
                              <button class="btn btn-primary" type="submit" id="btnGuardar">
                                 <i class="fa fa-save"></i> Guardar
                              </button>
                              <button class="btn btn-danger" type="button" onclick="cancelarForm()">
                                 <i class="fa fa-arrow-circle-left"></i> Cancelar
                              </button>
                           </div>
                        </form>
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

<script src="scripts/proveedores.js"></script>

<?php 
}
ob_end_flush();
?>