-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-09-2016 a las 22:14:55
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `prueba`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE IF NOT EXISTS `mensajes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` int(11) NOT NULL,
  `Mensaje` text COLLATE latin1_spanish_ci NOT NULL,
  `Para` int(11) NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=54 ;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`ID`, `Usuario`, `Mensaje`, `Para`, `Fecha`) VALUES
(50, 3, 'Hola, este es un mensaje de Javier para Pedro, corregido', 2, '2016-09-28 17:20:12'),
(51, 1, 'Hola Javier, soy Juan, te envío un mensaje.', 3, '2016-09-28 17:40:36'),
(52, 3, 'ESTE ES UN MENSAJE NUEVO DE javier para PEDRO', 2, '2016-09-28 18:35:55'),
(53, 3, 'Mensaje para JUAN de su amigo JAVIER', 1, '2016-09-28 18:44:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `Clave` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `Email` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Usuario`, `Clave`, `Email`) VALUES
(1, 'Juan', 'Juan', 'juan'),
(2, 'Pedro', 'Pedro', 'Pedro'),
(3, 'Javier', 'Javier', 'javier@ull.es');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
