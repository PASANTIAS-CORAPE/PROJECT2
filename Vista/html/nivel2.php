<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../../Modelo/jquery-2.1.4.js"></script>
    <link rel="stylesheet" href="../css/estilo.css">
    <title>CORAPE</title>
</head>

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
  // crea variables de busqueda usando consultas con sql, ademas crea varibles que permitiran llenar tabla de html y demas
  $res= mysqli_query($conn,"SELECT * FROM corapeor_repositorio.x_documento_categoria  WHERE (x_documento_categoria.documento_categoria_padre_id IS not  NULL) AND ((documento_categoria_nombre LIKE 'Pueblo %'));");
  $respt= mysqli_query($conn,"SELECT * FROM corapeor_repositorio.x_documento_categoria  WHERE (x_documento_categoria.documento_categoria_padre_id IS NULL) AND (documento_categoria_nombre LIKE 'Nacionalidad %');");
  //la siguiente line y las lineas que usen esta varibles estan comentadas por que no lograron satisfacer los requerimiento ded mostrar el nombre de el registro padre de los registro de nivel2
  //$result=mysqli_query($conn,"SELECT * FROM corapeor_repositorio.x_documento_categoria  WHERE (x_documento_categoria.documento_categoria_padre_id IS NULL) AND documento_categoria_id = ANY(select documento_categoria_padre_id from corapeor_repositorio.x_documento_categoria where x_documento_categoria.documento_categoria_padre_id IS not NULL);");
  $numero = $res->num_rows;
  $numero1 = $respt->num_rows;
  $contador=1; 
  $cont=1; 
  
  $conn->close();
?>

<body>
    <div id="cabezera">
        <img src="../img/logo-corape-web-repositorio.png" alt="logo">  
    
    <center>
        <h1>
        
            Administración de Nivel 2
        </h1>
        </center>
        </div>
    <center>
    <div id="cuerpo"> 
               <a href="inicio.php"><input type="button" id="retorno" value="Nivel 1"></a>  &emsp;&emsp;
       <a href="#popup"><input type="button" name="Añadir" id="Añadir" value="Añadir" ></a>&emsp;&emsp;
       <label for="searchterm" id="buscar">Buscar:</label> <input id="searchTerm" type="text" onkeyup="doSearch()" />
        <br><br>
        <div id="tabladecomtenidos">
            <table border="1" id="regTable">
                <tr class="tablatitulo">
                    
                    <th>
                        Número
                    </th>
                    <th>
                        Pueblo
                    </th>
                    <th>
                        Nacionalidad
                    </th>
                    <th colspan="2">
                        Acciones
                    </th>
                </tr>
                <?php
                //codigo para llenar la tabla html con informacion de las tablas de mysql
                while ($contador <= $numero){   
                    //las siguientes dos lineas son para la conversion de los resultados de la consultas(en un principio un objeto) a un array y tambien un puntero para desplazarse entre los elemnetos del array mensionado anteriormente
                    //PSD: las siguientes lineas de php puro son para rellenar o bien tablas o select o tambien datalist.
                    $resultado=mysqli_fetch_array($res);
                    $sql = mysqli_data_seek($res,$contador);
                    $cnt=0;
    echo "<tr class='tablacontenido'>";  
    echo "<td>".$contador."</td>";  
    echo "<td>".utf8_encode($resultado['documento_categoria_nombre'])."</td>";
    while($cnt<=$numero+1){
        $resultado2=mysqli_fetch_array($respt);
        $sql2 = mysqli_data_seek($respt,$cnt);
        if ($resultado['documento_categoria_padre_id']==$resultado2['documento_categoria_id']) {
            echo "<td>".$resultado2['documento_categoria_nombre']."</td>";
            break;
        } else if($cnt==$numero){
            echo "<td>Sin Nacionalidad</td>"; 
            break;
        }
        $cnt++;
    }
    echo "<td>".'<a href="#popup1"> <button value="editar'.$resultado['documento_categoria_id'].'" name="editar" id="Editar" onclick="editdatos.value=this.value;">Editar</button></a>'."</td>";  
    echo "<td>".'<form action="../../Modelo/eliminarnivel2.php" method="post"><button value="eliminar'.$resultado['documento_categoria_id'].'" name="eliminar" id="Eliminar">Eliminar</button></form>'."</td>"; 
    echo "</tr>";  
    $contador++;
} ?> 
            </table>
        </div>
        </center>
    </div>

    </div>
    <div id="popup" class="overlay">
            <div id="popupBody">
                <h2>Añadir contenido</h2>
                <a id="cerrar" href="#">&times;</a>
                <div class="popupContent">
                    <form action="../../Modelo/agregarnivel2.php" method="POST" >
                        <table>
                            <tr>
                                <td>
                   <label for="inputnombre">Nombre:</label>
                                </td>
                       <td> 
                    <input type="text" id="inputnombre" name="ipn" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ]{2,30}" title="solo puede ingresar texto, de entre 2 y 30 caracteres" required autocomplete="off">
                    </td>
                    </tr>
                    
                    <tr>
                    <td>
                   <label for="inputtipo">A que Nacionalidad pertenece:</label>
                   </td> 
                   <td>
                    <select id="inputTipo" name="ipt">
                        <?php
                        while ($cont <= $numero1){   
                            $resultado1=mysqli_fetch_array($respt);
                            $sql1 = mysqli_data_seek($respt,$cont);
            echo "<option>".utf8_encode($resultado1['documento_categoria_nombre'])."</option>";             
            $cont++;
        } 
        $cont=0;
                        ?>
                    </select>
                    </td>
                    </tr>
                    </table>
                    <br><br>
                    <button type="submit">Guardar</button>
                    <a href="#"><input type="button" value="Cancelar" style="font-size:18px"></a>
                </form>
                </div>
            </div>
         </div>

         <div id="popup1" class="overlay">
                <div id="popupBody">
                    <h2>Editar contenido</h2>
                    <a id="cerrar" href="#">&times;</a>
                    <div class="popupContent">
                        <form action="../../Modelo/editarnivel2.php" method="post">
                        <input type="text"  id="editdatos" name="valedit" style="display:none">
                        <center>
                            <table>
                                <tr>
                                    <td>
                       <label for="inputNombre">Nombre:</label>
                       </td> 
                       <td>
                        <input type="text" id="InputNombre" name="editname" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ]{2,30}" title="solo puede ingresar texto, de entre 2 y 30 caracteres" required autocomplete="off">
                        </td>
                        </tr>
                        <tr>
                        <td>
                       <label>Nacionalidad:</label>
                       </td>                                       
                        <td>
                        <select name="cambio" id="inputTipo" required>
                        <?php
                        while ($cont <= $numero1){   
                            $resultado1=mysqli_fetch_array($respt);
                            $sql1 = mysqli_data_seek($respt,$cont);
                            //value=$resultado1[documento_categoria_nombre]     utf8_encode($resultado1['documento_categoria_nombre'])
            echo "<option >".utf8_encode($resultado1['documento_categoria_nombre'])."</option>";             
            $cont++;
        } 
                        ?>
                        </select>
                        </td>
                        </tr>
                    </table>
                    </center>
                        <br><br>
                        <button>Guardar</button>
                        <a href="#"><input type="button" value="Cancelar" style="font-size:18px"></a>
                    </form>
                    </div>
                </div>
             </div>

</body>
<script src="../../Modelo/buscar.js"></script>

</html>