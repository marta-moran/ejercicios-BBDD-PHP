<?php
/*
 * Acceso a datos con BD y Patrón Singleton
 * Aquí van las consultas
 */
class AccesoDatos
{

    private static $modelo = null; //para instanciar el constructor
    private $dbh = null; //variable para la conexion a la bd
    private $stmt = null; //variable statement que almacena la consulta

    //consultas sql que utilizaré en las funciones
    private static $getClientQuery = "SELECT * FROM clientes WHERE nombre = ? AND clave = ?";
    private static $getClientOrders = "SELECT * FROM pedidos WHERE cod_cliente = ?";
    private static $updateClientTimes = "UPDATE clientes SET veces = veces+1 WHERE nombre = ?";


    //función que sirve para instanciar una sola vez el objeto y que así este sea el mismo siempre
    public static function initModelo()
    {
        if (self::$modelo == null) { //si modelo es null creo un nuevo AccesoDatos
            self::$modelo = new AccesoDatos();
        }
        return self::$modelo; //si no es nulo devuelvo el modelo
    }

    private function __construct() //conexión a la BD, siempre es igual
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

    //consulta para obtener si el cliente está en la BD 
    public function getClient($nombre, $clave) //pasamos los parámetros cogidos en el formulario
    {
        $this->updateClientTimes($nombre); //aprovechamos para actualizar las vaces que ha entrado en la BD
        
        $stmt = $this->dbh->prepare(self::$getClientQuery); //guardamos la consulta en una variable

        $stmt->bindParam(1, $nombre); //se pasa el param nombre
        $stmt->bindParam(2, $clave);

        $stmt->execute(); //para ejecutar la consulta

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { //fetch: devuelve un solo registro en un array asociativo

            $client = new Cliente(); //creo el objeto cliente que tendrá los atributos de la BD que coincida con lo introducido en el formulario

            $client->setCodCliente($row['cod_cliente']); //le atribuyo los valores que tenga ese registro en la tabla clientes
            $client->setNombre($row['nombre']); //si metí eva por form esto será eva
            $client->setVeces($row['veces']); //3
            $client->setClave($row['clave']); //secretoeva

            return $client; //retorno el cliente con todos sus atributos
        }
    }

    public function getClientOrders($codCliente) //función que muestra todos los pedidos de un cliente especifico
    {
        $stmt = $this->dbh->prepare(self::$getClientOrders); //consulta preparada (evita inyecciones)

        $stmt->bindParam(1, $codCliente); //se le asocia un parámetro (código del cliente)

        $stmt->execute(); //ejecuta

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll devuelve todas las filas coincidentes con el where del array
        //en este caso mostrará todos los pedidos de eva
        $orders = []; //se crea un array para almacenar

        foreach ($result as $item) { //foreach para almacenar los valores que devuelva la bd
            $order = new Pedido(); //se crea un nuevo objeto Pedido

            $order->setNumPed($item['numped']); //a Pedido se le asigan el numero de pedido que haya en la BD
            $order->setCodCliente($item['cod_cliente']); // se le asigna el cod_cliente que haya en la bd
            $order->setPrecio($item['precio']);
            $order->setProducto($item['producto']);

            array_push($orders, $order); //meto el nuevo Pedido con todos sus atributos
            //el primer parametro es al array al que voy a meter el elemento y el segundo el elemento
        }

        return $orders;//retorno el array de pedidos que serán todos los pedidos que haya hecho el cliente
    }

    //funcion para incrementar las veces que entra el cliente a la BD. 
    //Se implementa en la función getClient() que es donde comprueba si existe el cliente en la BD
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
