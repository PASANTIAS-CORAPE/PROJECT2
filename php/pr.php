
<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "test";



// Create connection
$conn = mysqli_connect($servername, $username, $password,$database);
if ($conn->connect_error) {
    die("ERROR: No se puede conectar al servidor: " . $conn->connect_error);
  } 
//datosparalaconsulta y eliminaciion
$res= mysqli_query($conn,"select * from c_nivel1;");
$sql = mysqli_data_seek($res,11);
$resultado=mysqli_fetch_array($res);
$numero = $res->num_rows;
$contador=1;

//funcion para eliminar registros de una basede datos
$refresh="alter table c_nivel1 auto_increment=1;";//estalinea es para que empieze desdeel menor numero existente el conteodel id

foreach ($res as $key => $value) {
  $mod = "UPDATE c_nivel1 SET nivel1_id = '$contador+1'  WHERE nivel1_id > '$contador'";
  mysqli_query($conn,$mod);
}
while ($contador <= $numero) {
  switch ($_POST['cositaid']) {
  case $contador:
  //echo 'este es el numero'.$contador;
  $eliminar="delete from c_nivel1 where nivel1_id=".$contador.";";
   mysqli_query($conn,$eliminar);
    mysqli_query($conn,$refresh);
    
   echo '<script>
   alert("Registro eliminado con exito");
  </script>';
  
  break;
  }
  $contador++;
}
  ?>
