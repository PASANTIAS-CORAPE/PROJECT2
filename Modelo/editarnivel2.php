<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "nuevo";
// Create connection
$conn = mysqli_connect($servername, $username, $password,$database);
if ($conn->connect_error) {
    die("ERROR: No se puede conectar al servidor: " . $conn->connect_error);
  } 



//para insertar info
  // Escape user inputs for security
  $nombre = utf8_decode($_REQUEST['editname']);
  $newnacpue = utf8_decode($_REQUEST['cambio']);
  $tipo = 'Pueblo';
  $quedit=$_POST['valedit'];
 
  //datosparalaconsulta y eliminaciion
$res= mysqli_query($conn,"select * from c_nivel2;");

$resultado=mysqli_fetch_array($res);
//$numero = $res->num_rows;
$contador=1;

$rest= mysqli_query($conn,"SELECT MAX(nivel2_id) FROM c_nivel2;");
$resultadof=mysqli_fetch_array($rest);
$numero = intval($resultadof['MAX(nivel2_id)']);

var_dump( $newnacpue);
//funcion para eliminar registros de una basede datos
//$refresh="alter table c_nivel1 auto_increment=1;";
while ($contador <= $numero) {
  switch ($quedit) {
  case 'editar'.$contador:
  $sql = mysqli_data_seek($res,$contador);
   // consultas query para la modificacion de datos
$mod = "UPDATE c_nivel2 SET nivel2_nombre = '$nombre' , nivel2_tipo = '$tipo' WHERE nivel2_id = '$contador'";
$mod1 = "UPDATE c_nivel2 SET nivel2_nombre = '$nombre' , nivel2_tipo = '$tipo', nivel1_id = $newnacpue WHERE nivel2_id = '$contador'";
echo $resultado['nivel1_id'];
if ($newnacpue != "") {
  if ($newnacpue != $resultado['nivel1_id']) {
    if(mysqli_query($conn,$mod1)){
      echo "<script>//alert('Registro editado con éxito');
  window.location.href='../Vista/html/nivel2.php';
  </script>";
      } else{
      echo "ERROR: Could not able to execute $mod. " . mysqli_error($conn);
      }
  } else {
    if(mysqli_query($conn,$mod)){
      echo "<script>//alert('Registro editado con éxito');
  window.location.href='../Vista/html/nivel2.php';
  </script>";
      } else{
      echo "ERROR: Could not able to execute $mod. " . mysqli_error($conn);
      }
  } 
} else {
  echo "<script>//alert('No puedes editar sin nacionalidad o pueblo');
  window.location.href='../Vista/html/nivel2.php';
  </script>";
}
    
  break;
  }
  $contador++;
}  

?>