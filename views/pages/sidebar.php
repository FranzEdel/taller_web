<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="../public/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Taller WEB</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../files/usuarios/<?= $_SESSION['imagen'];?>" class="user-image" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $_SESSION['nombre']; ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php 
                    if($_SESSION['escritorio'] == 1)
                    {
                        echo '
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Escritorio</p>
                            </a>
                        </li>';
                    }
                ?>

                <?php 
                    if($_SESSION['almacen'] == 1)
                    {
                        echo '
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-laptop"></i>
                                <p>Almacén <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="articulos.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Artículos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="categorias.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Categorías</p>
                                    </a>
                                </li>
                            </ul>
                        </li>';
                    }
                ?>
                
                <?php 
                    if($_SESSION['compras'] == 1)
                    {
                        echo '
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>Compras <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="ingresos.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ingresos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="proveedores.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Proveedores</p>
                                    </a>
                                </li>
                            </ul>
                        </li>';
                    }
                ?>

                <?php 
                    if($_SESSION['ventas'] == 1)
                    {
                        echo '
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-shopping-cart"></i>
                                <p>Ventas <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="ventas.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ventas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="clientes.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Clientes</p>
                                    </a>
                                </li>
                            </ul>
                        </li>';
                    }
                ?>

                <?php 
                    if($_SESSION['acceso'] == 1)
                    {
                        echo '
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-folder"></i>
                                <p>Acceso <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="usuarios.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Usuarios</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="permisos.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Permisos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>';
                    }
                ?>

                <?php 
                    if($_SESSION['consultac'] == 1)
                    {
                        echo '
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-ico fas fa-chart-pie"></i>
                                <p>Consulta Compras <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="consultacompras.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Consulta Compras</p>
                                    </a>
                                </li>
                            </ul>
                        </li>';
                    }
                ?>

                <?php 
                    if($_SESSION['consultav'] == 1)
                    {
                        echo '
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Consulta Ventas <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="consultaventas.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Consulta Ventas</p>
                                    </a>
                                </li>
                            </ul>
                        </li>';
                    }
                ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>