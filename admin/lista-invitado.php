<?php
//SESION
include_once 'funciones/sesiones.php';
//FUNCIONES
include_once 'funciones/funciones.php';
//HEADER
include_once 'templates/header.php';
//BARRA
include_once 'templates/barra.php';
//NAVEGACION LATERAL
include_once 'templates/navegacion.php';
?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Listado de invitados
            <small>administra aquí a los ponentes</small>
        </h1>
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Invitados</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="registros" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--AQUÍ RESULTADO DE CONSULTA DINÁMICA-->
                                <?php
                                try {
                                    $sql = "SELECT * FROM invitados";
                                    $resultado = $conn->query($sql);
                                } catch (Exception $e) {
                                    $error = $e->getMessage();
                                    echo $error;
                                }

                                while ($invitado = $resultado->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $invitado['nombre_invitado'] . " " . $invitado['apellido_invitado']; ?></td>

                                        <td><?php echo $invitado['descripcion_invitado']; ?></td>
                                        <td><img src="../img/invitados/<?php echo $invitado['url_imagen']; ?>" alt="" width="150px"></td>
                                        <td>
                                            <a href="editar-invitado.php?id=<?php echo $invitado['invitado_id']; ?>" class="btn bg-orange btn-flat margin">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#" data-id="<?php echo $invitado['invitado_id']; ?>" data-tipo="invitado" class="btn bg-maroon btn-flat margin borrar_registro">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                <?php } ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php //FOOTER
include_once 'templates/footer.php';
?>