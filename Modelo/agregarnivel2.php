<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "corapeor_repositorio";
// Create connection
$conn = mysqli_connect($servername, $username, $password,$database);
mysqli_query($conn,"SET NAMES 'UTF-8'");
if ($conn->connect_error) {
    die("ERROR: No se puede conectar al servidor: " . $conn->connect_error);
  } 



//para insertar info
  // Escape user inputs for security
  //$nombre = mysqli_real_escape_string($conn, $_REQUEST['ipn']);
  $n2nombre = trim(utf8_decode($_REQUEST['ipn']));
  $tipo = trim(utf8_decode($_REQUEST['ipt']));
  $n2tipo="Pueblo";
  $concat=$n2tipo." ".$n2nombre;
  
  $rest = mysqli_query($conn, "SELECT MAX(documento_categoria_id) FROM x_documento_categoria;");
$resultadof = mysqli_fetch_array($rest);
$numero = intval($resultadof['MAX(documento_categoria_id)']);
$idnivel2 = $numero + 1;
  // Attempt insert query execution
  $sql = "SELECT * FROM x_documento_categoria WHERE documento_categoria_nombre COLLATE UTF8_SPANISH_CI LIKE '%$tipo%';";
  $cosa=mysqli_query($conn,$sql);
  $resultado=mysqli_fetch_array($cosa);
  $idnivel1=intval($resultado['documento_categoria_id']);
  $subnivel="INSERT INTO x_documento_categoria (documento_categoria_id,documento_categoria_nombre,documento_categoria_padre_id) VALUES ('$idnivel2', '$concat', '$idnivel1')";
  if ($n2nombre == ""){
    echo '<script>
    alert("este campo no puede ir vacio");
    window.location.href="../Vista/html/nivel2.php";
   </script>';
  }else{
  if(mysqli_query($conn, $subnivel)){ 
    echo '<script>
    //alert("Registro guardado con exito");
    window.location.href="../Vista/html/nivel2.php";
   </script>'; 
      
  } else{
      echo "ERROR: Could not able to execute $subnivel. " . mysqli_error($conn);
  }
  }
?>