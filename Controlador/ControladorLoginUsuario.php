<?php

include_once "../DAO/DAOperaciones.php";
include_once "../Modelo/AlmacenException.php";

$usuario = $_REQUEST['usuario'];
$password = $_REQUEST['password'];

//session_start();
try {
    DAOperaciones::IniciarSesion($usuario, $password);

 header("Location:../Vista/Menu.php");
} catch (AlmacenException $AE) {
    header("Location:../Vista/VistaError.php?error=login");
}

