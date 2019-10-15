<?php
header("content-type: text/html; charset=utf-8");

//declara variables para la coneccona la basedebatos
$servername = "localhost";
$username = "root";
$password = "";
$database = "corapeor_repositorio";
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
//consultas mysql para agreagr a las tablas 
$sql = "INSERT INTO x_documento_categoria (documento_categoria_id,documento_categoria_nombre) VALUES ('$idnivel2', '$concat')";



//condicional para saber si envian variales vacias y paraverificarsilos datos de nivel 2 se repiteno no
//pregunta si la variables existe o esta vacia

echo $concat;

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
    //pregunta si la consulta resultado que busca coincidencias del nombre escrito en la tabla de nivel2 devolvio un valor o noy actualiza los registros si devolvio un resultdo ddistinto de nulo
    if ($resultado == null) {
      $subnivel = "INSERT INTO x_documento_categoria (documento_categoria_id,documento_categoria_nombre,documento_categoria_padre_id) VALUES ('$idnueva', '$concat1', '$idnivel2')";
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
      $subnivel2 = "UPDATE x_documento_categoria SET documento_categoria_padre_id='$idnivel2' WHERE documento_categoria_id=" . $resultado['documento_categoria_id'];
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
