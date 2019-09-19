<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-type" content="text/html">
    <script src="../js/jquery-2.1.4.js"></script>
    <link rel="stylesheet" href="../css/estilo.css">
    <title>Document</title>
</head>

<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "nuevo";
// Crea la connection
$conn = mysqli_connect($servername, $username, $password,$database);
// pregunta si hay un error al conectaarseylo nuestra 
if ($conn->connect_error) {
    die("ERROR: No se puede conectar al servidor: " . $conn->connect_error);
  }
  // creavariables de busques en consultas con sql y punteros
  $res= mysqli_query($conn,"select * from c_nivel1;");
  $numero = $res->num_rows;
  $contador=1; 
  $respt= mysqli_query($conn,"SELECT * FROM c_nivel2");
  $numero1 = $respt->num_rows;
$cont=1; 
  $conn->close();
?>

<body >
    <div id="cabezera">
        <img src="../img/logo-corape-web-repositorio.png" alt="logo">
        <center>
        <h1 >Administración de datos</h1>
    </center>
    </div>

    <center>
    <div id="cuerpo"> 
    <a href="#popup"><input type="button" name="Añadir" id="Añadir" value="Añadir" ></a>&emsp;&emsp;
    <a href="trab2.php"><input type="button" id="Añadir" value="Nivel  2" ></a>&emsp;&emsp;
    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    <label for="searchterm" id="buscar">Buscar:</label> <input id="searchTerm" type="text" onkeyup="doSearch()" name="palabra">
      
       
        <br><br>

        <div id="tabladecomtenidos">
        
            <table border="1" id="regTable" name="tablainfo">
                <tr class="tablatitulo">
                    <th>
                        Número
                    </th>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Nacionalidad / Pueblo
                    </th>
                    <th colspan="2">
                        Acciones
                    </th>
                </tr>
                
                
                <?php
                //codigo para llenar la tabla html con informacion de las tablas de mysql
                while ($contador <= $numero){   
                    $resultado=mysqli_fetch_array($res);
                    $sql = mysqli_data_seek($res,$contador);
    echo "<tr class='tablacontenido'>";  
    echo "<td>".$resultado['nivel1_id']."</td>";  
    echo "<td>".utf8_encode($resultado['nivel1_nombre'])."</td>";  
    echo "<td>".$resultado['nivel1_tipo']."</td>";  
    echo "<td>".'<a href="#popup1"> <button value="editar'.$contador.'" name="editar" id="Editar" onclick="editdatos.value=this.value;">Editar</button></a>'."</td>";  
    echo "<td>".'<form action="../php/eliminar.php" method="post"><button value="eliminar'.$contador.'" name="eliminar" id="Eliminar">Eliminar</button></form>'."</td>"; 
    echo "</tr>";  
    $contador++;
} ?> 
            </table>
        </div>
        </center>

    </div>
    <div id="popup" class="overlay">
            <div id="popupBody">
                <h2>Añadir contenido</h2>
                <a id="cerrar" href="#">&times;</a>
                <div class="popupContent">
                    <form action="../php/agregar.php" method="POST" >
                        <table>
                            <tr>
                                <td>
                   <label for="inputnombre">Nombre:</label>
                                </td>
                       <td> 
                    <input type="text" id="inputnombre" name="ipn" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ]{4,30}" title="solo puede ingresar texto, de entre 4 y 30 caracteres" required >
                    </td>
                    </tr>
                    
                    <tr>
                    <td>
                   <label for="inputtipo">Nacionalidad/Pueblo:</label>
                   </td> 
                   <td>                       
                    <select id="inputTipo" name="ipt">
                        <option>Nacionalidad</option>
                        <option>Pueblo</option>
                    </select>
                    </td>
                    </tr>
                    </table>
                    <br>
                    <label for="opcion">Tiene elementos de nivel 2</label> &emsp;
                    <label for="opcion">SI</label>
                    <input type="radio" name="opcion" id="si" onclick="Inputnombre2.disabled=false;">
                    <label for="opcion">NO</label>
                    <input type="radio" name="opcion" id="no" onclick="Inputnombre2.disabled=true;">
                    
                    <br><br>
                    <label for="inputnombre">Pueblos:</label>
                    <br>
                    <datalist  id="addpueblo">                    
                    <?php
                        while ($cont <= $numero1){  
                            $resul=mysqli_fetch_array($respt);
                            $sql1 = mysqli_data_seek($respt,$cont);
            echo "<option>".utf8_encode($resul['nivel2_nombre'])."</option>";  
                             $cont++;
                         } 
                        ?>
                    </datalist>           
                    <input type="text" list="addpueblo"  name="pyn" id="Inputnombre2" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ]{4,30}" title="solo puede ingresar texto, de entre 4 y 30 caracteres" disabled  autocomplete="off" >
                    <br><br>
                    <button type="submit">Guardar</button>
                </form>
                </div>
            </div>
         </div>

         <div id="popup1" class="overlay">
                <div id="popupBody">
                    <h2>Editar contenido</h2>
                    <a id="cerrar" href="#">&times;</a>
                    <div class="popupContent">
                        <form action="../php/editar.php" method="post">
                        <input type="text"  id="editdatos" name="valedit" style="display:none">
                            <table>
                                <tr>
                                    <td>
                       <label for="inputNombre">Nombre:</label>
                       </td> 
                       <td>
                        <input type="text" id="InputNombre" name="editname" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ]{4,30}" title="solo puede ingresar texto, de entre 4 y 30 caracteres" required>
                        </td>
                        </tr>
                        <br><br>
                        <tr>
                            <td>
                       <label for="imputTipo">Nacionalidad/Pueblo:</label> 
                       </td>
                       <td>
                        
                        <select id="InputTipo" name="editkind">
                        <option>Nacionalidad</option>
                        <option>Pueblo</option>
                    </select>
                        </td>
                        </tr>
                    </table>
                        <br><br>
                        <button>Guardar</button>
                    </form>
                    </div>
                </div>
             </div>


</body>
<script src="../js/archivo.js"></script>
<script src="../js/buscar.js"></script>
</html>