<?php
$borrar = "DROP trigger if exists trigger_devolver_caja";

$resultado2 = $conexion->query($borrar)or die('HA FALLADO EL BORRAR EL DROP');
$codigo = $ObjCaja->getCodigo_caja();
$altura = $ObjCaja->getAltura();
$anchura = $ObjCaja->getAnchura();
$profundidad = $ObjCaja->getProfundidad();
$color = $ObjCaja->getColor();
$material_caja = $ObjCaja->getMaterial_caja();
$contenido = $ObjCaja->getContenido();
$fecha_alta_caja = $ObjCaja->getFecha_alta_caja();

$idEstanteria = $ObjOcupacionEstanteria->getIdEstanteria();
$leja = $ObjOcupacionEstanteria->getLejaOcupada();

$trigger = 'CREATE TRIGGER TRIGGER_DEVOLVER_CAJA
    AFTER DELETE
    ON caja_backup 
    FOR EACH ROW
BEGIN
    INSERT INTO caja (codigo_caja,altura,anchura,profundidad,color,material_caja,contenido,fecha_alta_caja)
        VALUES ("' . $codigo . '", "' . $altura . '", "' . $anchura . '", "' . $profundidad . '", "' . $color . '", "' . $material_caja . '", "' . $contenido . '", "' . $fecha_alta_caja . '");
            
    INSERT INTO ocupacion_estanteria (id_estanteria,leja_ocupada,id_caja) VALUES ("' . $idEstanteria . '","' . $leja . '",(SELECT id_ca FROM CAJA WHERE codigo_caja="' . $codigo . '"));
  
    UPDATE estanteria SET lejas_ocupadas = lejas_ocupadas +1 WHERE id_estanteria="' . $idEstanteria . '";
END';


$resultado3 = $conexion->query($trigger)or die('el insert trigger ha fallado');
