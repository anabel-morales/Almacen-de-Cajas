<?php

include_once 'Conexion.php';
include_once '../Modelo/AlmacenException.php';
include_once '../Modelo/CajaException.php';
include_once '../Modelo/EstanteriaException.php';
include_once '../Modelo/Pasillo.php';
include_once '../Modelo/Estanteria.php';
include_once '../Modelo/OcupacionEstanteriaException.php';
include_once '../Modelo/OcupacionEstanteria.php';

class DAOperaciones {

    public function ComprobarUsuario() {
        global $conexion;
        $sql = "SELECT * FROM usuario";
        $ExisteUsuario = $conexion->query($sql);
        if ($ExisteUsuario->num_rows == 1) {
            return true;
        } elseif ($Existe->num_rows == 0) {
            return false;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'Error al comprobar usuario';
            throw new AlmacenException($mensaje, $codigo, $lugar);
        }
    }

    public function ComprobarCaja($codigoCaja) {
        global $conexion;
        $sql = $conexion->prepare("SELECT c.CODIGO_CAJA FROM caja c WHERE c.CODIGO_CAJA=?");
        $sql->bind_param('s', $codigoCaja);
        $sql->execute();
        $resultado = $sql->get_result();

        if ($resultado->num_rows == 1) {
            return false;
        } elseif ($resultado->num_rows == 0) {
            return true;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'Error al comprobar caja';
            throw new CajaException($mensaje, $codigo, $lugar);
        }
    }
    
    public function ComprobarCajaBackUp($codigoCaja){
         global $conexion;
        $sql = $conexion->prepare("SELECT c.codigo_caja_back FROM caja_backup c WHERE c.codigo_caja_back=?");
        $sql->bind_param('s', $codigoCaja);
        $sql->execute();
        $resultado = $sql->get_result();

        if ($resultado->num_rows == 1) {
            return false;
        } elseif ($resultado->num_rows == 0) {
            return true;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'Error al comprobar caja backup';
            throw new CajaException($mensaje, $codigo, $lugar);
        }
        
    }

    public function RegistrarUsuario($usuario, $password) {
        global $conexion;
//ENCRIPTA LA CONTRASEÑA
        $PasswordEncriptada = password_hash($password, PASSWORD_BCRYPT);
//INSERTAR USUARIO CON SENTENCIAS PREPARADAS
        $sql = $conexion->prepare("INSERT INTO usuario(usuario,password) VALUES (?,?)");
        $sql->bind_param('ss', $usuario, $PasswordEncriptada);
        $sql->execute();
        $filasAfectadas = $sql->affected_rows;
        if ($filasAfectadas != 1) {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'No se ha podido registrar al usuario';
            throw new AlmacenException($mensaje, $codigo, $lugar);
        } else {
            return;
        }
    }

    public function IniciarSesion($usuario, $password) {
        global $conexion;
        $sql = $conexion->prepare("SELECT * FROM usuario WHERE usuario=?");
        $sql->bind_param('s', $usuario);
        $sql->execute();
        $resultado = $sql->get_result();

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $passbd = $fila['password'];
        }
//COMPROBAMOS LA CONTRASEÑA
        if (password_verify($password, $passbd)) {
            return;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'No se ha podido iniciar sesión';
            throw new AlmacenException($mensaje, $codigo, $lugar);
        }
    }

    public function pasillosLibres() {
        global $conexion;
        $ArrayPasillo = array();
        $sql = "SELECT id_pasillo, letra_pasillo FROM pasillo P, almacen A WHERE P.huecos_pasillos < A.numero_huecos_pasillo";
        $resultado = $conexion->query($sql);
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();

            while ($fila) {
                $id_pasillo = $fila['id_pasillo'];
                $letra_pasillo = $fila['letra_pasillo'];

//CREAMOS UN OBJETO PASILLO Y LO GUARDAMOS EN EL ARRAY
                $ObjPasillo = new Pasillo($id_pasillo, $letra_pasillo);
                $ArrayPasillo[] = $ObjPasillo;
                $fila = $resultado->fetch_assoc();
            }
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'PASILLOS OCUPADOS ';
            throw new PasilloException($mensaje, $codigo, $lugar);
        }

        return $ArrayPasillo;
    }

    public function numerosDisponibles($idPasillo) {
        global $conexion;

        $sql = "SELECT numero_huecos_pasillo FROM almacen";
        $resultado = $conexion->query($sql);
        $ArrayNumeros = array();

        if ($resultado) {
            $almacen = $resultado->fetch_array();
            $NumeroHuecos = $almacen['numero_huecos_pasillo'];
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'ERROR EN EL NUMERO_HUECOS_PASILLO ';
            throw new CajaException($mensaje, $codigo, $lugar);
        }

        $sql2 = "SELECT huecos_pasillos FROM pasillo WHERE id_pasillo=$idPasillo";
        $ResultadoNumeroOcupados = $conexion->query($sql2);

        if ($ResultadoNumeroOcupados->num_rows == 1) {
            $fila = $ResultadoNumeroOcupados->fetch_assoc();
            $NumeroOcupados = $fila['huecos_pasillos'];
        }

        $sql3 = "SELECT numero FROM estanteria WHERE pasillo=$idPasillo";
        $resultadoNumeroOcupado = $conexion->query($sql3);

        for ($i = 0; $i <= $NumeroOcupados; $i++) {
            $fila = $resultadoNumeroOcupado->fetch_assoc();
            $ArrayNumeros[] = $fila['numero'];
        }

        for ($i = 1; $i <= $NumeroHuecos; $i++) {
            if (!in_array($i, $ArrayNumeros)) {
                $ArrayDisponibles[] = $i;
            }
        }
        return $ArrayDisponibles;
    }

    public function insertarEstanteria($ObjEstanteria) {
        global $conexion;
        $codigo = $ObjEstanteria->getCodigo_estanteria();
        $material = $ObjEstanteria->getMaterial_estanteria();
        $lejas = $ObjEstanteria->getLejas();
        $pasillo = $ObjEstanteria->getPasillo();
        $numero = $ObjEstanteria->getNumero();
        $fecha_alta = $ObjEstanteria->getFecha_alta_estanteria();

//SI HAY DATOS NULOS, CASCA AQUÍ
        if (!$codigo || !$material || !$lejas || !$pasillo || !$numero || !$fecha_alta) {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'FALTAN DATOS';
            throw new EstanteriaException($mensaje, $codigo, $lugar);
        }
//INSERTAR ESTANTERIA
        $sql = $conexion->prepare("INSERT INTO ESTANTERIA (codigo_estanteria,material_estanteria,numLejas,fecha_alta_estanteria,pasillo,numero) VALUES(?,?,?,?,?,?)");
        $sql->bind_param('ssissi', $codigo, $material, $lejas, $fecha_alta, $pasillo, $numero);
        $sql->execute();
        $filasAfectadas = $sql->affected_rows;

        if ($filasAfectadas != 1) {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'NO SE HA INSERTADO LA ESTANTERIA';
            throw new EstanteriaException($mensaje, $codigo, $lugar);
        }
//HUECOS TABLA PASILLO
        $sql2 = $conexion->prepare("UPDATE pasillo SET huecos_pasillos=huecos_pasillos+1 WHERE id_pasillo=?");
        $sql2->bind_param('s', $pasillo);
        $sql2->execute();
        $filasAfectadas2 = $sql2->affected_rows;

        if ($filasAfectadas2 != 1) {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'ERROR EN PASILLO-HUECOSPASILLO';
            throw new CajaException($mensaje, $codigo, $lugar);
        }
        return;
    }

    public function listadoGeneralEstanterias() {

        global $conexion;

        $ArrayEstanteria = array();
        $sql = "SELECT * FROM ESTANTERIA E, PASILLO P WHERE E.pasillo=P.id_pasillo ORDER BY P.letra_pasillo, E.numero";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            $ObjEstanteria = $resultado->fetch_object();

            while ($ObjEstanteria) {
                $ArrayEstanteria[] = $ObjEstanteria;
                $ObjEstanteria = $resultado->fetch_object();
            }
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'NO HAY ESTANTERIAS';
            throw new EstanteriaException($mensaje, $codigo, $lugar);
        }
        return $ArrayEstanteria;
    }

    public function EstanteriasLibres() {
        global $conexion;
        $ArrayEstanteria = array();


        $sql = "SELECT * FROM ESTANTERIA WHERE numLejas!=lejas_ocupadas";
        $resultado = $conexion->query($sql);
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            while ($fila) {
                $Id_estanteria = $fila['id_estanteria'];
                $Codigo_estanteria = $fila['codigo_estanteria'];
                $Material_estanteria = $fila['material_estanteria'];
                $NumLejas = $fila['numLejas'];
                $Pasillo = $fila['pasillo'];
                $Numero = $fila['numero'];
                $Fecha_alta_estanteria = $fila['fecha_alta_estanteria'];

                $ObjEstanteria = new Estanteria($Codigo_estanteria, $Material_estanteria, $NumLejas, $Pasillo, $Numero, $Fecha_alta_estanteria);
                $ObjEstanteria->setId_estanteria($Id_estanteria);
                $ArrayEstanteria[] = $ObjEstanteria;
                $fila = $resultado->fetch_assoc();
            }
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'NO HAY ESTANTERIAS ';
            throw new EstanteriaException($mensaje, $codigo, $lugar);
        }

        return $ArrayEstanteria;
    }

    public function lejasDisponibles($idEstanteria) {
        global $conexion;

        $sql = "SELECT numLejas FROM ESTANTERIA WHERE id_estanteria=$idEstanteria";
        $resultado = $conexion->query($sql);
        $arrayLejas = array();

        if ($resultado) {
            $leja = $resultado->fetch_array();
            $NumeroLejas = $leja['numLejas'];
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'ERROR EN LEJAS-ESTANTERIA ';
            throw new EstanteriaException($mensaje, $codigo, $lugar);
        }

        $sql2 = "SELECT lejas_ocupadas FROM estanteria WHERE id_estanteria=$idEstanteria";
        $resultado2 = $conexion->query($sql2);

        if ($resultado2->num_rows == 1) {
            $fila = $resultado2->fetch_assoc();
            $NumeroOcupadas = $fila['lejas_ocupadas'];
        }

        $sql3 = "SELECT leja_ocupada FROM ocupacion_estanteria WHERE id_estanteria=$idEstanteria";
        $resultado3 = $conexion->query($sql3);

        for ($i = 0; $i <= $NumeroOcupadas; $i++) {
            $fila = $resultado3->fetch_assoc();
            $arrayLejas[] = $fila['leja_ocupada'];
        }

        for ($i = 1; $i <= $NumeroLejas; $i++) {
            if (!in_array($i, $arrayLejas)) {
                $arrayLejasDisponibles[] = $i;
            }
        }
        return $arrayLejasDisponibles;
    }

    public function InsertarCaja($ObjCaja, $ObjOcupacionEstanteria) {
        global $conexion;
//CAJA
        $codigo = $ObjCaja->getCodigo_caja();
        $altura = $ObjCaja->getAltura();
        $anchura = $ObjCaja->getAnchura();
        $profundidad = $ObjCaja->getProfundidad();
        $color = $ObjCaja->getColor();
        $material = $ObjCaja->getMaterial_caja();
        $contenido = $ObjCaja->getContenido();
        $fecha_alta = $ObjCaja->getFecha_alta_caja();

        $sql = $conexion->prepare("INSERT INTO caja (CODIGO_CAJA, ALTURA, ANCHURA, PROFUNDIDAD, COLOR,MATERIAL_CAJA, CONTENIDO, FECHA_ALTA_CAJA) VALUES (?,?,?,?,?,?,?,?)");
        $sql->bind_param('sdddssss', $codigo, $altura, $anchura, $profundidad, $color, $material, $contenido, $fecha_alta);
        $sql->execute();
        $FilasAfectadas = $sql->affected_rows;

        if ($FilasAfectadas != 1) {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'ERROR INSERCCIÓN CAJA';
            throw new CajaException($mensaje, $codigo, $lugar);
        }

//OCUPACION-ESTANTERIA
        $idEstanteria = $ObjOcupacionEstanteria->getIdEstanteria();
        $lejaOcupada = $ObjOcupacionEstanteria->getLejaOcupada();
        $idCaja = $conexion->insert_id; //SI NO LO HAGO ASÍ, NO FUNCIONA

        $sql2 = $conexion->prepare("INSERT INTO ocupacion_estanteria (id_estanteria,leja_ocupada,id_caja) VALUES (?,?,?)");
        $sql2->bind_param('ssi', $idEstanteria, $lejaOcupada, $idCaja);
        $sql2->execute();
        $FilasAfectadas2 = $sql2->affected_rows;

        if ($FilasAfectadas2 != 1) {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'ERROR EN INSERCCIÓN OCUPACION-ESTANTERIA';
            throw new OcupacionEstanteriaException($mensaje, $codigo, $lugar);
        }

//ESTANTERIA
        $sql3 = $conexion->prepare("UPDATE estanteria SET lejas_ocupadas=lejas_ocupadas+1 WHERE id_estanteria=?");
        $sql3->bind_param('s', $idEstanteria);
        $sql3->execute();
        $FilasAfectadas = $sql3->affected_rows;

        if ($FilasAfectadas != 1) {
            $mensaje = $conexion->error;
            $codigo¡ = $conexion->errno;
            $lugar = 'FALLO EN ESTANTERIA-LEJAS';
            throw new EstanteriaException($mensaje, $codigo, $lugar);
        }
        return;
    }

    public function ListadoGeneralCajas() {
        global $conexion;

        $ArrayCajas = array();
        $sql = "SELECT * FROM caja ORDER BY codigo_caja";
        $resultado = $conexion->query($sql);
        if ($resultado->num_rows > 0) {
            $ObjCaja = $resultado->fetch_object();

            while ($ObjCaja) {
                $ArrayCajas[] = $ObjCaja;
                $ObjCaja = $resultado->fetch_object();
            }
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'NO HAY CAJAS';
            throw new CajaException($mensaje, $codigo, $lugar);
        }
        return $ArrayCajas;
    }

    public function ListadoInventario() {
        global $conexion;
        $ArrayInventario = array();
        $sql = "SELECT * FROM estanteria e 
LEFT JOIN ocupacion_estanteria o ON o.id_estanteria=e.id_estanteria
LEFT JOIN caja c ON c.ID_CA=o.id_caja
LEFT JOIN pasillo p ON p.id_pasillo=e.pasillo
ORDER BY p.letra_pasillo,E.numero, O.leja_ocupada";
        $resultado = $conexion->query($sql);
        if ($resultado->num_rows > 0) {
            $ListaEstanteria = [];
            $ListaCaja = [];
            $ListaOcupacion=[];
            while ($obj = $resultado->fetch_assoc()) {
                if (!in_array($obj['id_estanteria'], $ListaEstanteria)) {
                    $Estanteria = new Estanteria(
                            $obj['codigo_estanteria'], $obj['material_estanteria'], $obj['numLejas'], $obj['fecha_alta_estanteria'], $obj['letra_pasillo'], $obj['numero']
                    );


                    $ArrayInventario[] = $Estanteria;
                    $ListaEstanteria[] = $obj['id_estanteria'];
                }

                $prueba = (int) $obj['ID_CA'];
                if ($prueba != 0 && !in_array($obj['ID_CA'], $ListaCaja)) {
                    $Caja = new Caja(
                            $obj['CODIGO_CAJA'], $obj['ALTURA'], $obj['ANCHURA'], $obj['PROFUNDIDAD'], $obj['COLOR'], $obj['MATERIAL_CAJA'], $obj['CONTENIDO'], $obj['FECHA_ALTA_CAJA']
                    );
//                    $Caja->setId($prueba);
                    $ArrayInventario[] = $Caja;
                    $ListaCaja[] = $prueba;
                }

                $prueba2 = (int) $obj['id_ocu'];
                if ($prueba2 != 0 && !in_array($obj['id_ocu'], $ListaCaja)) {
                    $Ocupacion = new OcupacionEstanteria(
                            $obj['id_estanteria'], $obj['leja_ocupada']
                    );
//                    $Caja->setId($prueba);
                    $ArrayInventario[] = $Ocupacion;
                    $ListaOcupacion[] = $prueba2;
                }
            }
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'NO HAY DATOS EN EL INVENTARIO';
            throw new EstanteriaException($mensaje, $codigo, $lugar);
        }
        return $ArrayInventario;
//NO ME DEJA UTILIZAR EL INSTACEOF EN LA INTERFAZ
//        if ($resultado->num_rows > 0) {
//            $ObjInventario = $resultado->fetch_object();
//            while ($ObjInventario) {
//                $ArrayInventario[] = $ObjInventario; 
//                $ObjInventario = $resultado->fetch_object();
//            }
//        } else {
//            $mensaje = $conexion->error;
//            $codigo = $conexion->errno;
//            $lugar = 'ERROR INVENTARIO';
//            throw new AlmacenException($mensaje, $codigo, $lugar);
//        }
//        return $ArrayInventario;
    }

    public function buscarCaja($codigo) {
        global $conexion;
        $ArrayCaja = array();
        $sql = $conexion->prepare("SELECT c.id_ca, codigo_caja, altura, anchura, profundidad, color, material_caja,contenido, fecha_alta_caja, leja_ocupada, codigo_estanteria
                                            FROM caja c, ocupacion_estanteria o , estanteria e where codigo_caja=?
                                            AND c.id_ca=o.id_caja AND e.id_estanteria=o.id_estanteria");
        $sql->bind_param('s', $codigo);
        $sql->execute();
        $resultado = $sql->get_result();

        if ($resultado->num_rows > 0) {
            $ObjCaja = $resultado->fetch_object();

            while ($ObjCaja) {
                $ArrayCaja[] = $ObjCaja;
                $ObjCaja = $resultado->fetch_object();
            }
            return $ArrayCaja;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'NO SE ENCUENTRA LA CAJA';
            throw new CajaException($mensaje, $codigo, $lugar);
        }
    }

    public function eliminarCaja($codigo) {
        global $conexion;
        $sql = $conexion->prepare("DELETE FROM caja WHERE codigo_caja= ?");
        $sql->bind_param('s', $codigo);
        $sql->execute();

        $filasAfectadas = $sql->affected_rows;
        if ($filasAfectadas != 1) {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'NO SE HA PODIDO BORRAR';
            throw new CajaException($mensaje, $codigo, $lugar);
        } else {
            return;
        }
    }

    public function buscarCajaBackup($codigo) {
        global $conexion;
        $ArrayCajaBck = array();
        $sql = $conexion->prepare("SELECT id_caja_back,codigo_caja_back,altura_caja_back,anchura_caja_back,profundidad_caja_back,color_caja_back,
                        material_caja_back,contenido_caja_back,fecha_alta_caja_back, leja_estanteria_back,fecha_salida_caja_back,
                        e.codigo_estanteria, e.id_estanteria 
                        FROM caja_backup c, estanteria e
                        WHERE codigo_caja_back=?
                        AND e.id_estanteria=c.id_estanteria_back");
        $sql->bind_param('s', $codigo);
        $sql->execute();
        $resultado = $sql->get_result();

        if ($resultado->num_rows > 0) {
            $ObjCajaBck = $resultado->fetch_object();

            while ($ObjCajaBck) {
                $ArrayCajaBck[] = $ObjCajaBck;
                $ObjCajaBck = $resultado->fetch_object();
            }
            return $ArrayCajaBck;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'NO EXISTE LA CAJA EN BACKUP';
            throw new CajaException($mensaje, $codigo, $lugar);
        }
    }

    public function DevolverCaja($ObjCaja, $ObjOcupacionEstanteria) {

        $codigo = $ObjCaja->getCodigo_caja();
        global $conexion;
        include '../Modelo/TriggerDevolverCaja.php';
        $sql = $conexion->prepare("DELETE FROM CAJA_BACKUP WHERE codigo_caja_back=?");
        $sql->bind_param('s', $codigo);
        $sql->execute();
        $resultado = $sql->affected_rows;
        if ($resultado = 1) {
            return;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = 'NO SE HA PODIDO DEVOLVER';
            throw new CajaException($mensaje, $codigo, $lugar);
        }
    }

}
