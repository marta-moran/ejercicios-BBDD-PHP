<?php


class Pedido {

    private $numPed;
    private $codCliente;
    private $producto;
    private $precio;
    
    //getters y setters
    function getNumPed() {
        return $this->numPed;
    }

    function setNumPed($numPed) {
        $this->numPed = $numPed;
    }

    function getCodCliente() {
        return $this->codCliente;
    }

    function setCodCliente($codCliente) {
        $this->codCliente = $codCliente;
    }

    function getProducto() {
        return $this->producto;
    }

    function setProducto($producto) {
        $this->producto = $producto;
    }

    function getPrecio() {
        return $this->precio;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }



}
