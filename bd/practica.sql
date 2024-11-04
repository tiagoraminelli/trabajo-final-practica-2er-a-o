-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2024 a las 04:51:31
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `practica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donante`
--

CREATE TABLE `donante` (
  `idDonante` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pieza`
--

CREATE TABLE `pieza` (
  `idPieza` int(11) NOT NULL,
  `num_inventario` varchar(255) DEFAULT NULL,
  `especie` varchar(255) DEFAULT NULL,
  `estado_conservacion` varchar(255) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `cantidad_de_piezas` varchar(255) DEFAULT NULL,
  `clasificacion` varchar(255) DEFAULT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `Donante_idDonante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacion_pieza_donante`
--

CREATE TABLE `relacion_pieza_donante` (
  `id` int(11) NOT NULL,
  `idPieza` int(11) NOT NULL,
  `idDonante` int(11) NOT NULL,
  `clasificacion` varchar(255) DEFAULT NULL,
  `campo1` varchar(255) DEFAULT NULL,
  `campo2` varchar(255) DEFAULT NULL,
  `campo3` varchar(255) DEFAULT NULL,
  `campo4` varchar(255) DEFAULT NULL,
  `campo5` varchar(255) DEFAULT NULL,
  `campo6` varchar(255) DEFAULT NULL,
  `campo7` varchar(255) DEFAULT NULL,
  `campo8` varchar(255) DEFAULT NULL,
  `campo9` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `tipo_de_usuario` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `dni`, `nombre`, `apellido`, `email`, `clave`, `fecha_alta`, `tipo_de_usuario`) VALUES
(1, '12121212', 'root', 'admin', 'admin@gmail.com', '1234', '2024-11-12', 'administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `donante`
--
ALTER TABLE `donante`
  ADD PRIMARY KEY (`idDonante`);

--
-- Indices de la tabla `pieza`
--
ALTER TABLE `pieza`
  ADD PRIMARY KEY (`idPieza`),
  ADD KEY `fk_donante` (`Donante_idDonante`);

--
-- Indices de la tabla `relacion_pieza_donante`
--
ALTER TABLE `relacion_pieza_donante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPieza` (`idPieza`),
  ADD KEY `idDonante` (`idDonante`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `donante`
--
ALTER TABLE `donante`
  MODIFY `idDonante` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pieza`
--
ALTER TABLE `pieza`
  MODIFY `idPieza` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `relacion_pieza_donante`
--
ALTER TABLE `relacion_pieza_donante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pieza`
--
ALTER TABLE `pieza`
  ADD CONSTRAINT `fk_donante` FOREIGN KEY (`Donante_idDonante`) REFERENCES `donante` (`idDonante`) ON DELETE CASCADE;

--
-- Filtros para la tabla `relacion_pieza_donante`
--
ALTER TABLE `relacion_pieza_donante`
  ADD CONSTRAINT `relacion_pieza_donante_ibfk_1` FOREIGN KEY (`idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE,
  ADD CONSTRAINT `relacion_pieza_donante_ibfk_2` FOREIGN KEY (`idDonante`) REFERENCES `donante` (`idDonante`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
