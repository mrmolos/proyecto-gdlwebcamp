<?php
//SESION
include_once 'funciones/sesiones.php';

include_once 'funciones/funciones.php';
//HEADER
include_once 'templates/header.php';
//BARRA
include_once 'templates/barra.php';

include_once 'templates/navegacion.php';
?>

<!-- =============================================== -->

<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      AGREGAR INVITADO
      <small>Rellena el formulario para agregar un invitado</small>
    </h1>
  </section>


  <div class="row">
    <div class="col-md-8">
      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Nuevo invitado</h3>
          </div>
          <div class="box-body">
            <form role="form" name="guardar-registro" id="guardar-registro-archivo" method="post" action="modelo-invitado.php" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="nombre_invitado">Nombre:</label>
                  <input type="text" class="form-control" id="nombre_invitado" name="nombre_invitado" placeholder="Nombre...">
                </div>
                <div class="form-group">
                  <label for="apellido_invitado">Apellido:</label>
                  <input type="text" class="form-control" id="apellido_invitado" name="apellido_invitado" placeholder="Apellido...">
                </div>
                <div class="form-group">
                  <label for="descripcion_invitado">Descripción:</label>
                  <textarea class="form-control" id="descripcion_invitado" name="descripcion_invitado" rows="8" placeholder="Añade una descripción..."></textarea>
                </div>

                <div class="form-group">
                  <label for="imagen_invitado">Imagen:</label>
                  <input class="form-control" type="file" id="imagen_invitado" name="archivo_imagen">

                  <p class="help-block">Seleccione una imagen del invitado.</p>
                </div>
                

              </div>           
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="hidden" name="registro" value="nuevo">
                <button type="submit"  class="btn btn-primary" id="crear_registro">Añadir</button>
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
?>