<?php
require_once('Cliente.php');
require_once('Pedido.php');
require_once('AccesoDatos.php');

$connection = AccesoDatos::initModelo();

$cliente = $connection->getClient($_GET['nombre'], $_GET['clave']);

$orders = $connection->getClientOrders($cliente->getCodCliente());

include_once "vistaPedidos.php";