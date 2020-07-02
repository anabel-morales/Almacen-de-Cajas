-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.11-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5709
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para bd_almacen
CREATE DATABASE IF NOT EXISTS `bd_almacen` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `bd_almacen`;

-- Volcando estructura para tabla bd_almacen.almacen
CREATE TABLE IF NOT EXISTS `almacen` (
  `nombre` varchar(50) DEFAULT NULL,
  `cif` varchar(50) NOT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `NUMERO_HUECOS_PASILLO` int(11) NOT NULL,
  `pasillos` varchar(3) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bd_almacen.almacen: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `almacen` DISABLE KEYS */;
REPLACE INTO `almacen` (`nombre`, `cif`, `direccion`, `telefono`, `email`, `NUMERO_HUECOS_PASILLO`, `pasillos`) VALUES
	('Almacenes Morales', 'J42054957', 'Avenida de España, 35, 3ºDerecha', '659078734', 'anabel_mrs_14@hotmail.com', 10, '3');
/*!40000 ALTER TABLE `almacen` ENABLE KEYS */;

-- Volcando estructura para tabla bd_almacen.caja
CREATE TABLE IF NOT EXISTS `caja` (
  `ID_CA` int(11) NOT NULL AUTO_INCREMENT,
  `CODIGO_CAJA` varchar(50) NOT NULL,
  `ALTURA` double NOT NULL DEFAULT 0,
  `ANCHURA` double NOT NULL,
  `PROFUNDIDAD` double NOT NULL,
  `COLOR` varchar(50) NOT NULL,
  `MATERIAL_CAJA` varchar(50) NOT NULL,
  `CONTENIDO` varchar(50) NOT NULL,
  `FECHA_ALTA_CAJA` date NOT NULL,
  PRIMARY KEY (`ID_CA`),
  UNIQUE KEY `CODIGO` (`CODIGO_CAJA`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bd_almacen.caja: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `caja` DISABLE KEYS */;
/*!40000 ALTER TABLE `caja` ENABLE KEYS */;

-- Volcando estructura para tabla bd_almacen.caja_backup
CREATE TABLE IF NOT EXISTS `caja_backup` (
  `id_caja_back` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_caja_back` varchar(50) NOT NULL DEFAULT '',
  `altura_caja_back` double NOT NULL DEFAULT 0,
  `anchura_caja_back` double NOT NULL DEFAULT 0,
  `profundidad_caja_back` double NOT NULL DEFAULT 0,
  `color_caja_back` varchar(50) NOT NULL DEFAULT '',
  `material_caja_back` varchar(50) NOT NULL DEFAULT '',
  `contenido_caja_back` varchar(50) NOT NULL DEFAULT '',
  `fecha_alta_caja_back` date NOT NULL,
  `id_estanteria_back` int(11) NOT NULL,
  `leja_estanteria_back` int(11) NOT NULL,
  `fecha_salida_caja_back` date NOT NULL,
  PRIMARY KEY (`id_caja_back`),
  KEY `FK_caja_backup_estanteria` (`id_estanteria_back`),
  CONSTRAINT `FK_caja_backup_estanteria` FOREIGN KEY (`id_estanteria_back`) REFERENCES `estanteria` (`id_estanteria`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bd_almacen.caja_backup: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `caja_backup` DISABLE KEYS */;
/*!40000 ALTER TABLE `caja_backup` ENABLE KEYS */;

-- Volcando estructura para tabla bd_almacen.estanteria
CREATE TABLE IF NOT EXISTS `estanteria` (
  `id_estanteria` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_estanteria` varchar(50) NOT NULL,
  `material_estanteria` varchar(50) NOT NULL,
  `numLejas` int(11) NOT NULL,
  `lejas_ocupadas` int(11) NOT NULL DEFAULT 0,
  `fecha_alta_estanteria` date NOT NULL,
  `pasillo` int(11) NOT NULL,
  `numero` int(2) NOT NULL,
  PRIMARY KEY (`id_estanteria`),
  UNIQUE KEY `pasillo_numero` (`pasillo`,`numero`),
  UNIQUE KEY `codigo_es` (`codigo_estanteria`),
  CONSTRAINT `FK_estanteria_pasillo` FOREIGN KEY (`pasillo`) REFERENCES `pasillo` (`id_pasillo`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bd_almacen.estanteria: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `estanteria` DISABLE KEYS */;
/*!40000 ALTER TABLE `estanteria` ENABLE KEYS */;

-- Volcando estructura para tabla bd_almacen.ocupacion_estanteria
CREATE TABLE IF NOT EXISTS `ocupacion_estanteria` (
  `id_ocu` int(11) NOT NULL AUTO_INCREMENT,
  `id_estanteria` int(11) NOT NULL,
  `leja_ocupada` int(11) NOT NULL,
  `id_caja` int(11) NOT NULL,
  PRIMARY KEY (`id_ocu`),
  UNIQUE KEY `id_estanteria_leja_ocupada` (`id_estanteria`,`leja_ocupada`),
  UNIQUE KEY `id_caja` (`id_caja`),
  CONSTRAINT `FK_ocupacion_estanteria_caja` FOREIGN KEY (`id_caja`) REFERENCES `caja` (`ID_CA`),
  CONSTRAINT `FK_ocupacion_estanteria_caja_2` FOREIGN KEY (`id_estanteria`) REFERENCES `estanteria` (`id_estanteria`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bd_almacen.ocupacion_estanteria: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `ocupacion_estanteria` DISABLE KEYS */;
/*!40000 ALTER TABLE `ocupacion_estanteria` ENABLE KEYS */;

-- Volcando estructura para tabla bd_almacen.pasillo
CREATE TABLE IF NOT EXISTS `pasillo` (
  `id_pasillo` int(11) NOT NULL AUTO_INCREMENT,
  `letra_pasillo` varchar(50) NOT NULL,
  `huecos_pasillos` int(11) NOT NULL,
  PRIMARY KEY (`id_pasillo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bd_almacen.pasillo: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `pasillo` DISABLE KEYS */;
REPLACE INTO `pasillo` (`id_pasillo`, `letra_pasillo`, `huecos_pasillos`) VALUES
	(1, 'A', 0),
	(2, 'B', 0),
	(3, 'C', 0);
/*!40000 ALTER TABLE `pasillo` ENABLE KEYS */;

-- Volcando estructura para tabla bd_almacen.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bd_almacen.usuario: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

-- Volcando estructura para disparador bd_almacen.caja_before_delete
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `caja_before_delete` BEFORE DELETE ON `caja` FOR EACH ROW BEGIN

DECLARE Vid_estanteria Int;
DECLARE Vleja_estanteria Int;

SELECT id_estanteria INTO Vid_estanteria FROM ocupacion_estanteria WHERE id_caja=old.id_ca;
SELECT leja_ocupada INTO Vleja_estanteria FROM ocupacion_estanteria WHERE id_caja=old.id_ca;

INSERT INTO caja_backup
(codigo_caja_back, altura_caja_back, anchura_caja_back,profundidad_caja_back,color_caja_back,material_caja_back,contenido_caja_back
,fecha_alta_caja_back,id_estanteria_back,leja_estanteria_back,fecha_salida_caja_back)
VALUES (old.codigo_caja, old.altura, old.anchura, old.profundidad, old.color, old.material_caja, old.contenido, old.fecha_alta_caja, Vid_estanteria,
Vleja_estanteria, CURDATE() );

DELETE FROM ocupacion_estanteria where id_caja=old.id_ca;

UPDATE estanteria SET lejas_ocupadas=lejas_ocupadas-1 WHERE id_estanteria=Vid_estanteria;

END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
