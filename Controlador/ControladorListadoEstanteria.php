<?php


include '../DAO/DAOperaciones.php';
session_start();

try {
    $ArrayEstanterias= DAOperaciones::listadoGeneralEstanterias();
    $_SESSION['ArrayEstanterias']=$ArrayEstanterias;
    header("Location:../Vista/ListadoEstanterias.php");
} catch (EstanteriaException $EE) {

    header("Location:../Vista/VistaError.php?error=error-estanteria");
    exit;
}

