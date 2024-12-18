-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-12-2024 a las 20:38:54
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
-- Estructura de tabla para la tabla `arqueologia`
--

CREATE TABLE `arqueologia` (
  `idArqueologia` int(11) NOT NULL,
  `integridad_historica` varchar(255) DEFAULT NULL,
  `estetica` varchar(255) DEFAULT NULL,
  `material` varchar(255) DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `arqueologia`
--

INSERT INTO `arqueologia` (`idArqueologia`, `integridad_historica`, `estetica`, `material`, `Pieza_idPieza`) VALUES
(11, 'buena', 'root', 'root', 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `botanica`
--

CREATE TABLE `botanica` (
  `idBotanica` int(11) NOT NULL,
  `reino` varchar(255) DEFAULT NULL,
  `familia` varchar(255) DEFAULT NULL,
  `especie` varchar(255) DEFAULT NULL,
  `orden` varchar(255) DEFAULT NULL,
  `division` varchar(255) DEFAULT NULL,
  `clase` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `botanica`
--

INSERT INTO `botanica` (`idBotanica`, `reino`, `familia`, `especie`, `orden`, `division`, `clase`, `descripcion`, `Pieza_idPieza`) VALUES
(14, 'root', 'root', 'root', 'root', 'root', 'root', 'root', 36);

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

--
-- Volcado de datos para la tabla `donante`
--

INSERT INTO `donante` (`idDonante`, `nombre`, `apellido`, `fecha`) VALUES
(1, 'root', 'root', '2024-11-28'),
(2, 'Juan', 'Pérez', '2024-11-01'),
(3, 'María', 'López', '2024-10-15'),
(4, 'Carlos', 'González', '2024-09-25'),
(5, 'Ana', 'Martínez', '2024-08-10'),
(6, 'Pedro', 'Rodríguez', '2024-07-05'),
(7, 'Luisa', 'Sánchez', '2024-06-20'),
(8, 'Raúl', 'Ramírez', '2024-05-30'),
(9, 'Laura', 'Hernández', '2024-04-18'),
(10, 'José', 'Fernández', '2024-03-12'),
(11, 'Eva', 'Jiménez', '2024-02-28'),
(12, 'root', 'root', NULL),
(13, 'root', 'root', NULL),
(14, 'root', 'root', NULL),
(15, 'root', 'root', NULL),
(16, 'root', 'root', NULL),
(17, 'root', 'root', NULL),
(18, 'root', 'root', NULL),
(19, 'root', 'root', NULL),
(20, 'root', 'root', NULL),
(21, 'root', 'root', NULL),
(22, 'root', 'root', NULL),
(23, 'root', 'root', NULL),
(24, 'root', 'root', NULL),
(25, 'root', 'root', NULL),
(26, 'root', 'root', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `geologia`
--

CREATE TABLE `geologia` (
  `idGeologia` int(11) NOT NULL,
  `tipo_rocas` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ictiologia`
--

CREATE TABLE `ictiologia` (
  `idIctiologia` int(11) NOT NULL,
  `clasificacion` varchar(255) DEFAULT NULL,
  `especies` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `octologia`
--

CREATE TABLE `octologia` (
  `idOctologia` int(11) NOT NULL,
  `clasificacion` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `especie` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `osteologia`
--

CREATE TABLE `osteologia` (
  `idOsteologia` int(11) NOT NULL,
  `especie` varchar(255) DEFAULT NULL,
  `clasificacion` varchar(255) DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `osteologia`
--

INSERT INTO `osteologia` (`idOsteologia`, `especie`, `clasificacion`, `Pieza_idPieza`) VALUES
(17, 'root', 'root', 35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paleontologia`
--

CREATE TABLE `paleontologia` (
  `idPaleontologia` int(11) NOT NULL,
  `era` varchar(255) DEFAULT NULL,
  `periodo` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `paleontologia`
--

INSERT INTO `paleontologia` (`idPaleontologia`, `era`, `periodo`, `descripcion`, `Pieza_idPieza`) VALUES
(24, 'Mesozoico', 'Ordovícico', 'root', 34);

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

--
-- Volcado de datos para la tabla `pieza`
--

INSERT INTO `pieza` (`idPieza`, `num_inventario`, `especie`, `estado_conservacion`, `fecha_ingreso`, `cantidad_de_piezas`, `clasificacion`, `observacion`, `imagen`, `Donante_idDonante`) VALUES
(14, 'INV-002', 'Especie Ejemplo 2', 'Regular', '2024-11-05', '3', 'Osteología', 'Observación 2', 'imagen2.jpg', 1),
(21, 'INV-009', 'Especie Ejemplo 9', 'Excelente', '2024-11-18', '3', 'Paleontología', 'Observación 9', 'imagen9.jpg', 1),
(22, 'INV-010', 'Especie Ejemplo 10', 'Mal Estado', '2024-11-20', '2', 'Osteología', 'Observación 10', 'imagen10.jpg', 1),
(23, 'root', 'root', 'root', '2024-12-08', '1', 'Arqueología', 'root', 'root', 1),
(24, 'rootAr', 'root', 'root', '2024-12-18', '1', 'Arqueología', 'root', NULL, 12),
(25, 'rootAr', 'root', 'root', '2024-12-18', '1', 'Arqueología', 'root', NULL, 13),
(34, 'root', 'root', 'root', '2024-12-09', '1', 'Paleontología', 'root', NULL, 22),
(35, 'root', 'root', 'root', '2024-12-09', '1', 'Osteología', 'root', NULL, 23),
(36, 'root', 'root', 'root', '2024-12-09', '1', 'Botánica', 'root', NULL, 24),
(38, 'root', 'root', 'root', '2024-12-09', '1', 'Arqueología', 'root', NULL, 26);

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
(1, '12121212', 'root', 'admin', 'admin@gmail.com', '1234', '2024-11-12', 'administrador'),
(2, '43766375', 'tiago', 'raminelli', 'tiagoraminelli@gmail.com', '$2y$10$fmRdKsqYvjgTtn./.EwU4OCKla0FrFIblyuPuIxHalDls94AmYvsi', '2024-12-05', 'gerente'),
(3, '10000000', 'admin', 'admin', 'admin@gmail.com', '12345678', '2024-12-17', 'administrador'),
(4, '12341', 'root', 'root', 'root@gmail.com', '$2y$10$xlvjJmuFhYPfCOcEW2kboOYgyXqKHeF9odTplMgfBGC2ph/2aaLz2', NULL, 'gerente'),
(5, '12341', 'root', 'root', 'root@gmail.com', '$2y$10$mNwF2dIfOe144WSSOzdOdeLWVSOOamdddmxpEPBTst1YdZOfEMBHu', NULL, 'gerente'),
(6, '1231111', 'root', 'root', 'root@gmail.com', '$2y$10$eiqztby.JmSz5uLzyH./Lu.c2r2zgEECgWnxFtlbErsaPUs7z82PO', '2024-12-17', 'gerente'),
(7, '12312223', 'root', 'root', 'test@example.us', '$2y$10$SgGvhbySOgaNZm0OB7yHquSQXuVFQJsY9WD6pVAz6C6sI6ejQH55q', '2024-12-17', 'gerente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zoologia`
--

CREATE TABLE `zoologia` (
  `idZoologia` int(11) NOT NULL,
  `reino` varchar(255) DEFAULT NULL,
  `familia` varchar(255) DEFAULT NULL,
  `especie` varchar(255) DEFAULT NULL,
  `orden` varchar(255) DEFAULT NULL,
  `phylum` varchar(255) DEFAULT NULL,
  `clase` varchar(255) DEFAULT NULL,
  `genero` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `arqueologia`
--
ALTER TABLE `arqueologia`
  ADD PRIMARY KEY (`idArqueologia`),
  ADD KEY `fk_Arqueologia_Pieza1_idx` (`Pieza_idPieza`);

--
-- Indices de la tabla `botanica`
--
ALTER TABLE `botanica`
  ADD PRIMARY KEY (`idBotanica`),
  ADD KEY `fk_Botanica_Pieza1_idx` (`Pieza_idPieza`);

--
-- Indices de la tabla `donante`
--
ALTER TABLE `donante`
  ADD PRIMARY KEY (`idDonante`);

--
-- Indices de la tabla `geologia`
--
ALTER TABLE `geologia`
  ADD PRIMARY KEY (`idGeologia`),
  ADD KEY `fk_Geologia_Pieza1_idx` (`Pieza_idPieza`);

--
-- Indices de la tabla `ictiologia`
--
ALTER TABLE `ictiologia`
  ADD PRIMARY KEY (`idIctiologia`),
  ADD KEY `fk_Ictiologia_Pieza1_idx` (`Pieza_idPieza`);

--
-- Indices de la tabla `octologia`
--
ALTER TABLE `octologia`
  ADD PRIMARY KEY (`idOctologia`),
  ADD KEY `fk_Octologia_Pieza1_idx` (`Pieza_idPieza`);

--
-- Indices de la tabla `osteologia`
--
ALTER TABLE `osteologia`
  ADD PRIMARY KEY (`idOsteologia`),
  ADD KEY `fk_Osteologia_Pieza1_idx` (`Pieza_idPieza`);

--
-- Indices de la tabla `paleontologia`
--
ALTER TABLE `paleontologia`
  ADD PRIMARY KEY (`idPaleontologia`),
  ADD KEY `fk_Paleontologia_Pieza1_idx` (`Pieza_idPieza`);

--
-- Indices de la tabla `pieza`
--
ALTER TABLE `pieza`
  ADD PRIMARY KEY (`idPieza`),
  ADD KEY `fk_donante` (`Donante_idDonante`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `zoologia`
--
ALTER TABLE `zoologia`
  ADD PRIMARY KEY (`idZoologia`),
  ADD KEY `fk_Zoologia_Pieza1_idx` (`Pieza_idPieza`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `arqueologia`
--
ALTER TABLE `arqueologia`
  MODIFY `idArqueologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `botanica`
--
ALTER TABLE `botanica`
  MODIFY `idBotanica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `donante`
--
ALTER TABLE `donante`
  MODIFY `idDonante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `geologia`
--
ALTER TABLE `geologia`
  MODIFY `idGeologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `ictiologia`
--
ALTER TABLE `ictiologia`
  MODIFY `idIctiologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `octologia`
--
ALTER TABLE `octologia`
  MODIFY `idOctologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `osteologia`
--
ALTER TABLE `osteologia`
  MODIFY `idOsteologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `paleontologia`
--
ALTER TABLE `paleontologia`
  MODIFY `idPaleontologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `pieza`
--
ALTER TABLE `pieza`
  MODIFY `idPieza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `zoologia`
--
ALTER TABLE `zoologia`
  MODIFY `idZoologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `arqueologia`
--
ALTER TABLE `arqueologia`
  ADD CONSTRAINT `fk_Arqueologia_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `botanica`
--
ALTER TABLE `botanica`
  ADD CONSTRAINT `fk_Botanica_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `geologia`
--
ALTER TABLE `geologia`
  ADD CONSTRAINT `fk_Geologia_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ictiologia`
--
ALTER TABLE `ictiologia`
  ADD CONSTRAINT `fk_Ictiologia_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `octologia`
--
ALTER TABLE `octologia`
  ADD CONSTRAINT `fk_Octologia_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `osteologia`
--
ALTER TABLE `osteologia`
  ADD CONSTRAINT `fk_Osteologia_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `paleontologia`
--
ALTER TABLE `paleontologia`
  ADD CONSTRAINT `fk_Paleontologia_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pieza`
--
ALTER TABLE `pieza`
  ADD CONSTRAINT `fk_donante` FOREIGN KEY (`Donante_idDonante`) REFERENCES `donante` (`idDonante`) ON DELETE CASCADE;

--
-- Filtros para la tabla `zoologia`
--
ALTER TABLE `zoologia`
  ADD CONSTRAINT `fk_Zoologia_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
