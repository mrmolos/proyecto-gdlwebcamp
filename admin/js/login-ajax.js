$(document).ready(function(){

    //INICIO DE SESION
    $('#login-admin').on('submit', function (e) {
        //Prevenir que al pulsar el boton no nos mande al archivo php "insertar-admin"
        e.preventDefault();

        //Capturar los datos del formulario
        var datos = $(this).serializeArray();
        //console.log(datos);

        //Ajax en jquery
        $.ajax({
            type: $(this).attr('method'), //Pilla el metodo. En este caso POST
            data: datos,
            url: $(this).attr('action'), //Pilla la url de insertar-admin. Ver en codigo del formulario
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exitoso') {
                    Swal.fire(
                        'WELCOME!',
                        'Bienvenido ' + resultado.usuario + '!',
                        'success'
                    )
                    setTimeout(function () {
                        window.location.href = 'admin-area.php';
                    }, 2000);
                } else {
                    Swal.fire(
                        'ERROR!',
                        'Usuario o Contraseña incorrectos',
                        'error'
                    )
                }
            }
        });


    });


});