<?php
header("content-type: text/html; charset=utf-8");

//declara variables para la coneccion a la basedebatos
$servername = "localhost";
$username = "root";
$password = "";
$database = "corapeor_repositorio";
// usando variables para conectarse  y modificar datos de la base en mongodb
require '../vendor/autoload.php' ;
$uri="mongodb://Daniel:1234@localhost/baseprueba?ssl=false";
$client=new MongoDB\Client($uri);
$db = $client->baseprueba;
$coleccion = $db->categorias;


// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
mysqli_query($conn, "SET NAMES 'UTF-8'");
if ($conn->connect_error) {
  die("ERROR: No se puede conectar al servidor: " . $conn->connect_error);
}



//variables para capturar informacion del formulario
// ademas se crea varibles con el que permiten obtener el valor mas alto del campo id
$nombre = trim(utf8_decode($_REQUEST['ipn']));
$tipo = mysqli_real_escape_string($conn, $_REQUEST['ipt']);
$concat=$tipo." ".$nombre;
$n2nombre = trim(utf8_decode($_REQUEST['pyn']));
$n2tipo = "Pueblo";
$concat1=$n2tipo." ".$n2nombre;
$res = mysqli_query($conn, "select * from c_nivel1;");
$resp1 = mysqli_query($conn, "SELECT * FROM x_documento_categoria where documento_categoria_nombre='$n2nombre';");
$resultado = mysqli_fetch_array($resp1);
$rest = mysqli_query($conn, "SELECT MAX(documento_categoria_id) FROM x_documento_categoria;");
$resultadof = mysqli_fetch_array($rest);
$numero = intval($resultadof['MAX(documento_categoria_id)']);
$idnivel2 = $numero + 1;
$idnueva = $idnivel2 + 1;
// Attempt insert query execution
//consultas mysql para agreagar a las tablas 
$sql = "INSERT INTO x_documento_categoria (documento_categoria_id,documento_categoria_nombre) VALUES ('$idnivel2', '$concat')";
//define el registro a ingresar en la base de datos en mongodb
//DDRC el utf8_encode permite guardar caracteres especiales en la base de de datos no relacional(MongoDB), al igual que en la base de datosrelacional (MySQL) se usa en cambi el utf8_decode
$documento = array( 
  "_id" => $idnivel2, 
  "NombreTipo" => utf8_encode($concat), 
  "padreId" => 0
);
$documento1 = array( 
  "_id" => $idnueva, 
  "NombreTipo" => utf8_encode($concat1), 
  "padreId" => $idnivel2
);

//condicional para saber si envian variales vacias y para verificar si los datos de nivel 2 se repiteno no
//pregunta si la variables existe o esta vacia

if ($nombre == "") {
  echo '<script>
  alert("este campo no puede ir vacio");
  window.location.href="../Vista/html/inicio.php";
 </script>';
} else {
  if ($n2nombre == "" && $nombre !="") {
    if (mysqli_query($conn, $sql) && $coleccion->insertOne($documento)) {//ejecuta un query que solo guarda el nombre nacinalida y id para los registros de primer nivel
      echo '<script>
      alert("Registro guardado con exito \n PSD:si intento guardar registros en blanco en el nivel 2, estos no se crearan");
      window.location.href="../Vista/html/inicio.php";
     </script>';
    } else {
      echo "ERROR: Could not able to execute $coleccion. " . mysqli_error($client);
    }
  } else {
    //pregunta si la consulta resultado que busca coincidencias del nombre escrito en la tabla de nivel2 devolvio un valor o noy actualiza los registros si devolvio un resultdo ddistinto de nulo
    if ($resultado == null) {
      $subnivel = "INSERT INTO x_documento_categoria (documento_categoria_id,documento_categoria_nombre,documento_categoria_padre_id) VALUES ('$idnueva', '$concat1', '$idnivel2')";
      if (mysqli_query($conn, $sql) && mysqli_query($conn, $subnivel) && $coleccion->insertOne($documento) && $coleccion->insertOne($documento1)) {
        echo '<script>
    //alert("Registro guardado con éxito");
    window.location.href="../Vista/html/inicio.php";
   </script>';
      } else {
        echo "ERROR: Could not able to execute  $subnivel. " . mysqli_error($conn);
      }
    } else {
      //si resp1 devolvio un valor ejecuta una query distintaa que guarda el nuevo registro que hayamos puesto
      $subnivel2 = "UPDATE x_documento_categoria SET documento_categoria_padre_id='$idnivel2' WHERE documento_categoria_id=" . $resultado['documento_categoria_id'];
      if (mysqli_query($conn, $sql) && mysqli_query($conn, $subnivel2) && $coleccion->insertOne($documento) && $coleccion->updateOne(array("_id"=>$resultado['documento_categoria_id']),array('$set'=>array("padreId"=>$idnivel2)))) {
        echo '<script>
    //alert("Registro guardado con éxito");
    window.location.href="../Vista/html/inicio.php";
   </script>';
      } else {
        echo "ERROR: Could not able to execute  $subnivel2. " . mysqli_error($conn);
      }
    }
  }
}
?>
