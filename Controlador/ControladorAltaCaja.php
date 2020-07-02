<?php

include '../Modelo/Caja.php';
include '../Modelo/OcupacionEstanteria.php';
include_once "../DAO/DAOperaciones.php";
include_once "../Modelo/CajaException.php";

$codigo = $_REQUEST['codigo'];
$altura = $_REQUEST['altura'];
$anchura = $_REQUEST['anchura'];
$profundidad = $_REQUEST['profundidad'];
$color = $_REQUEST['color'];
$material = $_REQUEST['material'];
$contenido = $_REQUEST['contenido'];
$fecha_alta = $_REQUEST['fechalta'];

$idEstanteria = $_REQUEST['estanteriasdisponibles'];
$leja = $_REQUEST['lejasLibres'];

session_start();
$ObjCaja = new Caja($codigo, $altura, $anchura, $profundidad, $color, $material, $contenido, $fecha_alta);
$ObjOcupacionEstanteria = new OcupacionEstanteria($idEstanteria, $leja);

$conexion->autocommit(false);

try {
    $ExisteCaja = DAOperaciones::ComprobarCaja($codigo);
    $ExisteCajaBackup = DAOperaciones::ComprobarCajaBackUp($codigo);
    if ($ExisteCaja) {    
        if($ExisteCajaBackup){
            DAOperaciones::InsertarCaja($ObjCaja, $ObjOcupacionEstanteria);
            $conexion->commit();
            $conexion->autocommit(true);
            header("Location:../Vista/VistaCorrecto.php?correcto=caja");
        }else{
            header("Location:../Vista/VistaError.php?error=caja-existe-backup");
        }
    } else {
            header("Location:../Vista/VistaError.php?error=caja-existe");
    }
} catch (CajaException $CE) {
    $conexion->rollback();
    $conexion->autocommit(true);
    header("Location:../Vista/VistaError.php?error=insertar-caja");
}