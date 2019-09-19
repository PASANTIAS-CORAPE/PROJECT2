<?php
header("content-type: text/html; charset=utf-8");

//declara variables para la coneccona la basedebatos
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "nuevo";
// Create connection
$conn = mysqli_connect($servername, $username, $password,$database);
mysqli_query($conn,"SET NAMES 'UTF-8'");
if ($conn->connect_error) {
    die("ERROR: No se puede conectar al servidor: " . $conn->connect_error);
  } 



//variables para capturar infor macion del formulario
  // Escape user inputs for security
  $nombre = utf8_decode($_REQUEST['ipn']);
  $tipo = mysqli_real_escape_string($conn, $_REQUEST['ipt']);
  $n2nombre = mysqli_real_escape_string($conn, $_REQUEST['pyn']);
  $n2tipo="Pueblo";
  $res= mysqli_query($conn,"select * from c_nivel1;");
  $resp1= mysqli_query($conn,"select * from c_nivel2 where nivel2_nombre='$n2nombre';");
  $resultado=mysqli_fetch_array($resp1);
  $numero = $res->num_rows;
$idnivel2=$numero+1;
  // Attempt insert query execution
  //consultas mysql para agreagr a las tablas 
  $sql = "INSERT INTO c_nivel1 (nivel1_nombre, nivel1_tipo) VALUES ('$nombre', '$tipo')";
  $subnivel="INSERT INTO c_nivel2 (nivel2_nombre, nivel2_tipo, nivel1_id) VALUES ('$n2nombre', '$n2tipo', '$idnivel2')";


  //condicional para saber si envian variales vacias y paraverificarsilos datos de nivel 2 serepiteno no

    if ($n2nombre=="" || !isset($n2nombre)) {
        if(mysqli_query($conn, $sql)){ 
            echo '<script>
            alert("Registro guardado con exito");
           </script>'; 
           header('Location: ../html/trab.php');
          } else{
              echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
          } 
    }else{
      if ($resp1==false) {
        if(mysqli_query($conn, $sql) && mysqli_query($conn, $subnivel)){ 
          echo '<script>
          alert("Registro guardado con éxito");
         </script>'; 
            header('Location: ../html/trab.php');
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
      }else {
        $subnivel2="UPDATE c_nivel2 SET nivel1_id='$idnivel2' WHERE nivel2_id=".$resultado['nivel2_id'];
        if(mysqli_query($conn, $sql) && mysqli_query($conn, $subnivel2)){ 
          echo '<script>
          alert("Registro guardado con éxito");
         </script>'; 
            header('Location: ../html/trab.php');
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
      }
        
    } 
   

?>