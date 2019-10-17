<?php
//DDRC declaracion de varibles usadas para la coneccion a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "corapeor_repositorio";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("ERROR: No se puede conectar al servidor: " . $conn->connect_error);
}
// usando variables para conectarse  y modificar datos de la base en mongodb
require '../vendor/autoload.php' ;
$uri="mongodb://Daniel:1234@localhost/baseprueba?ssl=false";
$client=new MongoDB\Client($uri);
$db = $client->baseprueba;
$coleccion = $db->categorias;


//variables  para capturar  info de losformularios
// ademas se crea varibles para obtener el id mas alto , lo que usara para crear un ciclo repetitivo e identificar el registro a ser editado
$nombre = trim(utf8_decode($_REQUEST['editname']));
$tipo = trim(mysqli_real_escape_string($conn, $_REQUEST['editkind']));
$concat=$tipo." ".$nombre;
$quedit = $_POST['valedit'];
//$numero = $res->num_rows;
$contador = 1;
$rest = mysqli_query($conn, "SELECT MAX(documento_categoria_id) FROM x_documento_categoria;");
$resultadof = mysqli_fetch_array($rest);
$numero = intval($resultadof['MAX(documento_categoria_id)']);

//primero pregunta si la variable nombre no fue enviado vacia o simplemente espacios en blanco si es asi muestra una advertencia
if ($nombre == ""){
  echo '<script>
  alert("este campo no puede ir vacio");
  window.location.href="../Vista/html/inicio.php";
 </script>';
}else{
  //crea un ciclo repetitivo que empieza en 1 y termina en el maximo valor + 1  que exista en el id
while ($contador <= $numero+1) {
  switch ($quedit) {//usa el switch para identificar cual registro se desea editar
    case 'editar' . $contador:
      // consultas query para la actualizacion del regiistro escogido     
        $mod = "UPDATE x_documento_categoria SET documento_categoria_nombre = '$concat'  WHERE documento_categoria_id = '$contador'";
      if (mysqli_query($conn, $mod) && $coleccion->updateOne(array("_id"=>$contador),array('$set'=>array("NombreTipo"=>$concat)))) {//si la consulta se realiza con exito se enviara a la pagina de inicio caso contrario se muestra un mensaje de error
        echo '<script>
    //alert("Registro editado con exito");
    window.location.href="../Vista/html/inicio.php";
   </script>';
      } else {
        echo "ERROR: Could not able to execute $mod. " . mysqli_error($conn);
      }
      break;
    }
  $contador++;//contador que aumenta hasta llegar al limite que es el numero mas alto en el campo id
}
}
?>