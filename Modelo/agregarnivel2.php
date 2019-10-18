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

// usando variables para conectarse  y modificar datos de la base en mongodb
require '../vendor/autoload.php' ;
$uri="mongodb://Daniel:1234@localhost/baseprueba?ssl=false";
$client=new MongoDB\Client($uri);
$db = $client->baseprueba;
$coleccion = $db->categorias;


//para insertar info y variables para la correcta ejecucion de los cilos repetitivos
  $n2nombre = trim(utf8_decode($_REQUEST['ipn']));
  $tipo = trim(utf8_decode($_REQUEST['ipt']));
  $n2tipo="Pueblo";
  $concat=$n2tipo." ".$n2nombre;
  $rest = mysqli_query($conn, "SELECT MAX(documento_categoria_id) FROM x_documento_categoria;");
$resultadof = mysqli_fetch_array($rest);
$numero = intval($resultadof['MAX(documento_categoria_id)']);
$idnivel2 = $numero + 1;


  // crea una query que regresa las coincidencias del campo nombre con la variable tipo
  $sql = "SELECT * FROM x_documento_categoria WHERE documento_categoria_nombre COLLATE UTF8_SPANISH_CI LIKE '%$tipo%';";
  $cosa=mysqli_query($conn,$sql);
  $resultado=mysqli_fetch_array($cosa);
  $idnivel1=intval($resultado['documento_categoria_id']);
  $sql1 = "SELECT * FROM x_documento_categoria WHERE documento_categoria_nombre COLLATE UTF8_SPANISH_CI LIKE '%$n2nombre%';";
  $cosa1=mysqli_query($conn,$sql1);
  $resultado1=mysqli_fetch_array($cosa1);
  $idnivel10=intval($resultado1['documento_categoria_id']);
  $subnivel="INSERT INTO x_documento_categoria (documento_categoria_id,documento_categoria_nombre,documento_categoria_padre_id) VALUES ('$idnivel2', '$concat', '$idnivel1')";
  $subnivel1="UPDATE x_documento_categoria SET documento_categoria_padre_id='$idnivel1' WHERE documento_categoria_id=" . $idnivel10;

  $documento = array( 
    "_id" => $idnivel2, 
    "NombreTipo" => utf8_encode($concat), 
    "padreId" => $idnivel1
  );

 //var_dump($resultado1);
 
 if ($n2nombre == ""){//pregunta si la variable n2nombre fue enviada sin valor si es asi muestra un mensaje de error, si no es asi procede a crear un nuevo registro
  echo '<script>
  alert("este campo no puede ir vacio");
  window.location.href="../Vista/html/nivel2.php";
 </script>';
}else if ($resultado1==null) {
if(mysqli_query($conn, $subnivel) && $coleccion->insertOne($documento)){ 
  echo '<script>
  //alert("Registro guardado con exito");
  window.location.href="../Vista/html/nivel2.php";
 </script>'; 
    
} else{
    echo "ERROR: Could not able to execute $subnivel. " . mysqli_error($conn);
}
}else {
if(mysqli_query($conn, $subnivel1) && $coleccion->updateOne(array("_id"=>$idnivel10),array('$set'=>array("padreId"=>$idnivel1)))){ 
  echo '<script>
  //alert("Registro guardado con exito");
  window.location.href="../Vista/html/nivel2.php";
 </script>'; 
    
} else{
    echo "ERROR: Could not able to execute $subnivel. " . mysqli_error($conn);
}
}
?>