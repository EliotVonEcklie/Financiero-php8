-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-11-2018 a las 13:04:58
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
-- Estructura de tabla para la tabla `almactoajusteentpartici`
--

CREATE TABLE `almactoajusteentpartici` (
  `id` double NOT NULL,
  `idacto` double NOT NULL,
  `documento` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cargo` varchar(200) NOT NULL,
  `estado` enum('S','N') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almactoajusteentpartici`
--
ALTER TABLE `almactoajusteentpartici`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inidacto` (`idacto`),
  ADD KEY `idestado` (`estado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
