<?php

function productos_json(&$boletos, &$camisas = 0, &$etiquetas = 0){
  //Esta funcion devuelve los productos comprados en formato json
      $dias = array(
        0=>'un_dia', 
        1=>'pase_2dias', 
        2=>'pase_completo'
        );
        //Eliminamos el precio del array
        unset($boletos['un_dia']['precio']);
        unset($boletos['dos_dias']['precio']);
        unset($boletos['completo']['precio']);
        



      $total_boletos = array_combine($dias, $boletos); //ESTA FUNCION SUSTITUYE LAS LLAVES DE BOLETOS POR LOS VALORES DE DIAS
      
      

      $camisas = (int) $camisas;
      if($camisas > 0):
        $total_boletos['camisas'] = $camisas;
      endif;

      $etiquetas = (int) $etiquetas;
      if($etiquetas > 0):
        $total_boletos['etiquetas'] = $etiquetas;
      endif;


      return json_encode($total_boletos); // retorna los datos en el formato de json
}

function eventos_json(&$eventos){
  //Esta funcion retorna una lista de los eventos seleccionados en formato json
  $eventos_json = array();

  foreach ($eventos as $evento) {
    $eventos_json['eventos'][] = $evento;
  }
  return json_encode($eventos_json);
}
