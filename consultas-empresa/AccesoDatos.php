<?php

//el bind value solo se utiliza cuando se pasa un parámetro por ? (o sea POST o GET)

/*
 * Acceso a datos con BD y Patrón Singleton
 */
class AccesoDatos {
    
    private static $modelo = null;
    private $dbh = null;
    private $stmt = null;
    
    // Auxiliar para genera el formulario
    private static $select0 = " SELECT CLIENTE_NO, NOMBRE FROM CLIENTES";
        
    //Mostrar productos con precio superior un valor ordenado por descripción.
    private static $select1 = "select * from PRODUCTOS where PRECIO_ACTUAL >= ? ORDER BY DESCRIPCION ";
    
    // Mostrar Total de pedidos y unidades pedidas por producto 
    private static $select2 = "SELECT COUNT(PEDIDOS.PEDIDO_NO) AS 'PEDIDOS TOTALES', PEDIDOS.UNIDADES, PRODUCTOS.DESCRIPCION  FROM PEDIDOS  INNER JOIN PRODUCTOS ON PEDIDOS.PRODUCTO_NO = PRODUCTOS.PRODUCTO_NO GROUP BY PEDIDOS.UNIDADES, PRODUCTOS.DESCRIPCION;";

    // Mostrar el departamento con mayor número de empleados.
    private static $select3 = "SELECT DEPARTAMENTOS.DNOMBRE, COUNT(EMPLEADOS.EMP_NO) AS 'TOTAL EMPLEADOS' FROM DEPARTAMENTOS  INNER JOIN EMPLEADOS  ON DEPARTAMENTOS.DEP_NO = EMPLEADOS.DEP_NO GROUP BY DEPARTAMENTOS.DNOMBRE ORDER BY COUNT(EMPLEADOS.EMP_NO) DESC LIMIT 1;";
    // Mostrar Código y apellido de TODOS los empleados y ciudad donde trabajan.
    private static $select4 = "SELECT E.EMP_NO AS 'ID EMPLEADO', E.APELLIDO, D.LOCALIDAD FROM EMPLEADOS E INNER JOIN DEPARTAMENTOS D ON E.DEP_NO = D.DEP_NO;";

    // Mostrar productos no pedidos por un cliente determinado
    private static $select5 = "SELECT DISTINCT (PRODUCTOS.PRODUCTO_NO), PRODUCTOS.DESCRIPCION, PRODUCTOS.PRECIO_ACTUAL FROM PRODUCTOS, PEDIDOS where PEDIDOS.PRODUCTO_NO = PRODUCTOS.PRODUCTO_NO and PEDIDOS.CLIENTE_NO != ?;";
    
  
    
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
    


    public function consulta0 ():array{
        $resu = [];
        $stmt = $this->dbh->prepare(self::$select0);
        // Devuelvo una tabla asociativa
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ( $stmt->execute() ){
            while ( $fila = $stmt->fetch()){
                $resu[]= $fila;
            }
        }
        return $resu;
    }
    
    
    
    public function consulta1 ():array{
        $resu = [];
        $stmt = $this->dbh->prepare(self::$select1);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ( $stmt->execute() ){
            while ( $fila = $stmt->fetch()){
                $resu[]= $fila;
            }
        }
        return $resu;
    }
    
    public function consulta2 ():array {
        $resu=[];
        $stmt = $this->dbh->prepare(self::$select2);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ( $stmt->execute() ){
            while ( $fila = $stmt->fetch()){
                $resu[]= $fila;
            }
        }
        return $resu;
    }

    public function consulta3 ():array {
        $resu=[];
        $stmt = $this->dbh->prepare(self::$select3);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ( $stmt->execute() ){
            while ( $fila = $stmt->fetch()){
                $resu[]= $fila;
            }
        }
        return $resu;
    }


    public function consulta4 ():array {
        $resu=[];
        $stmt = $this->dbh->prepare(self::$select4);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ( $stmt->execute() ){
            while ( $fila = $stmt->fetch()){
                $resu[]= $fila;
            }
        }
        return $resu;
    }


    public function consulta5 ($cliente_num):array {
        $resu=[];
        $stmt = $this->dbh->prepare(self::$select5);
        $stmt->bindValue(1, $cliente_num);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ( $stmt->execute() ) {
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

