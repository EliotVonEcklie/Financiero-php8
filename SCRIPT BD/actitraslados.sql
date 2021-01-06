-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-01-2020 a las 21:03:00
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cubarral20193011`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actitraslados`
--

CREATE TABLE `actitraslados` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `activo` varchar(50) NOT NULL,
  `motivo` text NOT NULL,
  `cc_ori` varchar(2) NOT NULL,
  `area_ori` varchar(11) NOT NULL,
  `ubicacion_ori` varchar(2) NOT NULL,
  `prototipo_ori` varchar(2) NOT NULL,
  `dispoactivo_ori` varchar(11) NOT NULL,
  `cc_des` varchar(2) NOT NULL,
  `area_des` varchar(11) NOT NULL,
  `ubicacion_des` varchar(2) NOT NULL,
  `prototipo_des` varchar(2) NOT NULL,
  `dispoactivo_des` varchar(11) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `tipomov` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actitraslados`
--
ALTER TABLE `actitraslados`
  ADD PRIMARY KEY (`id`,`tipomov`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actitraslados`
--
ALTER TABLE `actitraslados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
