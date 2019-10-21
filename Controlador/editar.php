<?php
require('../Modelo/conecciones.php');

//variables  para capturar  info de losformularios
// ademas se crea varibles para obtener el id mas alto , lo que usara para crear un ciclo repetitivo e identificar el registro a ser editado
$nombre = trim(utf8_decode($_REQUEST['editname']));
$tipo = trim(mysqli_real_escape_string($conn, $_REQUEST['editkind']));
$concat=$tipo." ".$nombre;
$quedit = $_POST['valedit'];
//$numero = $res->num_rows;
$contador = 1;
$rest = mysqli_query($conn, "SELECT MAX(documento_categoria_id) FROM x_documento_categoria;");
$resultadof = mysqli_fetch_array($rest);
$numero = intval($resultadof['MAX(documento_categoria_id)']);

//primero pregunta si la variable nombre no fue enviado vacia o simplemente espacios en blanco si es asi muestra una advertencia
if ($nombre == ""){
  echo '<script>
  alert("este campo no puede ir vacio");
  window.location.href="../Vista/inicio.php";
 </script>';
}else{
  //crea un ciclo repetitivo que empieza en 1 y termina en el maximo valor + 1  que exista en el id
while ($contador <= $numero+1) {
  switch ($quedit) {//usa el switch para identificar cual registro se desea editar
    case 'editar' . $contador:
      // consultas query para la actualizacion del regiistro escogido     
        $mod = "UPDATE x_documento_categoria SET documento_categoria_nombre = '$concat'  WHERE documento_categoria_id = '$contador'";
      if (mysqli_query($conn, $mod) && $coleccion->updateOne(array("_id"=>$contador),array('$set'=>array("NombreTipo"=>utf8_encode($concat))))) {//si la consulta se realiza con exito se enviara a la pagina de inicio caso contrario se muestra un mensaje de error
        echo '<script>
    //alert("Registro editado con exito");
    window.location.href="../Vista/inicio.php";
   </script>';
      } else {
        echo "ERROR: Could not able to execute $mod. " . mysqli_error($conn);
      }
      break;
    }
  $contador++;//contador que aumenta hasta llegar al limite que es el numero mas alto en el campo id
}
}
?>