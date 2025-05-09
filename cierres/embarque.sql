-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 24-04-2025 a las 07:26:12
-- Versión del servidor: 9.2.0
-- Versión de PHP: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `embarque`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasajeros`
--

CREATE TABLE `pasajeros` (
  `id` int DEFAULT NULL,
  `creacion` datetime DEFAULT NULL,
  `f_entrada` date DEFAULT NULL,
  `fsalida` date DEFAULT NULL,
  `f_actualizada` datetime DEFAULT NULL,
  `n_noches` varchar(10) DEFAULT NULL,
  `origen` varchar(50) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `anulada_por` varchar(100) DEFAULT NULL,
  `producto` varchar(150) DEFAULT NULL,
  `hora` varchar(20) DEFAULT NULL,
  `ocupacion` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido_1` varchar(100) DEFAULT NULL,
  `apellido_2` varchar(100) DEFAULT NULL,
  `e_mail` varchar(150) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `comentario` text,
  `comentario_interno` text,
  `estado` varchar(50) DEFAULT NULL,
  `importe` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `factura` varchar(50) DEFAULT NULL,
  `adultos` int DEFAULT NULL,
  `ninos` int DEFAULT NULL,
  `senior` int DEFAULT NULL,
  `gratis` int DEFAULT NULL,
  `checked` int NOT NULL DEFAULT '0',
  `subidos` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
DELIMITER $$
CREATE TRIGGER `copia_valor` BEFORE INSERT ON `pasajeros` FOR EACH ROW BEGIN
    IF NEW.subidos IS NULL THEN
        SET NEW.subidos = NEW.ninos + NEW.adultos + new.gratis;
    END IF;
END
$$
DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
