<?php

include_once '../DAO/DAOperaciones.php';
include_once '../Modelo/CAjaException.php';
session_start();

try {
$ArrayCajas= DAOperaciones::ListadoGeneralCajas();
    $_SESSION['ArrayCajas']=$ArrayCajas;
    header("Location:../Vista/ListadoCajas.php");
} catch (CajaException $CE) {
    header("Location:../Vista/VistaError.php?error=no-hay-cajas");
    exit;
}