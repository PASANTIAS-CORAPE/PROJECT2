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
//datosparalaconsulta y eliminaciion
$res= mysqli_query($conn,"select * from c_nivel2;");
$sql = mysqli_data_seek($res,11);
$resultado=mysqli_fetch_array($res);
$numero = $res->num_rows;
$contador=1;

//funcion para eliminar registros de una basede datos
$refresh="alter table c_nivel2 auto_increment=1;";//estalinea es para que empieze desdeel menor numero existente el conteodel id
while ($contador <= $numero) {
  switch ($_POST['eliminar']) {
  case 'eliminar'.$contador:
  $eliminar="delete from c_nivel2 where nivel2_id=".$contador.";";
   mysqli_query($conn,$eliminar);
    mysqli_query($conn,$refresh);
   echo '<script>
   alert("Registro eliminado con exito");
  </script>';
  header('Location: ../html/trab2.php');
  break;
  }
  $contador++;
}
  ?>