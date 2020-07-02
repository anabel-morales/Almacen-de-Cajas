<?php

class Pasillo {
  private $id_pasillo;
    private $letra_pasillo;
    private $huecos_ocupados;

    public function __construct($id_pasillo, $letra_pasillo) {
        $this->setId_pasillo($id_pasillo);
        $this->setLetra_pasillo($letra_pasillo);
    }

    function getId_pasillo() {
        return $this->id_pasillo;
    }

    function getLetra_pasillo() {
        return $this->letra_pasillo;
    }

    function getHuecos_ocupados() {
        return $this->huecos_ocupados;
    }

    function setId_pasillo($id_pasillo) {
        $this->id_pasillo = $id_pasillo;
    }

    function setLetra_pasillo($letra_pasillo) {
        $this->letra_pasillo = $letra_pasillo;
    }

    function setHuecos_ocupados($huecos_ocupados) {
        $this->huecos_ocupados = $huecos_ocupados;
    }

    public function __toString() {
        return "Id pasillo: " . $this->id_pasillo .
                "Letra: " . $this->letra_pasillo .
                "Huecos ocupados: " . $this->huecos_ocupados;
    }



}
