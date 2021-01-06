-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 02-11-2018 a las 09:35:33
-- Versión del servidor: 5.1.41
-- Versión de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `contable_cumaribo20181026`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actiactorecuperacion`
--

CREATE TABLE IF NOT EXISTS `actiactorecuperacion` (
  `id` double NOT NULL,
  `fecha` date NOT NULL,
  `docdonante` varchar(500) NOT NULL,
  `nomdonante` varchar(200) NOT NULL,
  `valortotal` double NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `lugarfisico` varchar(200) NOT NULL,
  `motivo` varchar(500) NOT NULL,
  `otrosdetalles` varchar(500) NOT NULL,
  `estado` enum('A','S','N') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indestado` (`estado`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `actiactorecuperacion`
--
INSERT INTO opciones(nom_opcion,ruta_opcion,niv_opcion,est_opcion,orden,modulo,especial,comando) VALUES ('Menu de Actos','acti-menuactos.php',3,'1',3,6,'','')

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
