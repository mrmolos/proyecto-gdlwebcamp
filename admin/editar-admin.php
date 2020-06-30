<?php
//SESION
include_once 'funciones/sesiones.php';
//FUNCIONES
include_once 'funciones/funciones.php';
//Tomar id de la url
$id = $_GET['id'];

//Validacion de la id
if (!filter_var($id, FILTER_VALIDATE_INT)) {
  die("ERROR");
}
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
      EDITAR ADMINISTRADOR
      <small></small>
    </h1>
  </section>


  <div class="row">
    <div class="col-md-8">
      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Editar los datos</h3>
          </div>



          <div class="box-body">
            <?php
            $sql = "SELECT * FROM admins WHERE id_admin = $id ";
            $resultado = $conn->query($sql);
            $admin = $resultado->fetch_assoc();

            /*echo "<pre>";
            var_dump($admin);
            echo "</pre>";*/


            ?>




            <form role="form" name="guardar-registro" id="guardar-registro" method="post" action="modelo-admin.php">
              <div class="box-body">
                <div class="form-group">
                  <label for="usuario">Usuario:</label>
                  <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Introduce nick de usuario" value="<?php echo $admin['usuario']; ?>">
                </div>
                <div class="form-group">
                  <label for="nombre">Nombre:</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Introduce tu nombre" value="<?php echo $admin['nombre']; ?>">
                </div>
                <div class="form-group">
                  <label for="password">Contraseña:</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Nueva Contraseña">
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="hidden" name="registro" value="editar">
                <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                <button type="submit" class="btn btn-primary">Guardar</button>
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