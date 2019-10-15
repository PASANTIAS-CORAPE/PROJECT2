<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "corapeor_repositorio";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("ERROR: No se puede conectar al servidor: " . $conn->connect_error);
}



//variables  para capturar  info de losformularios
// Escape user inputs for security
$nombre = trim(utf8_decode($_REQUEST['editname']));
$tipo = trim(mysqli_real_escape_string($conn, $_REQUEST['editkind']));
$concat=$tipo." ".$nombre;
$quedit = $_POST['valedit'];


//$numero = $res->num_rows;
$contador = 1;
$rest = mysqli_query($conn, "SELECT MAX(documento_categoria_id) FROM x_documento_categoria;");
$resultadof = mysqli_fetch_array($rest);
$numero = intval($resultadof['MAX(documento_categoria_id)']);

//funcion para eliminar registros de una basede datos
//$refresh="alter table c_nivel1 auto_increment=1;";
if ($nombre == ""){
  echo '<script>
  alert("este campo no puede ir vacio");
  window.location.href="../Vista/html/inicio.php";
 </script>';
}else{
while ($contador <= $numero+1) {
  switch ($quedit) {
    case 'editar' . $contador:
      // consultas query para la modificacion      
        $mod = "UPDATE x_documento_categoria SET documento_categoria_nombre = '$concat'  WHERE documento_categoria_id = '$contador'";
      if (mysqli_query($conn, $mod)) {
        echo '<script>
    //alert("Registro editado con exito");
    window.location.href="../Vista/html/inicio.php";
   </script>';
      } else {
        echo "ERROR: Could not able to execute $mod. " . mysqli_error($conn);
      }
      break;
    }
  $contador++;
}
}
?>