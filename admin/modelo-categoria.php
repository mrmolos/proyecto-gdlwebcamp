<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once 'funciones/funciones.php';



//INPUTS
$categoria = $_POST['nombre_categoria'];
$icono = $_POST['icono'];
$id_registro = $_POST['id_registro'];

//CREACION DE NUEVA CATEGORIA
if ($_POST['registro'] == 'nuevo') {

    try {
        $stmt = $conn->prepare('INSERT INTO categoria_evento SET cat_evento = ?, icono = ? ');
        $stmt->bind_param('ss', $categoria, $icono);
        $stmt->execute();
        $id_insertado = $stmt->insert_id;

        if ($stmt->affected_rows) {
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
        $stmt = $conn->prepare('UPDATE categoria_evento SET cat_evento = ?, icono = ?, editado = NOW()  WHERE id_categoria = ? ');
        $stmt->bind_param("ssi", $categoria, $icono, $id_registro);
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

//BORRAR categoria

if ($_POST['registro'] == 'eliminar') {

    $id_borrar = $_POST['id'];

    try {

        $stmt = $conn->prepare("DELETE FROM categoria_evento WHERE id_categoria = ? ");
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
