<?php

//el bind value solo se utiliza cuando se pasa un parámetro por ? (o sea POST o GET)

/*
 * Acceso a datos con BD y Patrón Singleton
 * Aquí van las consultas
 */
class AccesoDatos
{

    private static $modelo = null;
    private $dbh = null;
    private $stmt = null;

    private static $getClientQuery = "SELECT * FROM clientes WHERE nombre = ? AND clave = ?";
    private static $getClientOrders = "SELECT * FROM pedidos WHERE cod_cliente = ?";
    private static $updateClientTimes = "UPDATE clientes SET veces = veces+1 WHERE nombre = ?";


    public static function initModelo()
    {
        if (self::$modelo == null) {
            self::$modelo = new AccesoDatos();
        }
        return self::$modelo;
    }

    private function __construct()
    {

        try {
            $dsn = "mysql:host=localhost;dbname=etienda;charset=utf8";
            $this->dbh = new PDO($dsn, "root", "Root2323$");
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión " . $e->getMessage();
            exit();
        }
    }

    public function getClient($nombre, $clave)
    {
        $this->updateClientTimes($nombre);
        
        $stmt = $this->dbh->prepare(self::$getClientQuery);

        $stmt->bindParam(1, $nombre);
        $stmt->bindParam(2, $clave);

        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $client = new Cliente();

            $client->setCodCliente($row['cod_cliente']);
            $client->setNombre($row['nombre']);
            $client->setVeces($row['veces']);
            $client->setClave($row['clave']);

            return $client;
        }
    }

    public function getClientOrders($codCliente)
    {
        $stmt = $this->dbh->prepare(self::$getClientOrders);

        $stmt->bindParam(1, $codCliente);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $orders = [];

        foreach ($result as $item) {
            $order = new Pedido();

            $order->setNumPed($item['numped']);
            $order->setCodCliente($item['cod_cliente']);
            $order->setPrecio($item['precio']);
            $order->setProducto($item['producto']);

            array_push($orders, $order);
        }

        return $orders;
    }

    public function updateClientTimes($nombre) {
        $stmt = $this->dbh->prepare(self::$updateClientTimes);

        $stmt->bindParam(1, $nombre);

        $stmt->execute();
    }



    // Evito que se pueda clonar el objeto.
    public function __clone()
    {
        trigger_error('La clonación no permitida', E_USER_ERROR);
    }
}
