<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once 'funciones/funciones.php';

//INPUTS $_POST
$nombre = $_POST['nombre_invitado'];
$apellido = $_POST['apellido_invitado'];
$descripcion = $_POST['descripcion_invitado'];

$id_registro = $_POST['id_registro'];





//CREACION DE NUEVO INVITADO
if ($_POST['registro'] == 'nuevo') {


    /*$respuesta = array(
        'post' => $_POST,
        'file' => $_FILES
    );
    die(json_encode($respuesta)); */

    $directorio = "../img/invitados/";

    if (!is_dir($directorio)) {
        mkdir($directorio, 0755, true);
    }

    if (move_uploaded_file($_FILES['archivo_imagen']['tmp_name'], $directorio . $_FILES['archivo_imagen']['name'])) {
        $imagen_url = $_FILES['archivo_imagen']['name'];
        $imagen_resultado = "Se subió correctamente";
    } else {
        $respuesta = array(
            'respuesta' => error_get_last()
        );
    }

    try {
        $stmt = $conn->prepare('INSERT INTO invitados SET nombre_invitado = ?, apellido_invitado = ?, descripcion_invitado = ?, url_imagen = ? ');
        $stmt->bind_param('ssss', $nombre, $apellido, $descripcion, $imagen_url);
        $stmt->execute();
        $id_insertado = $stmt->insert_id;

        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_insertado' => $id_insertado,
                'resultado_imagen' => $imagen_resultado
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


//EDITAR INVITADO 
if ($_POST['registro'] == 'editar') {
    
    /*$respuesta = array(
        'post' => $_POST,
        'file' => $_FILES
    );
    die(json_encode($respuesta));*/
    
    //GESTION DE LA IMAGEN
    //SI NO EXISTE EL DIRECTORIO, LO CREA
    $directorio = "../img/invitados/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0755, true);
    }
    //MOVER LA IMAGEN AL DIRECTORIO Y EXTRAER EL NOMBRE PARA LA URL
    if (move_uploaded_file($_FILES['archivo_imagen']['tmp_name'], $directorio . $_FILES['archivo_imagen']['name'])) {
        $imagen_url = $_FILES['archivo_imagen']['name'];
        $imagen_resultado = "Se subió correctamente";
    } else {
        $respuesta = array(
            'respuesta' => error_get_last()
        );
    }

    //ACTUALIZAR LOS DATOS DE LA BD
    try {
        if ($_FILES['archivo_imagen']['size'] > 0) {
            //EDICION INCLUYE IMAGEN
            $stmt = $conn->prepare('UPDATE invitados SET nombre_invitado = ?, apellido_invitado  = ?, descripcion_invitado = ?, url_imagen = ?,  editado = NOW()  WHERE invitado_id = ? ');
            $stmt->bind_param("ssssi", $nombre, $apellido, $descripcion, $imagen_url, $id_registro);
        } else {
            $stmt = $conn->prepare('UPDATE invitados SET nombre_invitado = ?, apellido_invitado  = ?, descripcion_invitado = ?, editado = NOW()  WHERE invitado_id = ? ');
            $stmt->bind_param("sssi", $nombre, $apellido, $descripcion, $id_registro);
        }

        $stmt->execute();
        $registros = $stmt->affected_rows;

        if ($registros > 0) {
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

        $stmt = $conn->prepare("DELETE FROM invitados WHERE invitado_id = ? ");
        $stmt->bind_param('i', $id_borrar);
        $stmt->execute();

        if ($stmt->affected_rows) {
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
