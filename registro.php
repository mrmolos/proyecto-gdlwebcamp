<?php include_once 'includes/templates/header.php'; ?>
<!--cierra barra-->

<section class="seccion contenedor">
  <h2>Registro de Usuarios</h2>
  <form id="registro" class="registro" action="pagar.php" method="post">
    <div id="datos_usuario" class="registro caja clearfix">
      <div class="campo">
        <label for="nombre">Nombre: </label>
        <input id="nombre" type="text" name="nombre" placeholder="Tu nombre" />
      </div>
      <div class="campo">
        <label for="apellido">Apellido: </label>
        <input id="apellido" type="text" name="apellido" placeholder="Tu apellido" />
      </div>
      <div class="campo">
        <label for="email">Email: </label>
        <input id="email" type="email" name="email" placeholder="Tu email" />
      </div>
      <div id="error"></div>
    </div>
    <!--Final datos de usuario-->

    <div id="paquetes" class="paquetes">
      <h3>Elige el número de entradas</h3>

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
            <div class="orden">
              <label for="pase_dia">Boletos deseados: </label>
              <input type="number" min="0" id="pase_dia" size="3" name="boletos[un_dia][cantidad]" placeholder="0" />
              <input type="hidden" value="30" name="boletos[un_dia][precio]">
            </div>
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
            <div class="orden">
              <label for="pase_dos_dias">Boletos deseados: </label>
              <input type="number" min="0" id="pase_dos_dias" size="3" name="boletos[dos_dias][cantidad]" placeholder="0" />
              <input type="hidden" value="45" name="boletos[dos_dias][precio]">
            </div>
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
            <div class="orden">
              <label for="pase_todos_dias">Boletos deseados: </label>
              <input type="number" min="0" id="pase_todos_dias" size="3" name="boletos[completo][cantidad]" placeholder="0" />
              <input type="hidden" value="50" name="boletos[completo][precio]">
            </div>
          </div>
        </li>
      </ul>
    </div>

    <div id="eventos" class="eventos clearfix">
      <h3>Elige tus talleres</h3>
      <div class="caja">
        <?php //Convertir la parte de talleres en dinámica
        try {
          require_once('includes/funciones/bd_conexion.php');
          $sql = "SELECT eventos.*, categoria_evento.cat_evento, invitados.nombre_invitado, invitados.apellido_invitado ";
          $sql .= " FROM eventos ";
          $sql .= " JOIN categoria_evento ";
          $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";

          $sql .= " JOIN invitados ";
          $sql .= " ON eventos.id_inv = invitados.invitado_id ";
          $sql .= " ORDER BY eventos.fecha_evento, eventos.id_cat_evento, eventos.hora_evento ";

          $resultado = $conn->query($sql);
        } catch (Exception $e) {
          echo $e->getMessage();
        }

        $eventos_dias = array();
        while ($eventos = $resultado->fetch_assoc()) {
          
          $fecha = $eventos['fecha_evento'];

          $dia_semana = strftime("%A", strtotime($fecha));
          
          $dia_semana_es = array(
            'Friday' => 'viernes',
            'Saturday' => 'sabado',
            'Sunday' => 'domingo'
          );

          $categoria = $eventos['cat_evento'];
          $dia = array(
            'nombre_evento' => $eventos['nombre_evento'],
            'hora_evento' => $eventos['hora_evento'],
            'id' => $eventos['evento_id'],
            'nombre_invitado' => $eventos['nombre_invitado'],
            'apellido_invitado' => $eventos['apellido_invitado']

          );
          $dia_es = $dia_semana_es[$dia_semana];
          
          $eventos_dias[$dia_es]['eventos'][$categoria][] = $dia;
        }//Fin del while
        
        ?>

        <?php foreach ($eventos_dias as $dia => $eventos) { ?>
          <div id="<?php echo str_replace('á', 'a', $dia); ?>" class="contenido-dia clearfix">
            <h4><?php echo $dia; ?></h4>

            <?php
            

            foreach($eventos['eventos'] as $tipo => $evento_dia): ?> 
            
            <div>
              <p><?php echo $tipo . ":"; ?></p>
              <?php
                    /*echo "<pre>";
                    var_dump($evento_dia);
                    echo "</pre>";*/
               ?>

               <?php foreach($evento_dia as $evento) { ?>
              <label>
                <input type="checkbox" name="registro[]" id="<?php echo $evento['id']; ?>" value="<?php echo $evento['id']; ?>" />
                <time><?php echo $evento['hora_evento']; ?></time>
                <?php echo $evento['nombre_evento']; ?>
                <br>
                <span class="autor"><?php echo $evento['nombre_invitado'] . " " . $evento['apellido_invitado']; ?></span>
              </label>
               <?php } //END FOREACH ?>
            </div>
            <?php endforeach; ?>
          </div>
          <!--Contenido dia-->
        <?php }  ?>

      </div>
      <!--.caja-->
    </div>
    <!--#eventos-->
    
    <div id="resumen" class="resumen">
      <h3>Pago y extras</h3>
      <div class="caja clearfix">
        <div class="extras">
          <div class="orden">
            <label for="camisa_evento">Camisa del evento $10 <small>(7% dto.)</small></label>
            <input type="number" id="camisa_evento" min="0" size="3" name="pedido_extra[camisas][cantidad]" placeholder="0" />
            <input type="hidden" value="10" name="pedido_extra[camisas][precio]">
          </div>
          <div class="orden">
            <label for="etiquetas">Paquete de diez etiquetas $2
              <small>(CSS3, HTML5, JavaScript)</small></label>
            <input type="number" id="etiquetas" min="0" size="3" name="pedido_extra[etiquetas][cantidad]" placeholder="0" />
            <input type="hidden" value="2" name="pedido_extra[etiquetas][precio]">
          </div>
          <div class="orden">
            <label for="regalo">Seleccione un regalo</label>
            <select id="regalo" name="regalo" required>
              <option value="">-- Seleccione un regalo --</option>
              <option value="2">Etiquetas</option>
              <option value="1">Pulsera</option>
              <option value="3">Pluma</option>
            </select>
          </div>

          <input type="button" id="calcular" class="boton" value="calcular">
        </div>
        <div class="total">
          <p>Resumen: </p>
          <div id="lista-productos">

          </div>
          <p>Total:</p>
          <div id="suma-total">

          </div>
          <input type="hidden" name="total_pedido" id="total_pedido">
          <input id="btnRegistro" type="submit" name="submit" class="boton" value="Pagar">
        </div>
      </div>
    </div>
  </form>
</section>

<?php include_once 'includes/templates/footer.php'; ?>