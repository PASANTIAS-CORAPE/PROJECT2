<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "nuevo";
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
$quedit = $_POST['valedit'];

//datosparalaconsulta y eliminaciion
$res = mysqli_query($conn, "select * from c_nivel2;");

$resultado = mysqli_fetch_array($res);
//$numero = $res->num_rows;
$contador = 1;

$rest = mysqli_query($conn, "SELECT MAX(nivel2_id) FROM c_nivel2;");
$resultadof = mysqli_fetch_array($rest);
$numero = intval($resultadof['MAX(nivel2_id)']);

var_dump($newnacpue);
//funcion para eliminar registros de una basede datos

while ($contador <= $numero+1) {
  switch ($quedit) {
    case 'editar' . $contador:
      $sql = mysqli_data_seek($res, $contador);
      // consultas query para la modificacion de datos
      $mod = "UPDATE c_nivel2 SET nivel2_nombre = '$nombre' , nivel2_tipo = '$tipo' WHERE nivel2_id = '$contador'";
      $mod1 = "UPDATE c_nivel2 SET nivel2_nombre = '$nombre' , nivel2_tipo = '$tipo', nivel1_id = $newnacpue WHERE nivel2_id = '$contador'";
      
      if ($newnacpue != "") {//pregunta si hay un valor ien la base de datos que sea igual al ingresado
        if ($newnacpue != $resultado['nivel1_id']) {
          if (mysqli_query($conn, $mod1)) {
            echo "<script>//alert('Registro editado con éxito');
  window.location.href='../Vista/html/nivel2.php';
  </script>";
          } else {
            echo "ERROR: Could not able to execute $mod. " . mysqli_error($conn);
          }
        } else {//si no es asi ejecuta una query distinto
          if (mysqli_query($conn, $mod)) {
            echo "<script>//alert('Registro editado con éxito');
  window.location.href='../Vista/html/nivel2.php';
  </script>";
          } else {
            echo "ERROR: Could not able to execute $mod. " . mysqli_error($conn);
          }
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
