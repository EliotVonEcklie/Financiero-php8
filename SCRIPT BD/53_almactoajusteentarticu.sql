-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-11-2018 a las 13:04:51
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `contable_cumaribo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almactoajusteentarticu`
--

CREATE TABLE `almactoajusteentarticu` (
  `id` double NOT NULL,
  `idacto` double NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `unumedida` varchar(100) NOT NULL,
  `cantidad` double NOT NULL,
  `valor` double NOT NULL,
  `estadou` enum('N','U') NOT NULL,
  `estado` enum('S','N') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almactoajusteentarticu`
--
ALTER TABLE `almactoajusteentarticu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idacto` (`idacto`),
  ADD KEY `inestado` (`estado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
