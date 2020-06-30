<?php
//ESTE ARCHIVO REALIZA LA GESTION DEL PAGO POR PAYPAL
//EN PRIMER LUGAR VALIDA Y RECOJE TODA LA INFO DEL FORMULARIO. LA INSERTA EN NUESTRA BD Y POSTERIORMENTE
//REALIZA LOS PASOS NECESARIOS PARA REALIZAR UN PAGO POR PAYPAL MEDIANTE LAS INSTANCIAS DE SU API
//QUE SON LLAMADAS A CONTINUACION
 if(!isset($_POST['submit'])) {
   exit("hubo un error");
 }

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;



require 'includes/paypal.php';

if (isset($_POST['submit']))://INICIO DEL IF, EVALUA SI SE RECIBE LA INFORMACION
  //RECOGIENDO LA INFORMACION EN VARIABLES
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$regalo = $_POST['regalo'];
$total = $_POST['total_pedido'];
$fecha = date('Y-m-d H:i:s');
//PEDIDOS
$boletos = $_POST['boletos'];
$numeroBoletos = $boletos;
$pedidoExtra = $_POST['pedido_extra'];
$camisas = $_POST['pedido_extra']['camisas']['cantidad'];
$precioCamisa = $_POST['pedido_extra']['camisas']['precio'];

$etiquetas = $_POST['pedido_extra']['etiquetas']['cantidad'];
$precioEtiqueta = $_POST['pedido_extra']['etiquetas']['precio'];

//LOS BOLETOS, CAMISAS Y ETIQUETAS SE VAN A ALMACENAR EN UNA VARIABLE EN FORMATO JSON MEDIANTE UNA FUNCION
include_once 'includes/funciones/funciones.php';
$pedido = productos_json($boletos, $camisas, $etiquetas);
//EVENTOS. AL IGUAL QUE EN EL CASO ANTERIOR. TODOS LOS EVENTOS SE ALMACENAN EN UNA VARIABLE EN FORMATO JSON
$eventos = $_POST['registro'];
$registro = eventos_json($eventos);



//INSERCION DE TODOS LOS DATOS EN LA BD
try {
require_once('includes/funciones/bd_conexion.php'); //ACCESO AL ARCHIVO QUE CONECTA CON LA BASE DE DATOS
//VARIABLE STMT SE PREPARA PARA INYECTAR CODIGO MYSQL
$stmt = $conn->prepare("INSERT INTO registrados (nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado) VALUES (?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssis", $nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total);//PRIMER PARAMETRO DICTA EL TIPO DE DATO S=STRING I=INTEGER
$stmt->execute();
$ID_registro = $stmt->insert_id;
$stmt->close();//CIERRE DE EL PASO DE DATOS
$conn->close();//CIERRE DE LA CONEXION
//header('Location: validar_registro.php?exitoso=1'); //ESTA FUNCION EVITA QUE SE REINSERTEN DATOS HACIENDO QUE SE REDIRECCIONE LA PAGINA
} catch (\Exception $e) {
echo $e->getMessage();
}
endif; //FINAL DEL IF SUBMIT



//PAYPAL

//CREANDO LAS INSTANCIAS DE PAYPAL NECESARIAS

//PAYER
$compra = new Payer();
$compra->setPaymentMethod('paypal');

//ITEMS
$i=0;
$arreglo_pedido = array();//TODOS LOS ITEMS QUE SE COMPRAN SE INCLUYEN EN ESTE ARRAY
foreach ($numeroBoletos as $key => $value){
  if ( (int)$value['cantidad'] > 0){

      ${"articulo$i"} = new Item();
      $arreglo_pedido[] = ${"articulo$i"};
      ${"articulo$i"}->setName('Pase: ' . $key)
      ->setCurrency('EUR')
      ->setQuantity((int)$value['cantidad'])
      ->setPrice((int)$value['precio']);

      $i++;
  }
}
foreach ($pedidoExtra as $key => $value){
  if ( (int)$value['cantidad'] > 0){

    if($key=='camisas'){
      $precio = (float)$value['precio']* .93;
    } else {
      $precio = (int) $value['precio'];
    }

      ${"articulo$i"} = new Item();
      $arreglo_pedido[] = ${"articulo$i"};
      ${"articulo$i"}->setName('Extras: ' . $key)
      ->setCurrency('EUR')
      ->setQuantity((int)$value['cantidad'])
      ->setPrice($precio);

      $i++;
  }
}

//LISTA DE ARTICULOS
$listaArticulos = new ItemList();
$listaArticulos->setItems($arreglo_pedido);

//CANTIDAD
$cantidad = new Amount();
$cantidad->setCurrency('EUR')
          ->setTotal($total);

//TRANSACCION
$transaccion = new Transaction();
$transaccion->setAmount($cantidad)
               ->setItemList($listaArticulos)
               ->setDescription('Pago GDLWebcamp')
               ->setInvoiceNumber($ID_registro);

//REDIRECCION
$redireccionar = new RedirectUrls();
$redireccionar->setReturnUrl(URL_SITIO . "/pago_finalizado.php?id_pago={$ID_registro}")
              ->setCancelUrl(URL_SITIO . "/pago_finalizado.php?id_pago={$ID_registro}");

//PAGO
$pago = new Payment();
$pago->setIntent("sale")
     ->setPayer($compra)
     ->setRedirectUrls($redireccionar)
     ->setTransactions(array($transaccion));


     try {
      $pago->create($apiContext);
  } catch (PayPal\Exception\PayPalConnectionException $pce) {
      echo "<pre>";
      print_r(json_decode($pce->getData()));
      exit;
      echo "</pre>";
  }

  $aprobado = $pago->getApprovalLink();

  header("Location: {$aprobado}");
