<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once 'funciones/funciones.php';

//Añadiendo los inputs

$titulo = $_POST['titulo_evento'];
$categoria_id = $_POST['categoria_evento'];
$invitado_id = $_POST['invitado_evento'];
//FECHA Y HORA
$fecha = $_POST['fecha_evento'];
$fecha_formateada = date('Y-m-d', strtotime($fecha));

$hora = $_POST['hora_evento'];
$hora_formateada = date('H:i', strtotime($hora));
//id registro para editar evento
$id_registro = $_POST['id_registro'];



//CREACION DE NUEVO EVENTO
if ($_POST['registro'] == 'nuevo') {
    
    try {
        $stmt = $conn->prepare('INSERT INTO eventos SET nombre_evento = ?, fecha_evento = ?, hora_evento = ?, id_cat_evento = ?, id_inv = ? ');
        $stmt->bind_param('sssii', $titulo, $fecha_formateada, $hora_formateada, $categoria_id, $invitado_id);
        $stmt->execute();
        $id_insertado = $stmt->insert_id;

        if($stmt->affected_rows){
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

//EDITAR EVENTO
if ($_POST['registro'] == 'editar') {
    try {   
            $stmt = $conn->prepare('UPDATE eventos SET nombre_evento = ?, fecha_evento = ?, hora_evento = ?, id_cat_evento = ?, id_inv = ?, editado = NOW()  WHERE evento_id = ?');
            $stmt->bind_param("sssiii", $titulo, $fecha_formateada, $hora_formateada, $categoria_id, $invitado_id, $id_registro);
            $stmt->execute();
            $id_editado = $stmt->insert_id;
        if ($stmt->affected_rows) {
            
            $respuesta = array(
                'respuesta' => 'exito',
                'id_actualizado' => $id_editado
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


//BORRAR ADMINISTRADOR

if ($_POST['registro'] == 'eliminar') {

    $id_borrar = $_POST['id'];

    try {

        $stmt = $conn->prepare("DELETE FROM eventos WHERE evento_id = ? ");
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