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



//variables  para capturar  info de losformularios
  // Escape user inputs for security
  $nombre = mysqli_real_escape_string($conn, $_REQUEST['editname']);
  $tipo = mysqli_real_escape_string($conn, $_REQUEST['editkind']);
  $quedit=$_POST['valedit'];
 
  //datosparalaconsulta y eliminaciion
$res= mysqli_query($conn,"select * from c_nivel1;");
$sql = mysqli_data_seek($res,11);
$resultado=mysqli_fetch_array($res);
$numero = $res->num_rows;
$contador=1;




//funcion para eliminar registros de una basede datos
//$refresh="alter table c_nivel1 auto_increment=1;";

    while ($contador <= $numero) {
        switch ($quedit) {
        case 'editar'.$contador:
      echo "el numero de esta cosa es: ".$contador;
         // consultas querypara la modificacion
  $mod = "UPDATE c_nivel1 SET nivel1_nombre = '$nombre' , nivel1_tipo = '$tipo' WHERE nivel1_id = '$contador'";

  if(mysqli_query($conn,$mod)){
    header('Location:  ../html/trab.php');
    
} else{
    echo "ERROR: Could not able to execute $mod. " . mysqli_error($conn);
}
        break;
        }
        $contador++;
      }    
?>