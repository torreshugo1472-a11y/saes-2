-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2026 a las 23:24:28
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
-- Base de datos: `saes2_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id_materia` varchar(50) NOT NULL,
  `nombre_materia` varchar(100) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `parcial_1` decimal(4,2) DEFAULT 0.00,
  `parcial_2` decimal(4,2) DEFAULT 0.00,
  `parcial_3` decimal(4,2) DEFAULT 0.00,
  `final` decimal(4,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_materia`, `nombre_materia`, `id_alumno`, `parcial_1`, `parcial_2`, `parcial_3`, `final`) VALUES
('MAT01', 'Computo', 6, 10.00, 7.00, 8.00, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `identificador` varchar(50) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT 'default.png',
  `rol` enum('directivo','gestion','alumno') NOT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `identificador`, `nombre_completo`, `contrasena`, `foto_perfil`, `rol`, `cargo`, `correo`, `edad`) VALUES
(1, 'ADMIN01', 'Director SAES', '$2y$10$zYMa4mBto/wvKU3TcF/WluNf260XjTi/uO85HX8IdrMzvGHLxT/oq', 'default.png', 'directivo', 'Director General', NULL, NULL),
(4, 'pollito234', 'juan perez', '$2y$10$nWfSuMgCbbajR.bHVomEjOLJA2tg1h5TQ9AwUp1lLL7Nn7y0LIHLm', 'default.png', 'gestion', NULL, 'hata.hata1472@gmail.com', NULL),
(5, 'GEST01', 'Maria Perez', '$2y$10$MQFszCDNk9hOCGXp9qNCkOtEMujpz8ilFKh/HAxxoShkO/hXkwgPW', 'default.png', 'gestion', NULL, 'gestion@saes2.com', NULL),
(6, '2024630757', 'Hugo Adrian Torres Alvarez', '$2y$10$Y2Be/iMjWsjN873kHdcWr.c4YajilD2aAWQhcefTX.jDKM43bYN1a', 'yo.jpg', 'alumno', NULL, NULL, 21);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id_materia`),
  ADD KEY `id_alumno` (`id_alumno`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `identificador` (`identificador`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `materias_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
