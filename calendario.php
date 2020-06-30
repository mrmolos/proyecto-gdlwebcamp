<?php include_once 'includes/templates/header.php'; ?>
<!--cierra barra-->



<section class="seccion contenedor">
  <h2>Calendario de eventos</h2>

  <?php
  try {
    require_once('includes/funciones/bd_conexion.php');
    $sql = "SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono ,nombre_invitado, apellido_invitado ";
    $sql .= "FROM eventos ";
    $sql .= "INNER JOIN categoria_evento ";
    $sql .= "ON eventos.id_cat_evento = categoria_evento.id_categoria ";
    $sql .= "INNER JOIN invitados ";
    $sql .= "ON eventos.id_inv = invitados.invitado_id ";
    $sql .= "ORDER BY evento_id";
    $resultado = $conn->query($sql);
  } catch (\Exception $e) {
    echo $e->getMessage();
  }
  ?>

  <div class="calendario">
    <?php
    $calendario = array();
    while ($eventos = $resultado->fetch_assoc()) {
      // OBTENCION DE FECHA Y CATEGORIA DEL EVENTO

      $fecha = $eventos['fecha_evento'];
      $categoria = $eventos['cat_evento'];

      $evento = array(
        'titulo' => $eventos['nombre_evento'],
        'fecha' => $eventos['fecha_evento'],
        'hora' => $eventos['hora_evento'],
        'categoria' => $eventos['cat_evento'],
        'icono' => 'fa' . " " . $eventos['icono'],
        'invitado' => $eventos['nombre_invitado'] . " " . $eventos['apellido_invitado']
      );

      $calendario[$fecha][] = $evento; //ORGANIZA LOS DATOS POR FECHA. SIENDO LA FECHA UNA LLAVE

    } ?>

    <?php //IMPRIMIR EVENTOS CON FOREACH

    foreach ($calendario as $dia => $lista_eventos) { ?>
      <h3>
        <i class="fas fa-calendar-alt">
          <?php
          //unix
          setlocale(LC_TIME, 'es_ES.UTF-8');
          //WINDOWS
          setlocale(LC_TIME, 'spanish');

          echo utf8_encode(strftime("%A, %d de %B del %Y", strtotime($dia))); ?></i>
      </h3>

      <?php foreach ($lista_eventos as $evento) { ?>
        <div class="dia">
          <p class="titulo"><?php echo $evento['titulo']; ?> </p>
          <p class="hora"><i class="far fa-clock" aria-hidden="true"></i> <?php echo $evento['hora']; ?></p>
          <p><i class="<?php echo $evento['icono']; ?>"></i> <?php echo $evento['categoria']; ?></p>
          <p><i class="fa fa-user"></i> <?php echo $evento['invitado']; ?></p>
        </div>
      <?php } //FIN FOREACH DE EVENTOS
      ?>
    <?php } //FIN FOREACH DE DIAS
    ?>





    <?php //CON VAR DUMP MOSTRAMOS LOS DATOS DE CALENDARIO FORMATEADOS
    ?>





    <?php
    $conn->close(); ?>

  </div>


</section>

<?php include_once 'includes/templates/footer.php'; ?>
