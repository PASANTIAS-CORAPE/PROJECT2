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
$res= mysqli_query($conn,"select * from c_nivel1;");
$rest= mysqli_query($conn,"SELECT MAX(nivel1_id) FROM c_nivel1;");
//$sql = mysqli_data_seek($res,11);
$resultado=mysqli_fetch_array($res);
$resultadof=mysqli_fetch_array($rest);
$numero = intval($resultadof['MAX(nivel1_id)']);
$contador=1;
echo $numero;
echo$_POST['eliminar'];
//$res->num_rows
//funcion para eliminar registros de una basede datos
$refresh="alter table c_nivel1 auto_increment=1;";//estalinea es para que empieze desdeel menor numero existente el conteodel id
while ($contador <= $numero+1) {
  switch ($_POST['eliminar']) {
  case 'eliminar'.$contador:
  $eliminar="delete from c_nivel1 where nivel1_id=".$contador.";";
  mysqli_query($conn,$eliminar);
  //codigo para ordenar los valoresdel id despues deeliminar un registro
  //for ($i=$contador; $i <= max($resultado['nivel1_id']); $i++) { 
  //  $ordenar="UPDATE  c_nivel1 SET nivel1_id='$i' WHERE nivel1_id >'$contador';";
  //  mysqli_query($conn,$ordenar); 
  //}
    mysqli_query($conn,$refresh);
   echo '<script>
   alert("Registro eliminado con exito");
  </script>';
  header('Location: ../Vista/html/trab.php');
  break;
  }
  $contador++;
}
  ?>