<?php

class OcupacionEstanteria {
   
    private $id;
    private $idEstanteria;
    private $lejaOcupada;
    private $idCaja;

    public function __construct($idEstanteria, $lejaOcupada) {
        $this->setIdEstanteria($idEstanteria);
        $this->setLejaOcupada($lejaOcupada);
    }

    function getId() {
        return $this->id;
    }

    function getIdEstanteria() {
        return $this->idEstanteria;
    }

    function getLejaOcupada() {
        return $this->lejaOcupada;
    }

    function getIdCaja() {
        return $this->idCaja;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdEstanteria($idEstanteria) {
        $this->idEstanteria = $idEstanteria;
    }

    function setLejaOcupada($lejaOcupada) {
        $this->lejaOcupada = $lejaOcupada;
    }

    function setIdCaja($idCaja) {
        $this->idCaja = $idCaja;
    }
    public function __toString() {
        return "Id: " .$this->id .
               "Id de la caja: " .$this->idCaja .
               "Id de la estanteria: " .$this->idEstanteria .
               "Leja ocupada: " .$this->lejaOcupada;
    }
}
