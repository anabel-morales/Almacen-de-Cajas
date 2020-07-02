<?php

include_once '../DAO/DAOperaciones.php';
include_once '../Modelo/EstanteriaException.php';
session_start();
$devolucion = $_REQUEST['devolucion'];

if ($devolucion == 'devolucion') {
    $ArrayEstanteria = DAOperaciones::EstanteriasLibres();
    if (!empty($ArrayEstanteria)) {
        $_SESSION['ArrayEstanteria'] = $ArrayEstanteria;
        header("Location:../Vista/DatosCajaBackup.php");
    }
} else {
    try {
        $ArrayEstanteria = DAOperaciones::EstanteriasLibres();
        if (!empty($ArrayEstanteria)) {
            $_SESSION['ArrayEstanteria'] = $ArrayEstanteria;
            header("Location:../Vista/AltaCaja.php");
        }
    } catch (EstanteriaException $EE) {
        header("Location:../Vista/VistaError.php?error=error-estanteria");
        exit;
    }
}


