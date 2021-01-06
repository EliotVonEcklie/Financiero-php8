-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-12-2018 a las 03:24:27
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
-- Estructura de tabla para la tabla `almtraslados`
--

CREATE TABLE `almtraslados` (
  `codigo` int(11) NOT NULL,
  `coddocumento` int(11) NOT NULL,
  `coddetalleentrada` int(11) NOT NULL,
  `coddetallesalida` int(11) NOT NULL,
  `codarticulo` varchar(20) NOT NULL,
  `unspsc` varchar(20) NOT NULL,
  `tipotraslado` varchar(20) NOT NULL,
  `cuenta` varchar(25),
  `estado` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almtraslados`
--
ALTER TABLE `almtraslados`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almtraslados`
--
ALTER TABLE `almtraslados`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
