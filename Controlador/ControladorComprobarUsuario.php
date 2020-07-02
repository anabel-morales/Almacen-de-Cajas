<?php

include_once '../DAO/DAOperaciones.php';
include_once '../Modelo/AlmacenException.php';

try {
    $ExisteUsuario = DAOperaciones::ComprobarUsuario();
    if ($ExisteUsuario) {
        header("Location:../Vista/Login.php");
    } else {
        header("Location:../Vista/Registro.php");
    }
} catch (AlmacenExceptionException $UE) {
    header("Location:../Vista/VistaError.php?error=error-usuario");
}

