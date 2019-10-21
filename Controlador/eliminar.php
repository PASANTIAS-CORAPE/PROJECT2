<?php
require('../Modelo/conecciones.php');
//datos para la consulta y eliminaciion
$rest = mysqli_query($conn, "SELECT MAX(documento_categoria_id) FROM x_documento_categoria;");
$resultadof = mysqli_fetch_array($rest);
$numero = intval($resultadof['MAX(documento_categoria_id)']);
$contador=1;
$cnt=0;



//funcion para eliminar registros de una basede datos
//$refresh="alter table c_nivel1 auto_increment=1;";//estalinea es para que empieze desdeel menor numero existente el conteodel id
// se crea un ciclo repetitivo y se usa el comando switch para identificar que registro se desea eliminar, para lo cual se usa un query.
while ($contador <= $numero+1) {
  switch ($_POST['eliminar']) {
  case 'eliminar'.$contador:
  $eliminar="DELETE FROM x_documento_categoria where documento_categoria_id=".$contador.";";
    $coleccion->deleteOne(array("_id"=>$contador));
    mysqli_query($conn,$eliminar);
    $edicion=mysqli_query($conn,"SELECT * FROM x_documento_categoria WHERE documento_categoria_padre_id=$contador");
$resultado=mysqli_fetch_array($edicion);
$maximo=$edicion->num_rows;
  if ($resultado==NULL) {
echo '<script>
//alert("Registro eliminado con exito");
window.location.href="../Vista/inicio.php";
</script>';
break;
  } else {
    while($cnt<$maximo){
      $resultado=mysqli_fetch_array($edicion);
      $sql = mysqli_data_seek($edicion,$cnt);
      //echo $resultado['documento_categoria_padre_id']."<br>";
      //echo $resultado['documento_categoria_id']."<br>";
      //echo $resultado['documento_categoria_nombre']."<br>";
      //echo $contador." ".$cnt."<br><br>";
      $renivelar="UPDATE x_documento_categoria SET documento_categoria_padre_id = NULL WHERE documento_categoria_id = $resultado[documento_categoria_id]";
      mysqli_query($conn,$renivelar);
      $coleccion->updateMany(array("_id"=>$resultado['documento_categoria_id']),array('$set'=>array("padreId"=>0)));
       
   $cnt++;
      }
      echo '<script>
      //alert("Registro eliminado con exito");
      window.location.href="../Vista/inicio.php";
     </script>';    
  }
  }
  $contador++;
}

  ?>



