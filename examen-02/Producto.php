<?php
class Producto {
    private $PRODUCTO_NO;
    private $DESCRIPCION;
    private $PRECIO_ACTUAL;
    private $STOCK_DISPONIBLE;

    function getNumeroProducto() {
        return $this->PRODUCTO_NO;
    }

    function setNumeroProducto($PRODUCTO_NO) {
        $this->PRODUCTO_NO = $PRODUCTO_NO;
    }

    function getDescripcion() {
        return $this->DESCRIPCION;
    }

    function setDescripcion($DESCRIPCION) {
        $this->DESCRIPCION = $DESCRIPCION;
    }

    function getPrecioActual() {
        return $this->PRECIO_ACTUAL;
    }

    function setPrecioActual($PRECIO_ACTUAL) {
        $this->PRECIO_ACTUAL = $PRECIO_ACTUAL;
    }

    function getStockDisponible() {
        return $this->STOCK_DISPONIBLE;
    }

    function setStockDisponible($STOCK_DISPONIBLE) {
        $this->STOCK_DISPONIBLE = $STOCK_DISPONIBLE;
    }
}
?>