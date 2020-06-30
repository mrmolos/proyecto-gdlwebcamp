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



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            CREAR REGISTRO
            <small>Rellena el formulario para crear un nuevo registro</small>
        </h1>
    </section>


    <div class="row">
        <div class="col-md-8">
            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Crear registro</h3>
                    </div>
                    <div class="box-body">
                        <form  role="form" name="guardar-registro" id="guardar-registro" method="post" action="modelo-registrado.php">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre_registrado" placeholder="Introduce el nombre">
                                </div><!--Nombre-->

                                <div class="form-group">
                                    <label for="apellido">Apellido:</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido_registrado" placeholder="Introduce el apellido">
                                </div><!--apellido-->

                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email_registrado" placeholder="Introduce el email">
                                </div><!--email-->
                                <div id="error"></div>

                                <div class="form-group">
                                    <div id="paquetes" class="paquetes">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Elige las entradas</h3>
                                        </div>

                                        <ul class="lista-precios clearfix row">
                                            <li class="col-md-4">
                                                <div class="tabla-precio text-center">
                                                    <h3>Pase por día</h3>
                                                    <p class="numero">$30</p>
                                                    <ul>
                                                        <li> Bocadillos gratis</li>
                                                        <li> Todas las conferencias</li>
                                                        <li> todos los talleres</li>
                                                    </ul>
                                                    <div class="orden">
                                                        <label for="pase_dia">Boletos deseados: </label>
                                                        <input type="number" class="form-control" min="0" id="pase_dia" size="3" name="boletos[un_dia][cantidad]" placeholder="0" />
                                                        <input type="hidden" value="30" name="boletos[un_dia][precio]">
                                                    </div><!--boletos-->
                                                </div>
                                            </li>
                                            <li class="col-md-4">
                                                <div class="tabla-precio text-center">
                                                    <h3>Pase por 2 días</h3>
                                                    <p class="numero">$45</p>
                                                    <ul>
                                                        <li> Bocadillos gratis</li>
                                                        <li> Todas las conferencias</li>
                                                        <li> todos los talleres</li>
                                                    </ul>
                                                    <div class="orden">
                                                        <label for="pase_dos_dias">Boletos deseados: </label>
                                                        <input type="number" class="form-control" min="0" id="pase_dos_dias" size="3" name="boletos[dos_dias][cantidad]" placeholder="0" />
                                                        <input type="hidden" value="45" name="boletos[dos_dias][precio]">
                                                    </div><!--boletos-->
                                                </div>
                                            </li>
                                            <li class="col-md-4">
                                                <div class="tabla-precio text-center">
                                                    <h3>Todos los días</h3>
                                                    <p class="numero">$50</p>
                                                    <ul>
                                                        <li> Bocadillos gratis</li>
                                                        <li> Todas las conferencias</li>
                                                        <li> todos los talleres</li>
                                                    </ul>
                                                    <div class="orden">
                                                        <label for="pase_todos_dias">Boletos deseados: </label>
                                                        <input type="number" class="form-control" min="0" id="pase_todos_dias" size="3" name="boletos[completo][cantidad]" placeholder="0" />
                                                        <input type="hidden" value="50" name="boletos[completo][precio]">
                                                    </div><!--boletos-->
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Elige los talleres</h3>
                                    </div>
                                    <div id="eventos" class="eventos clearfix">

                                        <div class="caja row">
                                            <?php //Convertir la parte de talleres en dinámica
                                            try {
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
                                                    'Saturday' => 'sábado',
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
                                            } //Fin del while

                                            ?>

                                            <?php foreach ($eventos_dias as $dia => $eventos) { ?>
                                                <div id="<?php echo str_replace('á', 'a', $dia); ?>" class="contenido-dia clearfix">
                                                    <h4 class="text-center nombre_dia"><?php echo $dia; ?></h4>

                                                    <?php


                                                    foreach ($eventos['eventos'] as $tipo => $evento_dia) : ?>

                                                        <div class="col-md-4">
                                                            <p><?php echo $tipo . ":"; ?></p>

                                                            <?php foreach ($evento_dia as $evento) { ?>
                                                                <label>
                                                                    <input type="checkbox" class="minimal" name="registro_evento[]" id="<?php echo $evento['id']; ?>" value="<?php echo $evento['id']; ?>" />
                                                                    <time><?php echo $evento['hora_evento']; ?></time>
                                                                    <?php echo $evento['nombre_evento']; ?>
                                                                    <br>
                                                                    <span style="width:100%" class="autor text-center"><?php echo $evento['nombre_invitado'] . " " . $evento['apellido_invitado']; ?></span>
                                                                </label><!--evento-->
                                                            <?php } //END FOREACH 
                                                            ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <!--Contenido dia-->
                                            <?php }  ?>

                                        </div>
                                        <!--.caja-->
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div id="resumen" class="resumen ">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Pagos y extras</h3>
                                        </div>
                                        <br>
                                        <div class="caja clearfix row">
                                            <div class="extras col-md-6">
                                                <div class="orden">
                                                    <label for="camisa_evento">Camisa del evento $10 <small>(7% dto.)</small></label>
                                                    <input type="number" class="form-control" id="camisa_evento" min="0" size="3" name="pedido_extra[camisas][cantidad]" placeholder="0" />
                                                    <input type="hidden" value="10" name="pedido_extra[camisas][precio]">
                                                </div>
                                                <div class="orden">
                                                    <label for="etiquetas">Paquete de diez etiquetas $2
                                                        <small>(CSS3, HTML5, JavaScript)</small></label>
                                                    <input type="number" class="form-control" id="etiquetas" min="0" size="3" name="pedido_extra[etiquetas][cantidad]" placeholder="0" />
                                                    <input type="hidden" value="2" name="pedido_extra[etiquetas][precio]">
                                                </div>
                                                <div class="orden">
                                                    <label for="regalo">Seleccione un regalo</label>
                                                    <select id="regalo" name="regalo" required class="form-control ">
                                                        <option value="">-- Seleccione un regalo --</option>
                                                        <option value="2">Etiquetas</option>
                                                        <option value="1">Pulsera</option>
                                                        <option value="3">Pluma</option>
                                                    </select>
                                                </div>
                                                <br>

                                                <input type="button" id="calcular" class="btn btn-success" value="calcular">
                                            </div>
                                            <!--extras-->
                                            <div class="total col-md-6">
                                                <p>Resumen: </p>
                                                <div id="lista-productos">

                                                </div>
                                                <!--Aqui se imprimen los productos-->
                                                <p>Total:</p>
                                                <div id="suma-total">

                                                </div>
                                                <input type="hidden" name="total_pedido" id="total_pedido">

                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <input type="hidden" name="registro" value="nuevo">
                                <button type="submit" class="btn btn-primary" id="btnRegistro">Añadir</button>
                            </div>
                            <!--Boton submit-->
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