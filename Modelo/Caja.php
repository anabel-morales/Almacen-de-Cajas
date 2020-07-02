<?php

class Caja {
    private $id_caja;
    private $codigo_caja;
    private $altura;
    private $anchura;
    private $profundidad;
    private $color;
    private $material_caja;
    private $contenido;
    private $fecha_alta_caja;

    public function __construct($codigo_caja, $altura, $anchura, $profundidad, $color, $material_caja, $contenido, $fecha_alta_caja) {
        $this->setCodigo_caja($codigo_caja);
        $this->setAltura($altura);
        $this->setAnchura($anchura);
        $this->setProfundidad($profundidad);
        $this->setColor($color);
        $this->setMaterial_caja($material_caja);
        $this->setContenido($contenido);
        $this->setFecha_alta_caja($fecha_alta_caja);
    }

    function getId_caja() {
        return $this->id_caja;
    }

    function getCodigo_caja() {
        return $this->codigo_caja;
    }

    function getMaterial_caja() {
        return $this->material_caja;
    }

    function getFecha_alta_caja() {
        return $this->fecha_alta_caja;
    }

    function setId_caja($id_caja) {
        $this->id_caja = $id_caja;
    }

    function setCodigo_caja($codigo_caja) {
        $this->codigo_caja = $codigo_caja;
    }

    function setMaterial_caja($material_caja) {
        $this->material_caja = $material_caja;
    }

    function setFecha_alta_caja($fecha_alta_caja) {
        $this->fecha_alta_caja = $fecha_alta_caja;
    }

    function getAltura() {
        return $this->altura;
    }

    function getAnchura() {
        return $this->anchura;
    }

    function getProfundidad() {
        return $this->profundidad;
    }

    function getColor() {
        return $this->color;
    }

    function getContenido() {
        return $this->contenido;
    }

    function setAltura($altura) {
        $this->altura = $altura;
    }

    function setAnchura($anchura) {
        $this->anchura = $anchura;
    }

    function setProfundidad($profundidad) {
        $this->profundidad = $profundidad;
    }

    function setColor($color) {
        $this->color = $color;
    }

    function setContenido($contenido) {
        $this->contenido = $contenido;
    }

    public function __toString() {
        return "Id: " . $this->id_caja .
                "Codigo: " . $this->codigo_caja .
                "Altura: " . $this->altura .
                "Anchura: " . $this->anchura .
                "Profundidad: " . $this->profundidad .
                "Color: " . $this->color .
                "Material: " . $this->material_caja .
                "Contenido: " . $this->contenido .
                "Fecha alta: " . $this->fecha_alta_caja;
    }
}
