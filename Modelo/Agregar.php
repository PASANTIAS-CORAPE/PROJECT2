<?php
header("content-type: text/html; charset=utf-8");

//declara variables para la coneccona la basedebatos
$servername = "localhost";
$username = "root";
$password = "";
$database = "nuevo";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
mysqli_query($conn, "SET NAMES 'UTF-8'");
if ($conn->connect_error) {
  die("ERROR: No se puede conectar al servidor: " . $conn->connect_error);
}



//variables para capturar infor macion del formulario
// Escape user inputs for security
$nombre = trim(utf8_decode($_REQUEST['ipn']));
$tipo = mysqli_real_escape_string($conn, $_REQUEST['ipt']);
$n2nombre = trim(utf8_decode($_REQUEST['pyn']));
$n2tipo = "Pueblo";
$res = mysqli_query($conn, "select * from c_nivel1;");
$resp1 = mysqli_query($conn, "select * from c_nivel2 where nivel2_nombre='$n2nombre';");
$resultado = mysqli_fetch_array($resp1);
$rest = mysqli_query($conn, "SELECT MAX(nivel1_id) FROM c_nivel1;");
$resultadof = mysqli_fetch_array($rest);
$numero = intval($resultadof['MAX(nivel1_id)']);
$idnivel2 = $numero + 1;
// Attempt insert query execution
//consultas mysql para agreagr a las tablas 
$sql = "INSERT INTO c_nivel1 (c_nivel1.nivel1_nombre, c_nivel1.nivel1_tipo) VALUES ('$nombre', '$tipo')";



//condicional para saber si envian variales vacias y paraverificarsilos datos de nivel 2 se repiteno no
//pregunta si la variables existe o esta vacia


var_dump($resultado);
echo"<br><br>\n";
var_dump($resp1);

if ($resultado != null) {
  echo "se escribio algo que si estaba en el nivel 2";
} else {
  echo "se escribio algo que no estaba en el nivel 2";
}
if ($nombre == "") {
  echo '<script>
  alert("este campo no puede ir vacio");
  window.location.href="../Vista/html/inicio.php";
 </script>';
} else {
  if ($n2nombre == "" && $nombre !="") {
    if (mysqli_query($conn, $sql)) {
      echo '<script>
      alert("Registro guardado con exito \n PSD:si intento guardar registros en blanco en el nivel 2, estos no se crearan");
      window.location.href="../Vista/html/inicio.php";
     </script>';
    } else {
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
  } else {
    //pregunta si la consulta res1 devolvio un valor o noy actualiza los registros si de
    if ($resultado == null) {
      $subnivel = "INSERT INTO c_nivel2 (c_nivel2.nivel2_nombre, c_nivel2.nivel2_tipo, c_nivel2.nivel1_id) VALUES ('$n2nombre', '$n2tipo', '$idnivel2')";
      if (mysqli_query($conn, $sql) && mysqli_query($conn, $subnivel)) {
        echo '<script>
    //alert("Registro guardado con éxito");
    window.location.href="../Vista/html/inicio.php";
   </script>';
      } else {
        echo "ERROR: Could not able to execute  $subnivel. " . mysqli_error($conn);
      }
    } else {
      //si resp1 devolvio un valor ejecuta una query distintaa que guarda el nuevo registro que hayamos puesto
      $subnivel2 = "UPDATE c_nivel2 SET c_nivel2.nivel1_id='$idnivel2' WHERE c_nivel2.nivel2_id=" . $resultado['nivel2_id'];
      if (mysqli_query($conn, $sql) && mysqli_query($conn, $subnivel2)) {
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
