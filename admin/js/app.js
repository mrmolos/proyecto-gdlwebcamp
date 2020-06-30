$(document).ready(function () {

  //Date picker
  $('#fecha').datepicker({
    autoclose: true
  })
  //Initialize Select2 Elements
  $('.seleccionar').select2()
  //Timepicker
  $('.hora_evento').timepicker({
    showInputs: false
  })
  //icheck
  $('input[type="checkbox"].minimal').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_square-blue',
    
  });

  //Activar navegacion interactiva
  $('.sidebar-menu').tree();
  //Activar tablas
  $('#registros').DataTable({
    'paging': true,
    'pageLength': 10,
    'lengthChange': false,
    'searching': true,
    'ordering': true,
    'info': true,
    'autoWidth': false,
    'language': {
      paginate: {
        next: 'Siguiente',
        previous: 'Anterior',
        last: 'Último',
        first: 'Primero'
      },
      info: 'Mostrando desde _START_ a _END_ de _TOTAL_ resultados',
      emptyTable: 'Ningún resultado',
      infoEmpty: '0 registros mostrados',
      search: 'Buscar: '
    }
  });

  //Deshabilitar boton de submit
  $('#crear-registro_admin').attr('disabled', true);


  $('#repetir_password').on('input', function () {

    var password_nuevo = $('#password').val();

    if ($(this).val() == password_nuevo) {
      $('#resultado_password').text('Correcto');
      $('#resultado_password').parents('.form-group').addClass('has-success').removeClass('has-error');
      $('input#password').parents('.form-group').addClass('has-success').removeClass('has-error');
      $('#crear-registro').attr('disabled', false);
    } else {
      $('#resultado_password').text('La contraseña debe coincidir');
      $('#resultado_password').parents('.form-group').addClass('has-error').removeClass('has-success');
      $('input#password').parents('.form-group').addClass('has-error').removeClass('has-success');
    }


  });


$('#icono').iconpicker();

//Grafia admin registrados
$.getJSON('servicio-registrado.php', function(data){
  console.log(data);
  var line = new Morris.Line({
    element: 'grafica-registro',
    resize: true,
    data: data,
    xkey: 'fecha',
    ykeys: ['cantidad'],
    labels: ['Registrados'],
    lineColors: ['#3c8dbc'],
    hideHover: 'auto'
  });
});





  //Final del código
})
