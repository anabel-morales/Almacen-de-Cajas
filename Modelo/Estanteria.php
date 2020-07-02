<?php

class Estanteria {
   
    private $id_estanteria;
    private $codigo_estanteria;
    private $material_estanteria;
    private $lejas;
    private $pasillo;
    private $numero;
    private $lejas_ocupadas;
    private $fecha_alta_estanteria;

    public function __construct($codigo_estanteria, $material_estanteria, $lejas, $fecha_alta_estanteria, $pasillo, $numero) {
        $this->setCodigo_estanteria($codigo_estanteria);
        $this->setMaterial_estanteria($material_estanteria);
        $this->setLejas($lejas);
        $this->setFecha_alta_estanteria($fecha_alta_estanteria);
        $this->setPasillo($pasillo);
        $this->setNumero($numero);
        
    }

    function getId_estanteria() {
        return $this->id_estanteria;
    }

    function getCodigo_estanteria() {
        return $this->codigo_estanteria;
    }

    function getMaterial_estanteria() {
        return $this->material_estanteria;
    }

    function getFecha_alta_estanteria() {
        return $this->fecha_alta_estanteria;
    }

    function setId_estanteria($id_estanteria) {
        $this->id_estanteria = $id_estanteria;
    }

    function setCodigo_estanteria($codigo_estanteria) {
        $this->codigo_estanteria = $codigo_estanteria;
    }

    function setMaterial_estanteria($material_estanteria) {
        $this->material_estanteria = $material_estanteria;
    }

    function setFecha_alta_estanteria($fecha_alta_estanteria) {
        $this->fecha_alta_estanteria = $fecha_alta_estanteria;
    }

    function getLejas() {
        return $this->lejas;
    }

    function getPasillo() {
        return $this->pasillo;
    }

    function getNumero() {
        return $this->numero;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLejas($lejas) {
        $this->lejas = $lejas;
    }

    function setPasillo($pasillo) {
        $this->pasillo = $pasillo;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function getLejas_ocupadas() {
        return $this->lejas_ocupadas;
    }

    function setLejas_ocupadas($lejas_ocupadas) {
        $this->lejas_ocupadas = $lejas_ocupadas;
    }

    public function __toString() {
        return "Id: " . $this->id_estanteria .
                "Codigo: " . $this->codigo_estanteria .
                "Material: " . $this->material_estanteria .
                "Número de lejas: " . $this->lejas .
                "Lejas ocupadas: " . $this->lejas_ocupadas .
                "Fecha de alta: " . $this->fecha_alta_estanteria .
                "Pasillo: " . $this->pasillo .
                "Número: " . $this->numero;
    }
}
