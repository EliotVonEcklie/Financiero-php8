-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 02-11-2018 a las 09:37:56
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
-- Estructura de tabla para la tabla `actiactorecuperacionpartici`
--

CREATE TABLE IF NOT EXISTS `actiactorecuperacionpartici` (
  `id` double NOT NULL,
  `idacto` double NOT NULL,
  `documento` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cargo` varchar(200) NOT NULL,
  `estado` enum('S','N') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `inidacto` (`idacto`),
  KEY `idestado` (`estado`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `actiactorecuperacionpartici`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
