<?php

include_once "../DAO/DAOperaciones.php";
include_once "../Modelo/Estanteria.php";
include_once "../Modelo/EstanteriaException.php";

$codigo_estanteria =$_REQUEST['codigo'];
$material_estanteria=$_REQUEST['material'];
$lejas = $_REQUEST['numlejas'];
$fecha_alta_estanteria = $_REQUEST['fechalta'];
$pasillo = $_REQUEST['pasillosdisponibles'];
$numero = $_REQUEST['numero'];

$ObjEstanteria = new Estanteria($codigo_estanteria, $material_estanteria, $lejas, $fecha_alta_estanteria, $pasillo, $numero);

$conexion->autocommit(false);

try {
    DAOperaciones::insertarEstanteria($ObjEstanteria);
    $conexion->commit();
    $conexion->autocommit(true);
    header("Location:../Vista/VistaCorrecto.php?correcto=estanteria");
} catch (EstanteriaException $EE) {
    $conexion->rollback();
    $conexion->autocommit(true);
    header("Location:../Vista/VistaError.php?error=caja-repetida");
    exit;
}

