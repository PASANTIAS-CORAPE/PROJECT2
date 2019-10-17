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
//datos para la consulta y eliminaciion
$rest = mysqli_query($conn, "SELECT MAX(documento_categoria_id) FROM x_documento_categoria;");
$resultadof = mysqli_fetch_array($rest);
$numero = intval($resultadof['MAX(documento_categoria_id)']);
$contador=1;
// usando variables para conectarse  y modificar datos de la base en mongodb
require '../vendor/autoload.php' ;
$uri="mongodb://Daniel:1234@localhost/baseprueba?ssl=false";
$client=new MongoDB\Client($uri);
$db = $client->baseprueba;
$coleccion = $db->categorias;

//funcion para eliminar registros de una basede datos
//$refresh="alter table c_nivel1 auto_increment=1;";//estalinea es para que empieze desdeel menor numero existente el conteodel id
// se crea un ciclo repetitivo y se usa el comando switch para identificar que registro se desea eliminar, para lo cual se usa un query.
while ($contador <= $numero+1) {
  switch ($_POST['eliminar']) {
  case 'eliminar'.$contador:
  $coleccion->deleteOne(array("_id"=>$contador));
  $eliminar="DELETE FROM x_documento_categoria where documento_categoria_id=".$contador.";";
  mysqli_query($conn,$eliminar);

    //mysqli_query($conn,$refresh);
   echo '<script>
   //alert("Registro eliminado con exito");
   window.location.href="../Vista/html/inicio.php";
  </script>';
  break;
  }
  $contador++;
}
  ?>