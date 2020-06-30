<?php

//LOGIN DE USUARIO ADMINISTRADOR
if (isset($_POST['login-admin'])) {

    //Añadiendo los inputs
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    try {
        include_once 'funciones/funciones.php';
        $stmt = $conn->prepare("SELECT * FROM admins WHERE usuario = ?;");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();

        //Asignamos todos los valores de la bd
        $stmt->bind_result($id_admin, $usuario_admin, $nombre_admin, $password_admin, $editado, $nivel);
        if ($stmt->affected_rows) {
            //Imprimimos los valores en una variable
            $existe = $stmt->fetch();
            if ($existe) {
                //verificar contraseña
                if (password_verify($password, $password_admin)) {
                    //Inicio de sesion
                    session_start();
                    $_SESSION['usuario'] = $usuario_admin;
                    $_SESSION['nombre'] = $nombre_admin;
                    $_SESSION['nivel'] = $nivel;
                    $_SESSION['id'] = $id_admin;

                    //asignacion de respuesta para validar el login
                    $respuesta = array(
                        'respuesta' => 'exitoso',
                        'usuario' => $nombre_admin
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error'
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
        }
        //Cerrar conexiones     
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error:" .  $e->getMessage();
    }

    die(json_encode($respuesta));
}