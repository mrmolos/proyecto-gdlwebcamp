<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once 'funciones/funciones.php';

//BORRAR categoria

if ($_POST['registro'] == 'eliminar') {
    error_reporting(E_ALL ^ E_NOTICE);
    $id_borrar = $_POST['id'];

    try {

        $stmt = $conn->prepare("DELETE FROM registrados WHERE ID_registrado = ? ");
        $stmt->bind_param('i', $id_borrar);
        $stmt->execute();

        if($stmt->affected_rows){
            $respuesta = array(
                'respuesta' => 'exito',
                'id_eliminado' => $id_borrar
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }
    die(json_encode($respuesta));
}

//Datos enviados desde formulario de crear-registrado.php, editar-registrado.php y desde boton borrar de lista-registrado.php 

//INPUTS
//Datos personales
$nombre = $_POST['nombre_registrado'];
$apellido = $_POST['apellido_registrado'];
$email = $_POST['email_registrado'];
//Pedido
//Boletos
$boletos_adquiridos = $_POST['boletos'];
//extras
$camisas = $_POST['pedido_extra']['camisas']['cantidad'];
$etiquetas = $_POST['pedido_extra']['etiquetas']['cantidad'];

$pedido = productos_json($boletos_adquiridos, $camisas, $etiquetas);

$total =$_POST['total_pedido'];
$regalo =$_POST['regalo'];

$eventos = $_POST['registro_evento'];
$registro_eventos = eventos_json($eventos);

$fecha = $_POST['fecha_registro'];
$id_registro = $_POST['id_registro'];




//CREACION DE NUEVO REGISTRO
if ($_POST['registro'] == 'nuevo') {
    die(json_encode($_POST));
    try {
        $stmt = $conn->prepare('INSERT INTO registrados (nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado, pagado ) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, 1 ) ');
        $stmt->bind_param("sssssis", $nombre, $apellido, $email, $pedido, $registro_eventos, $regalo, $total);
        $stmt->execute();
        $id_insertado = $stmt->insert_id;
        if($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_insertado' => $id_insertado
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }

    die(json_encode($respuesta));
}

//EDITAR CATEGORIA
if ($_POST['registro'] == 'editar') {
    
    

    try {
        $stmt = $conn->prepare('UPDATE registrados SET nombre_registrado = ?, apellido_registrado = ?, email_registrado = ?, fecha_registro = ?, pases_articulos = ?, talleres_registrados = ?, regalo = ?, total_pagado = ?, pagado = 1  WHERE ID_registrado = ? ');
        $stmt->bind_param("ssssssisi", $nombre, $apellido, $email, $fecha, $pedido, $registro_eventos, $regalo, $total, $id_registro);
        $stmt->execute();


        if ($stmt->affected_rows) {

            $respuesta = array(
                'respuesta' => 'exito',
                'id_actualizado' => $id_registro
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }

    die(json_encode($respuesta));
}


