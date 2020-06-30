<?php
//Obtencion del id en la url
$id = $_GET['id'];
if (!filter_var($id, FILTER_VALIDATE_INT)) :
    die('Error');
else :
    //SESION
    include_once 'funciones/sesiones.php';
    include_once 'funciones/funciones.php';
    //Templates
    include_once 'templates/header.php';
    include_once 'templates/barra.php';
    include_once 'templates/navegacion.php';


?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Editar Invitado
                <small>Realice los cambios oportunos</small>
            </h1>
        </section>


        <div class="row">
            <div class="col-md-8">
                <!-- Main content -->
                <section class="content">

                    <!-- Default box -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Editar invitado</h3>
                        </div>
                        <div class="box-body">

                            <?php  //Consulta de bd y seleccion del invitado
                            $sql = "SELECT * FROM invitados WHERE invitado_id = $id";
                            $resultado = $conn->query($sql);
                            $invitado = $resultado->fetch_assoc();
                            ?>

                            <form role="form" name="guardar-registro" id="guardar-registro-archivo" method="post" action="modelo-invitado.php" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="nombre_invitado">Nombre:</label>
                                        <input type="text" class="form-control" id="nombre_invitado" name="nombre_invitado" placeholder="Nombre..." value="<?php echo $invitado['nombre_invitado']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido_invitado">Apellido:</label>
                                        <input type="text" class="form-control" id="apellido_invitado" name="apellido_invitado" placeholder="Apellido..." value="<?php echo $invitado['apellido_invitado']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion_invitado">Descripción:</label>
                                        <textarea class="form-control" id="descripcion_invitado" name="descripcion_invitado" rows="8" placeholder="Añade una descripción..."><?php echo $invitado['descripcion_invitado']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="imagen_actual">Imagen actual</label>
                                        <br>
                                        <img src="../img/invitados/<?php echo $invitado['url_imagen']; ?>" alt="imagen actual" style="width: 150px;">
                                    </div>

                                    <div class="form-group">
                                        <label for="imagen_invitado">Nueva Imagen:</label>
                                        <input class="form-control" type="file" id="imagen_invitado" name="archivo_imagen">

                                        <p class="help-block">Seleccione una imagen del invitado.</p>


                                    </div>
                                    <!-- /.box-body -->

                                    <div class="box-footer">
                                        <input type="hidden" name="registro" value="editar">
                                        <input type="hidden" name="id_registro" value="<?php echo $invitado['invitado_id']; ?>">
                                        <button type="submit" class="btn btn-primary" id="crear_registro">Guardar</button>
                                    </div>
                            </form>
                        </div>
                        <!-- /.box-body -->


                    </div>
                    <!-- /.box -->

                </section>
                <!-- /.content -->
            </div>
        </div>


    </div>
    <!-- /.content-wrapper -->

<?php //FOOTER
    include_once 'templates/footer.php';
endif;
?>