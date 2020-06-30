<?php
/*echo '<pre>';
var_dump($_POST);
echo '</pre>';*/

/*if($conn->ping()){
    echo "Conectado";
} Con este código comprobamos si hemos conectado bien a la base de datos*/
//Para conexion a la bd
error_reporting(E_ALL ^ E_NOTICE);
include_once 'funciones/funciones.php';

//Añadiendo los inputs
$usuario = $_POST['usuario'];
$nombre = $_POST['nombre'];
$password = $_POST['password'];
$id_registro = (int) $_POST['id_registro'];


//CREACION DE NUEVO USUARIO ADMINISTRADOR

if ($_POST['registro'] == 'nuevo') {





    //hasheo de contraseña
    //Este hasheo se produce en un solo sentido. Si olvidas la contraseña no hay forma de recuperarlo
    $opciones = array(
        'cost' => 12
    );
    $password_hashed = password_hash($password, PASSWORD_BCRYPT, $opciones); //regresa password hasheado

    //Introduccion de valores a la bd

    try {

        $stmt = $conn->prepare("INSERT INTO admins (usuario, nombre, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $usuario, $nombre, $password_hashed);
        $stmt->execute();
        //Respuesta
        $id_registro = $stmt->insert_id;
        if ($id_registro > 0) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_admin' => $id_registro
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error:" .  $e->getMessage();
    }

    die(json_encode($respuesta));
}

//EDITAR USUARIO ADMINISTRADOR

if ($_POST['registro'] == 'editar') {


    try {
        if (empty($_POST['password'])) {

            $stmt = $conn->prepare('UPDATE admins SET usuario = ?, nombre = ?, editado = NOW() WHERE id_admin = ?');
            $stmt->bind_param("ssi", $usuario, $nombre, $id_registro);
        } else {
            $opciones = array(
                'cost' => 12
            );
            $hash_password = password_hash($password, PASSWORD_BCRYPT, $opciones);
            $stmt = $conn->prepare('UPDATE admins SET usuario = ?, nombre = ?, password = ?, editado = NOW() WHERE id_admin = ?');
            $stmt->bind_param("sssi", $usuario, $nombre, $hash_password, $id_registro);
        }

        $stmt->execute();

        if ($stmt->affected_rows) {

            $respuesta = array(
                'respuesta' => 'exito',
                'id_actualizado' => $stmt->insert_id
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

        $stmt = $conn->prepare("DELETE FROM admins WHERE id_admin = ? ");
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



