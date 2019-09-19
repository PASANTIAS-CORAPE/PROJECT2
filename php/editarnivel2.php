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
  $nombre = mysqli_real_escape_string($conn, $_REQUEST['editname']);
  $tipo = 'Pueblo';
  $quedit=$_POST['valedit'];
 
  //datosparalaconsulta y eliminaciion
$res= mysqli_query($conn,"select * from c_nivel2;");
$sql = mysqli_data_seek($res,11);
$resultado=mysqli_fetch_array($res);
$numero = $res->num_rows;
$contador=1;




//funcion para eliminar registros de una basede datos
//$refresh="alter table c_nivel1 auto_increment=1;";

    while ($contador <= $numero) {
        switch ($quedit) {
        case 'editar'.$contador:
         // consultas query para la modificacion de datos
  $mod = "UPDATE c_nivel2 SET nivel2_nombre = '$nombre' , nivel2_tipo = '$tipo' WHERE nivel2_id = '$contador'";
 
  if(mysqli_query($conn,$mod)){

    header('Location:  ../html/trab2.php');
    
} else{
    echo "ERROR: Could not able to execute $mod. " . mysqli_error($conn);
}
        break;
        }
        $contador++;
      }    
?>