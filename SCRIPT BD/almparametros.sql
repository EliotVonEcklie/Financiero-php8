-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-11-2018 a las 01:43:49
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 5.6.37

--
-- Base de datos: `contable_cumaribo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almparametros`
--

CREATE TABLE `almparametros` (
  `codigo` int(11) NOT NULL,
  `fecha` varchar(50) NOT NULL,
  `cuentapatrimonio` varchar(20) NOT NULL,
  `cuentaorigen` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `almparametros`
--

INSERT INTO `almparametros` (`codigo`, `fecha`, `cuentapatrimonio`, `cuentaorigen`) VALUES
(4, '2018-11-25', '111005055', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almparametros`
--
ALTER TABLE `almparametros`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almparametros`
--
ALTER TABLE `almparametros`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;
