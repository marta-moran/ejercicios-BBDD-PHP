<?php
include_once('accesoDatos.php');
$db = AccesoDatos::initModelo();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table,td,th {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <h1>CONSULTA Y PROCESAMIENTO DE PEDIDOS</h1>
    <form method="POST">
        <label for="">Indicar el código del cliente</label>
        <input type="number" name="cliente_no" size=10 value="1">
        <input type="submit" value="BUSCAR">
    </form>
</body>

<?php

    if ($_REQUEST['cliente_no'] == 1){
        verresu($db->consulta1(intval($_POST['cliente_no'])));
    }
/*
if (!empty($_POST['cliente_no']) && empty($_POST['procesar'])){
    $cliente_no = $_POST['cliente_no'];
    if (!$db->checkCliente($cliente_no)){
        echo "ERROR: El código de cliente no existe.</body></html>";
        exit;
    }
*/


function verresu ($datos){
    
    if ( count($datos) == 0){
        echo "<br>No hay resultados disponibles.<br>";
        return;   
    }
    
    echo "<table>";
    $cabecera=false;
    foreach ($datos as $fila){
        // Genero los campos de la caberas de la tabla
        if (!$cabecera){
            echo "<tr>";
            foreach($fila as $clave => $valor){
                echo "<th> $clave </th>";
            }
            echo "</tr>";
            $cabecera=true;
        }
        echo "<tr>";
        foreach($fila as $valor){
            echo "<td> $valor </td>";
        }
        echo "</tr>";
    }
    echo "</table>";
 }
?>

</html>