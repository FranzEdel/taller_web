<?php
//Activar almacenamiento en buffer
ob_start();
session_start();

if(!isset($_SESSION['nombre']))
{
    header("Location: login.php");
} else {

require "pages/header.php";

if($_SESSION['escritorio'] == 1)
{

  require_once "../models/Consultas.php";
  $consulta = new Consultas();

  $respuestac = $consulta->totalCompraHoy();
  $regc = $respuestac->fetch_object();
  $totalc = $regc->total_compra;



  //Datos para mostras en el gráfico de barras de las compras
  $compras10 = $consulta->comprasUltimos10dias();
  $fechasc = '';
  $totalesc = '';
  while($regfechasc = $compras10->fetch_object())
  {
    $fechasc = $fechasc.'"'.$regfechasc->fecha.'",';   
    $totalesc = $totalesc.$regfechasc->total.',';
  }
  // Quitamos la ultima coma
  $fechasc = substr($fechasc, 0, -1);
  $totalesc = substr($totalesc, 0, -1);


  //Datos para mostras en el gráfico de barras de las ventas
  $ventas12 = $consulta->ventasUltimos12meses();
  $meses = array(
    1 => 'Ene',
    2 => 'Feb',
    3 => 'Mar',
    4 => 'Abr',
    5 => 'May',
    6 => 'Jun',
    7 => 'Jul',
    8 => 'Ago',
    9 => 'Sep',
    10 => 'Oct',
    11 => 'Nov',
    12 => 'Dic'
  );
  $fechasv = '';
  $totalesv = '';
  while($regfechasv = $ventas12->fetch_object())
  {
    $fechasv = $fechasv.'"'.$meses[$regfechasv->mes].'-'.$regfechasv->anio.'",';   
    $totalesv = $totalesv.$regfechasv->total.',';
  }
  // Quitamos la ultima coma
  $fechasv = substr($fechasv, 0, -1);
  $totalesv = substr($totalesv, 0, -1);

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
                    <h1 class="m-0 text-dark">Escritorio</h1>
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
                          
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                              <div class="inner">
                                <h3><?= $totalc; ?></h3>

                                <p>Compras</p>
                              </div>
                              <div class="icon">
                                <i class="ion ion-bag"></i>
                              </div>
                              <a href="ingresos.php" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                          </div>
                          <!-- ./col -->
                          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                              <div class="inner">
                                <h3>0.00</h3>

                                <p>Ventas</p>
                              </div>
                              <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                              </div>
                              <a href="ventas.php" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="card-body">
                        <div class="row">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="card card-success">
                              <div class="card-header">
                                <h3 class="card-title">Compras de los ultimos 10 dias</h3>
                              </div>
                              <div class="card-body">
                                <canvas id="compras" width="400" height="300"></canvas>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="card card-success">
                              <div class="card-header">
                                <h3 class="card-title">Ventas de los ultimos 12 meses</h3>
                              </div>
                              <div class="card-body">
                                <canvas id="ventas" width="400" height="300"></canvas>
                              </div>
                            </div>
                          </div>
                        </div>
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

<script src="../public/js/Chart.min.js"></script>
<script>
var ctx = document.getElementById('compras').getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasc; ?>],
        datasets: [{
            label: '# Compras realizadas en los ultimos 10 días',
            data: [<?php echo $totalesc; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

var ctx = document.getElementById('ventas').getContext('2d');
var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasv; ?>],
        datasets: [{
            label: '# Ventas realizadas en los ultimos 12 meses',
            data: [<?php echo $totalesv; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

<?php 
}
ob_end_flush();
?>

