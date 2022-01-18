<?php
//se debe incluir primero la clase
include_once('Producto.php');
include_once('AccesoDatos.php');
$productos = AccesoDatos::initModelo();

if (isset($_POST['actualizar']) && isset($_POST['seleccionar'])) {
    if (isset($_COOKIE["preciosActualizados"])) {
        $msg = " Solo se puede hacer una rebaja al día ";
    } else {
        setcookie("preciosActualizados", date("Y-m-d H:i:s"), time() + 3600 * 24); //para guardar la fecha de creación
        $productosNoActualizados = $_POST["seleccionar"];
        $productos->actualizarPrecios($productosNoActualizados);
    }
}

$listaProductos = $productos->getProductosSinPedidos();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            width: 600px
        }
    </style>
</head>

<body>
    <form method="POST" action="consulta.php">
        <?php if (isset($msg)) {
            echo $msg;
        }
        ?>
        <table>
            <tr>
                <th></th>
                <th>no</th>
                <th>descripción producto</th>
                <th>precio</th>
                <th>stock</th>
            </tr>
            <?php
            foreach ($listaProductos as $producto) { ?>
                <tr>
                    <td><input type="checkbox" name="seleccionar[]" value="<?php echo $producto->getNumeroProducto() ?>"></td>
                    <td><?php echo $producto->getNumeroProducto() ?></td>
                    <td><?php echo $producto->getDescripcion() ?></td>
                    <td><?php echo $producto->getPrecioActual() ?></td>
                    <td><?php echo $producto->getStockDisponible() ?></td>
                </tr>
            <?php
            } ?>
        </table>
        <input type="submit" name="actualizar" value="ACTUALIZAR">
    </form>
</body>

</html>