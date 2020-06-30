<?php
try {
  require_once('includes/funciones/bd_conexion.php');
  $sql = "SELECT * FROM `invitados` ";

  $resultado = $conn->query($sql);
} catch (\Exception $e) {
  echo $e->getMessage();
}

?>
<h1>Aprendiendo a extraer información de la base de datos</h1>

<div id="Introduccion">
<p>El objetivo de esta página es aprender a usar las diferentes funciones fetch de php para extraer y mostrar en pantalla los datos de nuestra base</p>
<p>en esta página se usa la tabla de invitados de la bd de gdlwebcamp</p>
</div>

<div id="fetchall">
  <h3>fetch_all()</h3>
  <p>Extrae todas las filas y las muestra como un array asociativo</p>
  <div style="border:2px solid black;">
    <?php $mostrar = $resultado->fetch_all(MYSQLI_ASSOC);?>
    <pre><?php var_dump($mostrar); ?></pre>
  </div>

</div>
<div id="fetcharray">
  <h3>fetch_array()</h3>
  <p>Extrae una fila como un array asociativo, un array numérico o ambos</p>
  <div style="border:2px solid black;">


<?php while ($mostrar2 = $resultado->fetch_array(MYSQLI_ASSOC)) {
  echo $mostrar2;
} ?>




  </div>

</div>


<div style="border:2px solid black;">

</div>  <div style="border:2px solid black;">

  </div>  <div style="border:2px solid black;">

    </div>  <div style="border:2px solid black;">

      </div>

      <?php $conn->close(); ?>
