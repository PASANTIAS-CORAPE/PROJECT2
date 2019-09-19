

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
  
  
  
  // $result = $conn->query("SELECT * FROM c_nivel1");
  
  // echo "Numero de resultados: $result->num_rows";
  
  // $conn->query("SELECT nivel1_id, nivel1_nombre, nivel1_tipo FROM c_nivel1 ORDER BY nivel1_id");
  
  
  
  $sql = 'SELECT nivel1_id, nivel1_nombre, nivel1_tipo FROM c_nivel1 ORDER BY nivel1_id';
  foreach ($conn->query($sql) as $row) 
  {
  
      print utf8_encode($row['nivel1_id']) . "\t";
      print utf8_encode($row['nivel1_nombre']) . "\t";
      print utf8_encode($row['nivel1_tipo']) . "\t";
      echo("  <br>");
  
  }
  
  //$result->close();
  
  $conn->close();
  
  ?>
<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "nuevo";
$conn = mysqli_connect($servername, $username, $password,$database);
// Check connection

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully <br><br>";

//codigo para hacer la busqueda
$palabraabuscar=utf8_encode($_POST['palabra']);
$busqueda="select * from c_nivel1 
where nivel1_nombre COLLATE UTF8_SPANISH_CI like '%$palabraabuscar%' 
or nivel1_id = '$palabraabuscar'
or nivel1_tipo COLLATE UTF8_SPANISH_CI like '%$palabraabuscar%'";
$respuesta=mysqli_query($conn,$busqueda);
$resultado1=mysqli_fetch_array($respuesta);


// $sql = "INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	20	,'sepillin','Pueblo')";
$res= mysqli_query($conn,"select * from c_nivel1;");
$sql = mysqli_data_seek($res,11);
$resultado=mysqli_fetch_array($res);
$numero = $res->num_rows;
$contador=1;



foreach ($conn->query($busqueda) as $row) 
  {  
      print utf8_encode($row['nivel1_id']) . "\t";
      print utf8_encode($row['nivel1_nombre']) . "\t";
      print utf8_encode($row['nivel1_tipo']) . "\t";
      echo("  <br>");
  
  }


echo $_POST['pyn'];

foreach ($_POST as $clave => $valor) {
  echo "la pos del array  ".$clave." el valor de la posicion   ".$valor."<br>";
}


//for ($i=$contador; $i <= $numero; $i++) { 
  //$ordenar="update c_nivel1 set nivel1_id=".$i;
  //mysqli_query($conn,$ordenar);
 //}
  

$conn->close();
?>







