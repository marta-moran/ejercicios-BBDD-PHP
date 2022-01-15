<?php
class AccesoDatos {
    
    private static $modelo = null;
    private $dbh = null;
    private $stmt = null;
    
    //Aquí van las consultas
    private static $select0 = "SELECT CLIENTE_NO, NOMBRE FROM CLIENTES WHERE CLIENTES.CLIENTE_NO = ?";

    private static $select1 = "SELECT PEDIDOS.PEDIDO_NO, PEDIDOS.PRODUCTO_NO, PRODUCTOS.DESCRIPCION, PEDIDOS.UNIDADES, PRODUCTOS.PRECIO_ACTUAL FROM PEDIDOS, PRODUCTOS ". 
    "WHERE ( PEDIDOS.PRODUCTO_NO = PRODUCTOS.PRODUCTO_NO ) ".
    " AND (PEDIDOS.UNIDADES <= PRODUCTOS.STOCK_DISPONIBLE) ".
    " AND ( PEDIDOS.CLIENTE_NO = ?);";
    

    /*
    $select_disponibles = 

     SELECT P.PEDIDO_NO AS 'Nº PEDIDO', P.PRODUCTO_NO AS 'ID PRODUCTO', P.UNI
    DADES, PR.DESCRIPCION, PR.PRECIO_ACTUAL FROM PEDIDOS P INNER JOIN PRODUCTOS PR
    ON P.PRODUCTO_NO = PR.PRODUCTO_NO;"
    */
    
  
    
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

    //hay que hacer una consulta 0 que saque si el cliente existe o no para mandar un mensaje x la vista
    function checkCliente($cliente_no):bool {
        $stmt = $this->dbh->prepare(self::$select0);
        $stmt->bindValue(1,$cliente_no);
        if ( $stmt->execute() ){  
            return ($stmt->rowCount() > 0 );
        }
        return false;
    }


    public function consulta1 ($cliente_no):array{
        $resu = [];
        $stmt = $this->dbh->prepare(self::$select1);
        $stmt->bindValue(1,$cliente_no);
        // Devuelvo una tabla asociativa
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ( $stmt->execute() ){
            while ( $fila = $stmt->fetch()){
                $resu[]= $fila;
            }
        }
        return $resu;
    }


     // Evito que se pueda clonar el objeto.
    public function __clone()
    { 
        trigger_error('La clonación no permitida', E_USER_ERROR); 
    }
}

