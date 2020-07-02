
<?php

include_once "../Modelo/Caja.php";
include_once "../Modelo/CajaException.php";
include_once "../Modelo/Estanteria.php";
include_once "../Modelo/OcupacionEstanteria.php";
include '../DAO/DAOperaciones.php';
session_start();

$ArrayCaja = $_SESSION['ArrayCajaBck'];
var_dump($ArrayCaja);
foreach ($ArrayCaja as $Caja) {
    $codigo_caja = $Caja->codigo_caja_back;
    $altura = $Caja->altura_caja_back;
    $anchura = $Caja->anchura_caja_back;
    $profundidad = $Caja->profundidad_caja_back;
    $color = $Caja->color_caja_back;
    $material_caja = $Caja->material_caja_back;
    $contenido = $Caja->contenido_caja_back;
    $fecha_alta_caja = $Caja->fecha_alta_caja_back;
}
$ObjCaja = new Caja($codigo_caja, $altura, $anchura, $profundidad, $color, $material_caja, $contenido, $fecha_alta_caja);

$idEstanteria = $_REQUEST['estanteriasdisponibles'];
$leja = $_REQUEST['lejasLibres'];
$ObjOcupacionEstanteria = new OcupacionEstanteria($idEstanteria, $leja);


$conexion->autocommit(false);

try {
    DAOperaciones::DevolverCaja($ObjCaja, $ObjOcupacionEstanteria);
    $conexion->commit();
    $conexion->autocommit(true);

    header("Location:../Vista/VistaCorrecto.php?correcto=devolucion");
} catch (CajaException $CE) {
    $conexion->rollback();
    $conexion->autocommit(true);
    header("Location:../Vistas/VistaErrores.php?Error=$CE");
}
