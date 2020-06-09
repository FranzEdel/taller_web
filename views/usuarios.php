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
                    <h1 class="m-0 text-dark">Administración de Usuarios</h1>
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
                              <th>Login</th>
                              <th>Foto</th>
                              <th>Estado</th>
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
                              <th>Login</th>
                              <th>Foto</th>
                              <th>Estado</th>
                           </tfoot>
                        </table>
                     </div>
                  </div>

                  <div class="card card-primary card-outline" id="formularioregistros">
                     <div class="card-body">
                        <form name="formulario" id="formulario" method="POST">
                           <div class="row">
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label for="nombre">Nombre(*):</label>
                                 <input type="hidden" name="idusuario" id="idusuario">
                                 <input type="text" class="form-control" name="nombre" id="nombre" maxLength="100" placeholder="Nombre" required>
                              </div>

                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label for="tipo_documento">Tipo Documento(*):</label>
                                 <select class="form-control selectpicker" name="tipo_documento" id="tipo_documento" title="--Seleccione tipo de documento--" required>
                                    <option value="DNI">DNI</option>
                                    <option value="RUC">RUC</option>
                                    <option value="CEDULA">CEDULA</option>
                                 </select>
                              </div>
                           </div>
                           
                           <div class="row">
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label for="num_documento">Número(*):</label>
                                 <input type="text" class="form-control" name="num_documento" id="num_documento" placeholder="Número documento" required>
                              </div>

                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label for="direccion">Dirección:</label>
                                 <input type="text" class="form-control" name="direccion" id="direccion" maxLength="70" placeholder="Dirección">
                              </div>
                           </div>

                           <div class="row">
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label for="telefonno">Teléfono:</label>
                                 <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Teléfono" maxLength="20">
                              </div>

                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label for="email">Email:</label>
                                 <input type="text" class="form-control" name="email" id="email" maxLength="50" placeholder="Email">
                              </div>
                           </div>

                           <div class="row">
                              <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                 <label for="cargo">Cargo:</label>
                                 <input type="text" class="form-control" name="cargo" id="cargo" placeholder="Cargo" maxLength="20">
                              </div>

                              <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                 <label for="login">Login:(*)</label>
                                 <input type="text" class="form-control" name="login" id="login" maxLength="20" placeholder="Login" required>
                              </div>

                              <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                 <label for="clave">Clave:(*)</label>
                                 <input type="password" class="form-control" name="clave" id="clave" maxLength="64" placeholder="Password" required>
                              </div>
                           </div>

                           <div class="row">
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label for="permisos">Permisos:(*)</label>
                                 <ul id="permisos" style="list-style:none;" class="custom-control custom-checkbox">
                                 
                                 </ul>
                              </div>

                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label for="imagen">Imagen:</label>
                                 <input type="file" class="form-control" name="imagen" id="imagen">

                                 <input type="hidden" name="imagenactual" id="imagenactual">
                                 <img src="" width="150px" height="120px" id="imagenmuestra">
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
<script src="scripts/usuarios.js"></script>

<?php 
}
ob_end_flush();
?>