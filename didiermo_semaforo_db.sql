-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 23-07-2025 a las 16:12:00
-- Versión del servidor: 5.7.44-cll-lve
-- Versión de PHP: 8.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `didiermo_semaforo_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avances`
--

CREATE TABLE `avances` (
  `id` int(11) NOT NULL,
  `compromiso_id` int(11) NOT NULL,
  `resumen` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `porcentaje_avance` int(11) DEFAULT NULL,
  `usuario` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_avance` datetime DEFAULT CURRENT_TIMESTAMP,
  `es_finalizacion` tinyint(1) DEFAULT '0',
  `pdf_finalizacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `avances`
--

INSERT INTO `avances` (`id`, `compromiso_id`, `resumen`, `porcentaje_avance`, `usuario`, `fecha_avance`, `es_finalizacion`, `pdf_finalizacion`) VALUES
(1, 1, 'se hizo revisiÃ³n del excel', 0, 'Medios y Nuevas Tecnologías', '2025-06-24 12:51:39', 0, NULL),
(2, 1, 'se transformÃ³ el modelo', 10, 'Medios y Nuevas Tecnologías', '2025-06-24 12:52:10', 0, NULL),
(3, 1, 'terminamos prueba', 100, 'Medios y Nuevas Tecnologías', '2025-06-24 12:52:52', 1, '1750787572_ejemplo.pdf'),
(4, 2, 'asdfasdfasd', 10, 'Medios y Nuevas Tecnologías', '2025-06-25 09:43:46', 0, NULL),
(5, 2, 'dfasdfa', 100, 'Medios y Nuevas Tecnologías', '2025-06-25 09:44:00', 0, NULL),
(6, 2, 'zsdg', 100, 'Medios y Nuevas Tecnologías', '2025-06-25 09:44:30', 1, NULL),
(7, 3, 'wesdfasd', 100, 'Calidad Educativa', '2025-06-25 09:45:23', 1, '1750862723_CIRCULAR NÂ° 013 DE 2025 (1).pdf'),
(8, 4, 'fadfgasdfasdfasdfasdfasdfa', 30, 'Personal Docente', '2025-06-25 09:52:28', 0, NULL),
(9, 4, 'asedfasdfasdf', 20, 'Personal Docente', '2025-06-25 09:52:38', 0, NULL),
(10, 4, 'asdfasdf', 100, 'Personal Docente', '2025-06-25 09:52:55', 1, '1750863175_CIRCULAR NÂ° 013 DE 2025 (1).pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL,
  `compromiso_id` int(11) NOT NULL,
  `direccion_responsable` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `compromiso_id`, `direccion_responsable`, `accion`, `fecha`) VALUES
(1, 1, 'Medios y Nuevas Tecnologías', 'Creado', '2025-06-24 12:51:11'),
(2, 1, 'Medios y Nuevas Tecnologías', 'crear', '2025-06-24 12:51:11'),
(3, 1, 'Medios y Nuevas Tecnologías', 'Finalizado', '2025-06-24 12:52:52'),
(4, 2, 'Medios y Nuevas Tecnologías', 'Creado', '2025-06-25 09:42:06'),
(5, 2, 'Medios y Nuevas Tecnologías', 'crear', '2025-06-25 09:42:06'),
(6, 3, 'Calidad Educativa', 'Creado', '2025-06-25 09:42:50'),
(7, 3, 'Calidad Educativa', 'crear', '2025-06-25 09:42:50'),
(8, 2, 'Medios y Nuevas Tecnologías', 'Finalizado', '2025-06-25 09:44:30'),
(9, 3, 'Calidad Educativa', 'Finalizado', '2025-06-25 09:45:23'),
(10, 4, 'Personal Docente', 'Creado', '2025-06-25 09:51:04'),
(11, 4, 'Personal Docente', 'crear', '2025-06-25 09:51:04'),
(12, 4, 'Personal Docente', 'Finalizado', '2025-06-25 09:52:55'),
(13, 5, 'Medios y Nuevas Tecnologías', 'Creado', '2025-07-21 16:51:28'),
(14, 5, 'Medios y Nuevas Tecnologías', 'crear', '2025-07-21 16:51:28'),
(15, 6, 'Medios y Nuevas Tecnologías', 'Creado', '2025-07-23 10:54:28'),
(16, 6, 'Medios y Nuevas Tecnologías', 'crear', '2025-07-23 10:54:28'),
(17, 7, 'Medios y Nuevas Tecnologías', 'Creado', '2025-07-23 14:37:07'),
(18, 7, 'Medios y Nuevas Tecnologías', 'crear', '2025-07-23 14:37:07'),
(19, 8, 'Medios y Nuevas Tecnologías', 'Creado', '2025-07-23 14:41:49'),
(20, 8, 'Medios y Nuevas Tecnologías', 'crear', '2025-07-23 14:41:50'),
(21, 9, 'Medios y Nuevas Tecnologías', 'Creado', '2025-07-23 14:54:47'),
(22, 9, 'Medios y Nuevas Tecnologías', 'crear', '2025-07-23 14:54:47'),
(23, 10, 'Medios y Nuevas Tecnologías', 'Creado', '2025-07-23 15:30:43'),
(24, 10, 'Medios y Nuevas Tecnologías', 'crear', '2025-07-23 15:30:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compromisos`
--

CREATE TABLE `compromisos` (
  `id` int(11) NOT NULL,
  `compromiso_especifico` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion_responsable` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `finalizado` tinyint(1) DEFAULT '0',
  `pdf_finalizacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compromisos`
--

INSERT INTO `compromisos` (`id`, `compromiso_especifico`, `direccion_responsable`, `finalizado`, `pdf_finalizacion`, `fecha_creacion`) VALUES
(1, 'Crear tableros en power bi', 'Medios y Nuevas Tecnologías', 1, '1750787572_ejemplo.pdf', '2025-06-24 12:51:11'),
(2, 'creaciÃ³n de tablero de control', 'Medios y Nuevas Tecnologías', 1, NULL, '2025-06-25 09:42:06'),
(3, 'Reporte a entidades de control ', 'Calidad Educativa', 1, '1750862723_CIRCULAR NÂ° 013 DE 2025 (1).pdf', '2025-06-25 09:42:50'),
(4, 'Indicadores trimestrales \"Oportunidad en el trÃ¡mite de las prestaciones sociales â€“ FONPREMAG 6628\"', 'Personal Docente', 1, '1750863175_CIRCULAR NÂ° 013 DE 2025 (1).pdf', '2025-06-25 09:51:04'),
(9, 'aa', 'Medios y Nuevas Tecnologías', 0, NULL, '2025-07-23 14:54:47'),
(10, 'bbb', 'Medios y Nuevas Tecnologías', 0, NULL, '2025-07-23 15:30:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Administrativa y Financiera'),
(3, 'Buen Gobierno'),
(4, 'Calidad Educativa'),
(5, 'Cobertura Educativa'),
(6, 'Despacho'),
(7, 'Educación Superior'),
(8, 'Infraestructura Educativa'),
(9, 'Medios y Nuevas Tecnologías'),
(10, 'Oficina Asesora de Planeación'),
(11, 'Oficina Asesora Jurídica'),
(12, 'Personal Docente'),
(13, 'Subsecretaría'),
(14, 'Transporte');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `avances`
--
ALTER TABLE `avances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compromiso_id` (`compromiso_id`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compromisos`
--
ALTER TABLE `compromisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `avances`
--
ALTER TABLE `avances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `compromisos`
--
ALTER TABLE `compromisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `avances`
--
ALTER TABLE `avances`
  ADD CONSTRAINT `avances_ibfk_1` FOREIGN KEY (`compromiso_id`) REFERENCES `compromisos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
