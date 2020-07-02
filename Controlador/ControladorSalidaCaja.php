<?php
include_once '../DAO/DAOperaciones.php';
include_once '../Modelo/Caja.php';
include_once '../Modelo/CajaException.php';
session_start();

$codigo = $_REQUEST['codigo'];
$conexion->autocommit(false);
try {
    DAOperaciones::eliminarCaja($codigo);
    $conexion->commit();
    $conexion->autocommit(true);
   
 header("Location:../Vista/VistaCorrecto.php?correcto=salida");
} catch (CajaException $CE) {
    $conexion->rollback();
    $conexion->autocommit(true);
    header("Location:../Vista/VistaError.php?error=baja-caja");
}
