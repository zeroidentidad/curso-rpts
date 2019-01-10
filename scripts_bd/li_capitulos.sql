-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-06-2018 a las 09:44:01
-- Versión del servidor: 5.5.51-38.2
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pacoarce_juegos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `li_capitulos`
--

CREATE TABLE `li_capitulos` (
  `id` int(11) NOT NULL,
  `libro` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `numero` int(11) NOT NULL,
  `titulo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `objetivo` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `introduccion` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `li_capitulos`
--
ALTER TABLE `li_capitulos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `li_capitulos`
--
ALTER TABLE `li_capitulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
