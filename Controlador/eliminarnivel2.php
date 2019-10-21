<?php
require('../Modelo/conecciones.php');

//datosparalaconsulta y eliminaciion
$res= mysqli_query($conn,"select * from c_nivel2;");
$sql = mysqli_data_seek($res,11);
$resultado=mysqli_fetch_array($res);
//$numero = $res->num_rows;
$contador=1;
$rest= mysqli_query($conn,"SELECT MAX(documento_categoria_id) FROM x_documento_categoria;");
$resultadof=mysqli_fetch_array($rest);
$numero = intval($resultadof['MAX(documento_categoria_id)']);

//funcion para eliminar registros de una basede datos
//anteriormente se usaban las siguientes lineas comentadas para que al eliminar eun registro el contador del id se reinicie
//$refresh="alter table c_nivel2 auto_increment=1;"; estalinea es para que empieze desdeel menor numero existente el conteodel id
//mediante el uso de un ciclo repetitivo y un comando de seleccion como lo es el switch se identifica el registro seleccionado para despues proceder con la eliminación 
while ($contador <= $numero) {
  switch ($_POST['eliminar']) {
  case 'eliminar'.$contador:
  $coleccion->deleteOne(array("_id"=>$contador));
  $eliminar="DELETE FROM x_documento_categoria where documento_categoria_id=".$contador.";";
   mysqli_query($conn,$eliminar);
    //mysqli_query($conn,$refresh);
   echo '<script>
   //alert("Registro eliminado con exito");
   window.location.href="../Vista/nivel2.php";
  </script>';
  break;
  }
  $contador++;
}
  ?>