<?php

//el bind value solo se utiliza cuando se pasa un parámetro por ? (o sea POST o GET)

/*
 * Acceso a datos con BD y Patrón Singleton
 */
class AccesoDatos {
    
    private static $modelo = null;
    private $dbh = null;
    private $stmt = null;
  
    private static $consulta1 = "SELECT * FROM PRODUCTOS where PRODUCTO_NO NOT IN "
                                ."(SELECT PRODUCTO_NO FROM PEDIDOS)";
    private static $consulta2 = "UPDATE PRODUCTOS SET PRECIO_ACTUAL = PRECIO_ACTUAL*0.9 WHERE PRODUCTO_NO = ?";
    
    public static function initModelo(){
        if (self::$modelo == null){
            self::$modelo = new AccesoDatos();
        }
        return self::$modelo;
    }
    
    private function __construct(){
        
        try {
            $dsn = "mysql:host=localhost;dbname=EMPRESA;charset=utf8";
            $this->dbh = new PDO($dsn, "root", "Root2323$");
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Error de conexión ".$e->getMessage();
            exit();
        }
      
    }
    
    public function getProductosSinPedidos() {
        $stmt = $this->dbh->prepare(self::$consulta1);

        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll devuelve todas las filas coincidentes con el where del array
        //en este caso mostrará todos los pedidos de eva
        $productos = []; //se crea un array para almacenar

        foreach ($result as $item) { //foreach para almacenar los valores que devuelva la bd
            $producto = new Producto(); //se crea un nuevo objeto Pedido

            $producto->setNumeroProducto($item['PRODUCTO_NO']); //a Pedido se le asigan el numero de pedido que haya en la BD
            $producto->setDescripcion($item['DESCRIPCION']); // se le asigna el cod_cliente que haya en la bd
            $producto->setPrecioActual($item['PRECIO_ACTUAL']);
            $producto->setStockDisponible($item['STOCK_DISPONIBLE']);

            array_push($productos, $producto); //meto el nuevo Pedido con todos sus atributos
            //el primer parametro es al array al que voy a meter el elemento y el segundo el elemento
        }

        return $productos;//retorno el array de pedidos que serán todos los pedidos que haya hecho el cliente
    }

    public function actualizarPrecios($productosNoActualizados) {

        $stmt = $this->dbh->prepare(self::$consulta2);

        $stmt->bindParam(1, $productosNoActualizados);

        $stmt->execute();

    }

     // Evito que se pueda clonar el objeto.
    public function __clone()
    { 
        trigger_error('La clonación no permitida', E_USER_ERROR); 
    }
}
