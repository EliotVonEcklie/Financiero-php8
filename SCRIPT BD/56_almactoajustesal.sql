-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 16-11-2018 a las 11:40:14
-- Versión del servidor: 5.1.41
-- Versión de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `contable_cumaribo20181019`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almactoajustesal`
--

CREATE TABLE IF NOT EXISTS `almactoajustesal` (
  `id` double NOT NULL,
  `fecha` date NOT NULL,
  `doctercero` varchar(500) NOT NULL,
  `nomtercero` varchar(200) NOT NULL,
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
-- Volcar la base de datos para la tabla `almactoajustesal`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
