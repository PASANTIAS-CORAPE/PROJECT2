<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "corapeor_repositorio";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("ERROR: No se puede conectar al servidor: " . $conn->connect_error);
}



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
//funcion para eliminar registros de una basede datos
if ($nombre == ""){
  echo '<script>
  alert("este campo no puede ir vacio");
  window.location.href="../Vista/html/nivel2.php";
 </script>';
}else{
while ($contador <= $numero+1) {
  switch ($quedit) {
    case 'editar' . $contador:
    //la siguiente linea es un puntero que sirve para localizar un resultado dentro de una lista
      $sql = mysqli_data_seek($res, $contador);
      // consultas query para la modificacion de datos
      $mod1 = "UPDATE x_documento_categoria SET documento_categoria_nombre = '$concat', documento_categoria_padre_id = '$resultado[documento_categoria_id]' WHERE documento_categoria_id = '$contador'";
      if ($newnacpue != "") {//pregunta si hay un valor ien la base de datos que sea igual al ingresado
          if (mysqli_query($conn, $mod1)) {
            echo "<script>//alert('Registro editado con éxito');
  window.location.href='../Vista/html/nivel2.php';
  </script>";
          } else {
            echo "ERROR: Could not able to execute $mod. " . mysqli_error($conn);
          } 
      } else {//se ejecuta un script si no se ingrso una nacionalidad o pueblo
        echo "<script>//alert('No puedes editar sin nacionalidad o pueblo');
  window.location.href='../Vista/html/nivel2.php';
  </script>";
      }

      break;
  }
  $contador++;
}
}
?>