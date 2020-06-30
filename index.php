<?php include_once 'includes/templates/header.php'; ?>
    <!--cierra barra-->

    <section class="seccion contenedor">
      <h2>La mejor conferencia de diseño web en español</h2>
      <p>
        Nulla hendrerit tempus nunc id consectetur. Nulla ut venenatis mi.
        Aenean elementum eget felis at pulvinar. Donec at neque eget nibh
        lobortis condimentum at vel eros. Suspendisse commodo posuere eleifend.
        Curabitur laoreet sit amet arcu quis vulputate. Ut consectetur tempus
        gravida. Nulla facilisi. Nam sodales dolor ut porta cursus. Sed aliquam
        nisi volutpat, faucibus ex ut, sodales diam. Suspendisse potenti.
      </p>
    </section>

    <section class="programa">
      <div class="contenedor-video">
        <video autoplay loop muted poster="img/bg-talleres.jpg">
          <source src="video/video.mp4" type="video/mp4" />
          <source src="video/video.webm" type="video/webm" />
          <source src="video/video.ogv" type="video/ogv" />
        </video>
      </div>

      <div class="contenido-programa">
        <div class="contenedor">
          <div class="programa-evento">
            <h2>Programa del evento</h2>

            <?php
            try {
              require_once('includes/funciones/bd_conexion.php');
              $sql = "SELECT * FROM `categoria_evento`";

              $resultado = $conn->query($sql);
            } catch (\Exception $e) {
              echo $e->getMessage();
            }
         ?>

            <nav class="menu-programa">
              <?php while ($cat = $resultado->fetch_array(MYSQLI_ASSOC) ) { ?>
                <a href="#<?php echo strtolower($cat['cat_evento']); ?>"><i class="fas <?php echo $cat['icono']; ?>"></i> <?php echo $cat['cat_evento'];  ?></a>
            <?php }  ?>
            </nav>

            <?php
            try {
              require_once('includes/funciones/bd_conexion.php');
              $sql = "SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono ,nombre_invitado, apellido_invitado ";
              $sql .= "FROM eventos ";
              $sql .= "INNER JOIN categoria_evento ";
              $sql .= "ON eventos.id_cat_evento = categoria_evento.id_categoria ";
              $sql .= "INNER JOIN invitados ";
              $sql .= "ON eventos.id_inv = invitados.invitado_id ";
              $sql .= "AND eventos.id_cat_evento = 1 ";
              $sql .= "ORDER BY evento_id LIMIT 2;";
              $sql .= "SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono ,nombre_invitado, apellido_invitado ";
              $sql .= "FROM eventos ";
              $sql .= "INNER JOIN categoria_evento ";
              $sql .= "ON eventos.id_cat_evento = categoria_evento.id_categoria ";
              $sql .= "INNER JOIN invitados ";
              $sql .= "ON eventos.id_inv = invitados.invitado_id ";
              $sql .= "AND eventos.id_cat_evento = 2 ";
              $sql .= "ORDER BY evento_id LIMIT 2;";
              $sql .= "SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono ,nombre_invitado, apellido_invitado ";
              $sql .= "FROM eventos ";
              $sql .= "INNER JOIN categoria_evento ";
              $sql .= "ON eventos.id_cat_evento = categoria_evento.id_categoria ";
              $sql .= "INNER JOIN invitados ";
              $sql .= "ON eventos.id_inv = invitados.invitado_id ";
              $sql .= "AND eventos.id_cat_evento = 3 ";
              $sql .= "ORDER BY evento_id LIMIT 2;";

            } catch (\Exception $e) {
              echo $e->getMessage();
            }?>

            <?php $conn->multi_query($sql); //MULTI CONSULTA ?>

            <?php do {
              $resultado = $conn->store_result();
              $row =$resultado->fetch_all(MYSQLI_ASSOC); ?>
<?php $i=0; ?>
<?php foreach ($row as $evento): ?>
  <?php if ($i % 2 == 0) { ?>
    <div id="<?php echo strtolower($evento['cat_evento']); ?>" class="info-curso ocultar clearfix">
  <?php }  ?>

                <div class="detalle-evento">
                  <h3><?php echo $evento['nombre_evento']; ?></h3>
                  <p><i class="fas fa-clock"></i> <?php echo $evento['hora_evento']; ?></p>
                  <p><i class="fas fa-calendar"></i> <?php echo $evento['fecha_evento']; ?></p>
                  <p><i class="fas fa-user"></i> <?php echo $evento['nombre_invitado'] . " " . $evento['apellido_invitado']; ?></p>
                </div>

                <?php if ($i % 2 == 1): ?>
                <a href="calendario.php" class="boton float-right">Ver todos</a>
              </div> <!--evento-->
              <?php endif; ?>
              <?php $i++; ?>

          <?php endforeach; ?>
          <?php $resultado->free(); ?>





        <?php  } while ($conn->more_results() && $conn->next_result()); ?>








          </div><!--programa-evento-->
        </div><!--contenedor-->
      </div><!--contenido programa-->
    </section> <!--programa-->

    <?php include_once 'includes/templates/invitados.php' //CARGA SECCION DE INVITADOS?>

    <div class="contador parallax">
      <div class="contenedor">
        <ul class="resumen-evento clearfix">
          <li>
            <p class="numero"></p>
            Invitados
          </li>
          <li>
            <p class="numero"></p>
            Talleres
          </li>
          <li>
            <p class="numero"></p>
            Días
          </li>
          <li>
            <p class="numero"></p>
            Conferencias
          </li>
        </ul>
      </div>
    </div>

    <section class="seccion precios">
      <h2>Precios</h2>
      <div class="contenedor">
        <ul class="lista-precios clearfix">
          <li>
            <div class="tabla-precio">
              <h3>Pase por día</h3>
              <p class="numero">$30</p>
              <ul>
                <li><i class="fas fa-check"></i> Bocadillos gratis</li>
                <li><i class="fas fa-check"></i> Todas las conferencias</li>
                <li><i class="fas fa-check"></i> todos los talleres</li>
              </ul>
              <a href="#" class="boton hollow">Comprar</a>
            </div>
          </li>
          <li>
            <div class="tabla-precio">
              <h3>Pase por 2 días</h3>
              <p class="numero">$45</p>
              <ul>
                <li><i class="fas fa-check"></i> Bocadillos gratis</li>
                <li><i class="fas fa-check"></i> Todas las conferencias</li>
                <li><i class="fas fa-check"></i> todos los talleres</li>
              </ul>
              <a href="#" class="boton">Comprar</a>
            </div>
          </li>
          <li>
            <div class="tabla-precio">
              <h3>Todos los días</h3>
              <p class="numero">$50</p>
              <ul>
                <li><i class="fas fa-check"></i> Bocadillos gratis</li>
                <li><i class="fas fa-check"></i> Todas las conferencias</li>
                <li><i class="fas fa-check"></i> todos los talleres</li>
              </ul>
              <a href="#" class="boton hollow">Comprar</a>
            </div>
          </li>
        </ul>
      </div>
    </section>

    <div class="mapa" id="mapa"></div>

    <section class="seccion">
      <!--TESTIMONIALES-->
      <h2>Testimoniales</h2>
      <div class="testimoniales contenedor clearfix">
        <div class="testimonial">
          <blockquote>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
              quis pulvinar libero, ac auctor nibh. Donec auctor, purus vitae
              luctus suscipit, eros mauris blandit nisi, eget ullamcorper neque
              augue sit amet ante. Proin lacinia a arcu quis porttitor.
            </p>
            <footer class="info-testimonial clearfix">
              <img src="img/testimonial.jpg" alt="imagen testimonial" />
              <cite>Judas El Miserable <span>Bebedor tranquilo</span></cite>
            </footer>
          </blockquote>
        </div>
        <div class="testimonial">
          <blockquote>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
              quis pulvinar libero, ac auctor nibh. Donec auctor, purus vitae
              luctus suscipit, eros mauris blandit nisi, eget ullamcorper neque
              augue sit amet ante. Proin lacinia a arcu quis porttitor.
            </p>
            <footer class="info-testimonial clearfix">
              <img src="img/testimonial.jpg" alt="imagen testimonial" />
              <cite>Judas El Miserable <span>Bebedor tranquilo</span></cite>
            </footer>
          </blockquote>
        </div>
        <div class="testimonial">
          <blockquote>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
              quis pulvinar libero, ac auctor nibh. Donec auctor, purus vitae
              luctus suscipit, eros mauris blandit nisi, eget ullamcorper neque
              augue sit amet ante. Proin lacinia a arcu quis porttitor.
            </p>
            <footer class="info-testimonial clearfix">
              <img src="img/testimonial.jpg" alt="imagen testimonial" />
              <cite>Judas El Miserable <span>Bebedor tranquilo</span></cite>
            </footer>
          </blockquote>
        </div>
      </div>
    </section>

    <div class="newsletter parallax">
      <div class="contenido contenedor">
        <p>registrate al newsletter:</p>
        <h3>MOLWEBCAM</h3>
        <a href="#mc_embed_signup" class="boton_newsletter boton transparent">Registro</a>
      </div>
    </div>

    <section class="seccion">
      <h2>faltan</h2>
      <div class="cuenta-regresiva contenedor">
        <ul class="clearfix">
          <li>
            <p id="dias" class="numero"></p>
            días
          </li>
          <li>
            <p id="horas" class="numero"></p>
            horas
          </li>
          <li>
            <p id="minutos" class="numero"></p>
            minutos
          </li>
          <li>
            <p id="segundos" class="numero"></p>
            segundos
          </li>
        </ul>
      </div>
    </section>

    <?php include_once 'includes/templates/footer.php'; ?>
