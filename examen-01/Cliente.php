<?php

class Cliente {

    private $codCliente;
    private $nombre;
    private $clave;
    private $veces;

    
	function getCodCliente() {
		return $this->codCliente;
	}
	function setCodCliente($codCliente) {
		$this->codCliente = $codCliente;
	}

	function getNombre() {
		return $this->nombre;
	}

	function setNombre($nombre) {
		$this->nombre = $nombre;
	}

	function getClave() {
		return $this->clave;
	}

	function setClave($clave) {
		$this->password = $clave;
	}

	function getVeces() {
		return $this->veces;
	}

	function setVeces($veces) {
		$this->veces = $veces;
	}


    

}

?>