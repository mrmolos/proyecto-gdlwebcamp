$(document).ready(function () {
    //PROCESOS USANDO AJAX

    //CREACION, Y EDICION DE REGISTRO
    $('#guardar-registro').on('submit', function (e) {
        //Prevenir que al pulsar el boton no nos mande al archivo php "insertar-admin"
        e.preventDefault();

        //Capturar los datos del formulario
        var datos = $(this).serializeArray();
        console.log('Muestra de los datos antes de enviarlos por ajax');
        console.log(datos);

        //Ajax en jquery
        $.ajax({
            type: $(this).attr('method'), //Pilla el metodo. En este caso POST
            data: datos,
            url: $(this).attr('action'), //Pilla atributo action. Ver en codigo del formulario
            dataType: 'json',
            success: function (data) {
                console.log("llamada a ajax exitosa");
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    Swal.fire(
                        'BOM TRABALHO!',
                        'Administrador guardado con éxito',
                        'success'
                    )
                } else {
                    Swal.fire(
                        'ERROR!',
                        'Hubo un problema',
                        'error'
                    )
                }
            }

        });


    });

    //EDICION DE REGISTRO CON INPUT FILE
    $('#guardar-registro-archivo').on('submit', function (e) {
        //Prevenir que al pulsar el boton no nos mande al archivo php "insertar-admin"
        e.preventDefault();

        //Capturar los datos del formulario
        var datos = new FormData(this);
        console.log('Conexion a archivo admin-ajax');
        console.log(datos);

        //Ajax en jquery
        $.ajax({
            type: $(this).attr('method'), //Pilla el metodo. En este caso POST
            data: datos,
            url: $(this).attr('action'), //Pilla atributo action. Ver en codigo del formulario
            dataType: 'json',
            contentType: false,// Estos atributos se añaden así para poder enviar archivos como
            processData: false,// imagenes
            async: true,//
            cache: false,// No cachea la url
            success: function (data) {
                console.log("llamada a ajax exitosa");
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    Swal.fire(
                        'BOM TRABALHO!',
                        'Administrador guardado con éxito',
                        'success'
                    )
                } else {
                    Swal.fire(
                        'ERROR!',
                        'Hubo un problema',
                        'error'
                    )
                }
            }

        });


    });


    //BORRAR REGISTRO DE ADMIN EVENTO Y CATEGORIA
    $('.borrar_registro').on('click', function (e) {
        e.preventDefault();

        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

        swal({
            title: '¿Estás seguro?',
            text: "Un registro eliminado no se puede recuperar",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: 'post',
                    data: {
                        id: id,
                        registro: 'eliminar'
                    },
                    url: 'modelo-' + tipo + '.php',
                    success: function (data) {
                        console.log(data);
                        var resultado = JSON.parse(data);
                        if (resultado.respuesta == 'exito') {
                            swal(
                                'Eliminado!',
                                'Registro Eliminado.',
                                'success'
                            )
                            jQuery('[data-id="' + resultado.id_eliminado + '"]').parents('tr').remove();
                            

                        } else {
                            swal(
                                'Error!',
                                'No se pudo eliminar',
                                'error'
                            )
                        }
                    }
                })
            }
        }
        );
    });








});