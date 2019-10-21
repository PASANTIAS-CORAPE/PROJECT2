<?php
//declaracion de varibles para conectarse a la DB
$servername = "localhost";
$username = "root";
$password = "";
$database = "corapeor_repositorio";
// Crea la connection
$conn = mysqli_connect($servername, $username, $password,$database);
// pregunta si hay un error al conectaarse y lo nuestra si existiese
if ($conn->connect_error) {
    die("ERROR: No se puede conectar al servidor: " . $conn->connect_error);
  }

// usando variables para conectarse  y modificar datos de la base en mongodb
require '../vendor/autoload.php';
$uri="mongodb://Daniel:1234@localhost/baseprueba?ssl=false";
$client=new MongoDB\Client($uri);
$db = $client->baseprueba;
$coleccion = $db->categorias;
?>