<?php

include_once '../DAO/DAOperaciones.php';
include_once '../Modelo/Pasillo.php';
include_once '../Modelo/AlmacenException.php';

try{
    session_start();
    $ArrayPasillo=DAOperaciones::pasillosLibres();
    if(!empty($ArrayPasillo)){
        $_SESSION['ArrayPasillo']=$ArrayPasillo;
//        var_dump($_SESSION['ArrayPasillo']);
        header("Location:../Vista/AltaEstanteria.php");
    } 
}catch (AlmacenException $EX){
    header("Location:../Vista/VistaError.php?cod=error-cargar-pasillos");
}

