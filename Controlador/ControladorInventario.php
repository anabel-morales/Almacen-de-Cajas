<?php

include_once '../DAO/DAOperaciones.php';
include_once '../Modelo/Caja.php';
include_once '../Modelo/Estanteria.php';
include_once '../Modelo/EstanteriaException.php';
session_start();

try {
    $ArrayInventario = DAOperaciones::ListadoInventario();
    $_SESSION['ArrayInventario'] = $ArrayInventario;
    header("Location:../Vista/Inventario.php");
} catch (EstanteriaException $EE) {
    header("Location:../Vista/VistaError.php?error=inventario-vacio");
    exit;
}

