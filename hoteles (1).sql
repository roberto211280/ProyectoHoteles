-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 14-07-2025 a las 20:09:32
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hoteles`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hoteles`
--

DROP TABLE IF EXISTS `hoteles`;
CREATE TABLE IF NOT EXISTS `hoteles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `ubicacion` varchar(300) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `autor` varchar(100) DEFAULT NULL,
  `publicar` tinyint(1) DEFAULT '0',
  `activo` tinyint(1) DEFAULT '1',
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `hoteles`
--

INSERT INTO `hoteles` (`id`, `titulo`, `descripcion`, `ubicacion`, `provincia`, `costo`, `autor`, `publicar`, `activo`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(3, 'Hotel bella vista', 'bonito', 'Bella vista', 'Panamá', 10.00, 'Cesar', 1, 1, '2025-07-13 11:08:20', '2025-07-13 11:24:13'),
(2, 'Hotel Punta pacifica', 'hotel punta pacifica', 'Punta pacifica', 'Panamá', 100.00, 'Cesar', 1, 1, '2025-07-13 10:38:30', '2025-07-13 11:20:37'),
(4, 'Casco', 'csco', 'Casco', 'Panamá', 12.00, 'Cesar', 1, 1, '2025-07-13 11:23:05', '2025-07-13 11:23:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_hoteles`
--

DROP TABLE IF EXISTS `imagenes_hoteles`;
CREATE TABLE IF NOT EXISTS `imagenes_hoteles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hotel_id` int NOT NULL,
  `ruta` varchar(500) NOT NULL,
  `nombre_original` varchar(255) DEFAULT NULL,
  `fecha_subida` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `hotel_id` (`hotel_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `imagenes_hoteles`
--

INSERT INTO `imagenes_hoteles` (`id`, `hotel_id`, `ruta`, `nombre_original`, `fecha_subida`) VALUES
(1, 1, '../uploads/hoteles/1/6873d4b66f86f_1752421558.png', 'Yoo.png', '2025-07-13 09:45:58'),
(2, 2, '../uploads/hoteles/2/6873e1065acb8_1752424710.jpeg', 'WhatsApp Image 2025-04-09 at 3.25.04 PM (2).jpeg', '2025-07-13 10:38:30'),
(3, 3, '../uploads/hoteles/3/6873e8045112f_1752426500.png', 'Yoo.png', '2025-07-13 11:08:20'),
(4, 4, '../uploads/hoteles/4/6873eb7928629_1752427385.webp', 'manzana.webp', '2025-07-13 11:23:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `creado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rol` enum('admin','usuario') NOT NULL DEFAULT 'usuario',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `activo`, `creado_en`, `rol`) VALUES
(1, 'Andres', 'crandres08@gmail.com', '$2y$10$nahasd6JH7Dx98bFnCOIUO6ar36dnv8sbeOhOnM1JRyUpA0uFdxWq', 1, '2025-07-12 17:08:54', 'admin'),
(9, 'Olga', 'maria@gmail.com', '$2y$10$ts/wg/2CPNzruIbJa/6m.e331pDH7lGA71M9YP2Q/Olq5IM4IUq4y', 1, '2025-07-12 22:25:52', 'usuario'),
(10, 'Carlos', 'admin@correo.com', '$2y$10$LCSSGGi/nfMVpmXY1w4/LuuFMt5hXri5HxVhXBRsEI7GmgdQLg41.', 1, '2025-07-12 22:27:05', 'usuario');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
