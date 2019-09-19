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

       //codigo para hacer la busqueda
$palabraabuscar=utf8_encode($_POST['palabra']);
$busqueda="select * from c_nivel1 
where nivel1_nombre COLLATE UTF8_SPANISH_CI like '%$palabraabuscar%' 
or nivel1_id = '$palabraabuscar'
or nivel1_tipo COLLATE UTF8_SPANISH_CI like '%$palabraabuscar%'";
$respuesta=mysqli_query($conn,$busqueda);
$resultado1=mysqli_fetch_array($respuesta);


foreach ($conn->query($busqueda) as $row) 
  {  
      print utf8_encode($row['nivel1_id']) . "\t";
      print utf8_encode($row['nivel1_nombre']) . "\t";
      print utf8_encode($row['nivel1_tipo']) . "\t";
      echo("  <br>");
  
  }
       ?>