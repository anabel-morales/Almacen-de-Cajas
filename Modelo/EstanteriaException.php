<?php

class EstanteriaException extends Exception {
    private $lugar;
    
    public function __construct($message,$code,$lugar) {
        parent::__construct($message,$code,null);
        $this->lugar=$lugar;
    }
    
    public function __toString() {
        return __CLASS__."    ".$this->getMessage()."-".$this->getCode()."-".$this->lugar;
    }

}