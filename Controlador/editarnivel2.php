<?php
require('../Modelo/conecciones.php');

//para insertar info
// Escape user inputs for security
$nombre = trim(utf8_decode($_REQUEST['editname']));
$newnacpue = trim(utf8_decode($_REQUEST['cambio']));
$tipo = 'Pueblo';
$concat = $tipo." ".$nombre;

$quedit = $_POST['valedit'];

//datosparalaconsulta y eliminaciion
$res = mysqli_query($conn, "SELECT * FROM corapeor_repositorio.x_documento_categoria  WHERE (x_documento_categoria.documento_categoria_padre_id IS  NULL) AND (documento_categoria_nombre = '$newnacpue');");

$resultado = mysqli_fetch_array($res);
//$numero = $res->num_rows;
$contador = 1;

$rest = mysqli_query($conn, "SELECT MAX(documento_categoria_id) FROM x_documento_categoria;");
$resultadof = mysqli_fetch_array($rest);
$numero = intval($resultadof['MAX(documento_categoria_id)']);
$idnivel2 = $numero + 1;

var_dump($newnacpue);
echo $newnacpue;
//se serciora de que no envien datos en blanco, si es asi muestra un mensaje de error y no lo es procede con la edicion
if ($nombre == ""){
  echo '<script>
  alert("este campo no puede ir vacio");
  window.location.href="../Vista/nivel2.php";
 </script>';
}else{
while ($contador <= $numero+1) {
  switch ($quedit) {
    case 'editar' . $contador:
    //la siguiente linea es un puntero que sirve para localizar un resultado dentro de una lista
      $sql = mysqli_data_seek($res, $contador);
      // consultas query para la edicion de datos en la DB
      $mod1 = "UPDATE x_documento_categoria SET documento_categoria_nombre = '$concat', documento_categoria_padre_id = '$resultado[documento_categoria_id]' WHERE documento_categoria_id = '$contador'";
      if ($newnacpue != "") {//pregunta se la variable newnacpue fue enviado sin un valor, si es asi muestra un mensaje de error,si no es asi procede con la edicion del registro en la DB
          if (mysqli_query($conn, $mod1) && $coleccion->updateOne(array("_id"=>$contador),array('$set'=>array("NombreTipo"=>utf8_encode($concat), "padreId"=>$resultado['documento_categoria_id'])))) {
            echo "<script>//alert('Registro editado con éxito');
  window.location.href='../Vista/nivel2.php';
  </script>";
          } else {
            echo "ERROR: Could not able to execute $mod. " . mysqli_error($conn);
          } 
      } else {//se ejecuta un script si no se ingrso una nacionalidad o pueblo
        echo "<script>//alert('No puedes editar sin nacionalidad o pueblo');
  window.location.href='../Vista/nivel2.php';
  </script>";
      }

      break;
  }
  $contador++;
}
}
?>