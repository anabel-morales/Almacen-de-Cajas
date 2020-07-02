<?php

include_once '../DAO/DAOperaciones.php';
include_once '../Modelo/Caja.php';
include_once '../Modelo/CajaException.php';
session_start();

$salida = $_REQUEST['SALIDA'];
//$devolución=$_REQUEST['devolucion'];
$codigo = $_REQUEST['codigo'];

if ($salida == "SALIDA") {
    try {
        $ArrayCaja = DAOperaciones::buscarCaja($codigo);
        $_SESSION['ArrayCaja'] = $ArrayCaja;
        header("Location:../Vista/DatosCaja.php");
    } catch (CajaException $CE) {
        header("Location:../Vista/VistaError.php?error=no-EXISTE-caja");
        exit;
    }
} else {
    try {
       $ArrayCajaBck = DAOperaciones::buscarCajaBackup($codigo);
        $_SESSION['ArrayCajaBck'] = $ArrayCajaBck;
        header("Location:../Controlador/ControladorEstanteriasLibres.php?devolucion=devolucion");
    } catch (CajaException $CE) {
        header("Location: ../Vista/VistaError.php?error=no-EXISTE-caja");
        exit;
   }
    
//    try {
//        $ArrayCajaBck = DAOperaciones::buscarCajaBackup($codigo);
//        $_SESSION['ArrayCajaBck'] = $ArrayCajaBck;
//        header("Location:../Vista/DatosCajaBackup.php");
//    } catch (CajaException $CE) {
//        header("Location: ../Vista/VistaError.php?error=no-EXISTE-caja");
//        exit;
//    }
}


