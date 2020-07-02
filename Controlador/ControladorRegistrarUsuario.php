<?php

include_once '../DAO/DAOperaciones.php';
include_once '../Modelo/AlmacenException.php';

$usuario = $_REQUEST['usuario'];
$password = $_REQUEST['password'];

//session_start();
try {
    DAOperaciones::RegistrarUsuario($usuario, $password);
    header("Location:../Vista/Menu.php");
} catch (AlmacenException $UE) {
    header("Location:../Vista/VistaError.php?error=registro");
}

