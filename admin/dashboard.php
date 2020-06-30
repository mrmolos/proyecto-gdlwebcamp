<?php
//SESION
include_once 'funciones/funciones.php';
//FUNCIONES
include_once 'funciones/sesiones.php';

//HEADER
include_once 'templates/header.php';

//BARRA
include_once 'templates/barra.php';

include_once 'templates/navegacion.php';
?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Información del evento</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box-body chart-responsive">
              <div class="chart" id="grafica-registro" style="height: 300px;"></div>
            </div>


    <h2 class="page-header">Resumen registros</h2>
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <?php
                $sql = "SELECT COUNT(ID_registrado) AS registros FROM registrados";
                $resultado = $conn->query($sql);
                $registrados = $resultado->fetch_assoc();
                ?>



                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo $registrados['registros']; ?></h3>

                        <p>Registrados</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <a href="lista-registrado.php" class="small-box-footer">
                        Más info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <?php
                $sql = "SELECT COUNT(ID_registrado) AS registros FROM registrados WHERE pagado = 1";
                $resultado = $conn->query($sql);
                $registrados = $resultado->fetch_assoc();
                ?>
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $registrados['registros']; ?></h3>

                        <p>Registros pagados</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <a href="lista-registrado.php" class="small-box-footer">
                        Más info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <?php
                $sql = "SELECT COUNT(ID_registrado) AS registros FROM registrados WHERE pagado = 0";
                $resultado = $conn->query($sql);
                $registrados = $resultado->fetch_assoc();
                ?>
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo $registrados['registros']; ?></h3>

                        <p>Registros sin pagar</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <a href="lista-registrado.php" class="small-box-footer">
                        Más info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <?php
                $sql = "SELECT SUM(total_pagado) AS ganancias FROM registrados WHERE pagado = 1";
                $resultado = $conn->query($sql);
                $registrados = $resultado->fetch_assoc();
                ?>
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>$<?php echo (float) $registrados['ganancias']; ?></h3>

                        <p>Ganancias totales</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-arrow-circle-up"></i>
                    </div>
                    <a href="lista-registrado.php" class="small-box-footer">
                        Más info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

        </div>
        <!--/.row-->

        <h2 class="page-header">Regalos</h2>
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <?php
                $sql = "SELECT COUNT(regalo) AS pulseras FROM registrados WHERE pagado = 1 AND regalo = 1 ";
                $resultado = $conn->query($sql);
                $regalo = $resultado->fetch_assoc();
                ?>
                <!-- small box -->
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3><?php echo (float) $regalo['pulseras']; ?></h3>

                        <p>Pulseras</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-gift"></i>
                    </div>
                    <a href="lista-registrado.php" class="small-box-footer">
                        Más info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <?php
                $sql = "SELECT COUNT(regalo) AS etiquetas FROM registrados WHERE pagado = 1 AND regalo = 2 ";
                $resultado = $conn->query($sql);
                $regalo = $resultado->fetch_assoc();
                ?>
                <!-- small box -->
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3><?php echo (float) $regalo['etiquetas']; ?></h3>

                        <p>Etiquetas</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-gift"></i>
                    </div>
                    <a href="lista-registrado.php" class="small-box-footer">
                        Más info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <?php
                $sql = "SELECT COUNT(regalo) AS plumas FROM registrados WHERE pagado = 1 AND regalo = 3";
                $resultado = $conn->query($sql);
                $regalo = $resultado->fetch_assoc();
                ?>
                <!-- small box -->
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3><?php echo (float) $regalo['plumas']; ?></h3>

                        <p>Plumas</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-gift"></i>
                    </div>
                    <a href="lista-registrado.php" class="small-box-footer">
                        Más info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

        </div>
        <!--/.row-->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php //FOOTER
include_once 'templates/footer.php';
?>