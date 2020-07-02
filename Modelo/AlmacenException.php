<?php
class AlmacenException extends Exception {
    private $lugar;

    public function __construct($mensaje, $codigo, $lugar = '') {
        parent::__construct($mensaje, $codigo);
        $this->lugar=$lugar;
    }

    public function __toString() {
        return __CLASS__ . "   " . $this->message . "   " . $this->codigo;
    }
    function getLugar() {
        return $this->lugar;
    }

    function setLugar($lugar) {
        $this->lugar = $lugar;
    }


}
