<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "corapeor_repositorio";



// Create connection
$conn = mysqli_connect($servername, $username, $password,$database);
if ($conn->connect_error) {
    die("ERROR: No se puede conectar al servidor: " . $conn->connect_error);
  } 
//datosparalaconsulta y eliminaciion
$res= mysqli_query($conn,"select * from c_nivel2;");
$sql = mysqli_data_seek($res,11);
$resultado=mysqli_fetch_array($res);
//$numero = $res->num_rows;
$contador=1;
$rest= mysqli_query($conn,"SELECT MAX(documento_categoria_id) FROM x_documento_categoria;");
$resultadof=mysqli_fetch_array($rest);
$numero = intval($resultadof['MAX(documento_categoria_id)']);

//funcion para eliminar registros de una basede datos
$refresh="alter table c_nivel2 auto_increment=1;";//estalinea es para que empieze desdeel menor numero existente el conteodel id
while ($contador <= $numero) {
  switch ($_POST['eliminar']) {
  case 'eliminar'.$contador:
  $eliminar="DELETE FROM x_documento_categoria where documento_categoria_id=".$contador.";";
   mysqli_query($conn,$eliminar);
    mysqli_query($conn,$refresh);
   echo '<script>
   //alert("Registro eliminado con exito");
   window.location.href="../Vista/html/nivel2.php";
  </script>';
  break;
  }
  $contador++;
}
  ?>