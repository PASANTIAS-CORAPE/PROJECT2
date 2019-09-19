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



//para insertar info
  // Escape user inputs for security
  $nombre = mysqli_real_escape_string($conn, $_REQUEST['ipn']);
  $tipo = utf8_decode($_REQUEST['ipt']);
  $n2tipo="Pueblo";
  $res= mysqli_query($conn,"select * from c_nivel2;");

  // Attempt insert query execution
  $sql = "SELECT * FROM c_nivel1 WHERE nivel1_nombre COLLATE UTF8_SPANISH_CI LIKE '%$tipo%';";
  $cosa=mysqli_query($conn,$sql);
  $resultado=mysqli_fetch_array($cosa);
  $idnivel1=intval($resultado['nivel1_id']);
  $subnivel="INSERT INTO c_nivel2 (nivel2_nombre, nivel2_tipo, nivel1_id) VALUES ('$nombre', '$n2tipo', '$idnivel1')";

  if(mysqli_query($conn, $subnivel)){ 
    echo '<script>
    alert("Registro guardado con exito");
   </script>'; 
      header('Location: ../html/trab2.php');
  } else{
      echo "ERROR: Could not able to execute $subnivel. " . mysqli_error($conn);
  }

?>