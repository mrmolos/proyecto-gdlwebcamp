<?php if (isset($_POST['submit']))://INICIO DEL IF, EVALUA SI SE RECIBE LA INFORMACION
  //RECOGIENDO LA INFORMACION EN VARIABLES
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$regalo = $_POST['regalo'];
$total = $_POST['total_pedido'];
$fecha = date('Y-m-d H:i:s');
//PEDIDOS
$boletos = $_POST['boletos'];
$camisas = $_POST['pedido_camisas'];
$etiquetas = $_POST['pedido_etiquetas'];
//LOS BOLETOS, CAMISAS Y ETIQUETAS SE VAN A ALMACENAR EN UNA VARIABLE EN FORMATO JSON MEDIANTE UNA FUNCION
include_once 'includes/funciones/funciones.php';
$pedido = productos_json($boletos, $camisas, $etiquetas);
//EVENTOS. AL IGUAL QUE EN EL CASO ANTERIOR. TODOS LOS EVENTOS SE ALMACENAN EN UNA VARIABLE EN FORMATO JSON
$eventos = $_POST['registro'];
$registro = eventos_json($eventos);


//PREPARANDO A LA BASE DE DATOS
try {
require_once('includes/funciones/bd_conexion.php'); //ACCESO AL ARCHIVO QUE CONECTA CON LA BASE DE DATOS
//VARIABLE STMT SE PREPARA PARA INYECTAR CODIGO MYSQL
$stmt = $conn->prepare("INSERT INTO registrados (nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado) VALUES (?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssis", $nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total);//PRIMER PARAMETRO DICTA EL TIPO DE DATO S=STRING I=INTEGER
$stmt->execute();
$stmt->close();//CIERRE DE EL PASO DE DATOS
$conn->close();//CIERRE DE LA CONEXION
header('Location: validar_registro.php?exitoso=1'); //ESTA FUNCION EVITA QUE SE REINSERTEN DATOS HACIENDO QUE SE REDIRECCIONE LA PAGINA
} catch (\Exception $e) {
echo $e->getMessage();
}
endif; //FINAL DEL IF ?>


<?php include_once 'includes/templates/header.php'; ?>


<section class="seccion contenedor">
  <h2>Resumen registro</h2>

<?php 
  if (isset($_GET['exitoso'])):
    if($_GET['exitoso']===1):
      echo "Registro realizado con tremendo éxito";
    endif;
  endif;
?>



</section>

<?php include_once 'includes/templates/footer.php'; ?>
