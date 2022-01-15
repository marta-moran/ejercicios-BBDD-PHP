<?php
//deben incluirse en orden. No se puede incluir AccesoDatos que tira de cliente y pedido antes que estos dos.
require_once('Cliente.php');
require_once('Pedido.php');
require_once('AccesoDatos.php');

/*
El operador :: es para métodos estáticos. Si lo voy a llamar desde el mismo fichero donde se ha creado 
el método lo hago con self:: si es fuera con el nombre del fichero que lo contenga y el nombre de la función
(como en este caso)
*/

/*

Para ejecutar las funciones que contienen consultas que se han hecho en acceso a datos en el controlador
1. variable de conexion a la BD = $connection en este caso
2. variable que almacene los resultados = $cliente
3. -> para implementar funciones sobre la variable $connection (es como el . en otros lenguajes)
4. función del fichero AccesoDatos que quiero ejecutar
*/

$connection = AccesoDatos::initModelo(); //se crea la conexión 

$cliente = $connection->getClient($_GET['nombre'], $_GET['clave']); //función que comprueba si existe el usuario en la bd

$orders = $connection->getClientOrders($cliente->getCodCliente()); //funcion que saca los pedidos que tenga ese cliente

include_once "vistaPedidos.php"; //después de todo esto incluye la vista pedidos. DEBE IR EN ORDEN