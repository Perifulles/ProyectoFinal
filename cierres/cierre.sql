-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 17-05-2025 a las 06:14:42
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
-- Base de datos: `cierre`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido1` varchar(100) DEFAULT NULL,
  `apellido2` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `apellido1`, `apellido2`, `email`, `telefono`) VALUES
(260642, 'Natalia', 'Gómez', 'Torres', 'natalia.gomez@example.com', '677901234'),
(261155, 'Lucía', 'Torres', 'Pérez', 'lucia.torres@example.com', '656789012'),
(265262, 'LUCAS', 'NAVARRO', 'RIVERA', 'lucas.navarro@mail.com', '+34 600112233'),
(265831, 'Noelia', 'León', 'Gómez', 'noelia.leon@example.com', '677901236'),
(265886, 'carlos alonso', 'pérez', 'martínez', 'calonso@hotmail.com', '+34 611223344'),
(265918, 'Noelia', 'Ramírez', 'Soler', 'noeliasoler@mail.com', '+34 622334455'),
(265957, 'Daniel', 'Roca', NULL, 'daniel.roca@mail.com', '+34 633445566'),
(265962, 'CAMILA', 'VILLANUEVA', NULL, 'camila.villa@mail.com', '+34 644556677'),
(265980, 'Raquel', 'Domínguez', 'Llorente', 'raquel.dominguez@mail.com', '+34 655667788'),
(266008, 'Pilar', 'Sánchez Blasco', NULL, 'pilarsb@mail.com', '+34 666778899'),
(266052, 'Marcos', 'Herrero Ruiz', NULL, 'mherrero42@mail.com', '+34 677889900'),
(266062, 'Laura', 'Martínez', 'Gómez', 'laura.martinez@example.com', '612345678'),
(266063, 'Pablo', 'Rodríguez', 'Sánchez', 'pablo.rodriguez@example.com', '623456789'),
(266064, 'Carmen', 'López', 'Fernández', 'carmen.lopez@example.com', '634567890'),
(266065, 'Javier', 'García', 'Moreno', 'javier.garcia@example.com', '645678901'),
(266069, 'Andrés', 'Ruiz', 'Martínez', 'andres.ruiz@example.com', '667890123'),
(266070, 'Sara', 'Herrera', 'Jiménez', 'sara.herrera@example.com', '678901234'),
(266071, 'Álvaro', 'Morales', 'Castro', 'alvaro.morales@example.com', '689012345'),
(266072, 'Beatriz', 'Vargas', 'Delgado', 'beatriz.vargas@example.com', '690123456'),
(266073, 'David', 'Navarro', 'Ortega', 'david.navarro@example.com', '601234567'),
(266074, 'Elena', 'Romero', 'Gil', 'elena.romero@example.com', '611345678'),
(266075, 'Hugo', 'Ramos', 'Cano', 'hugo.ramos@example.com', '622456789'),
(266076, 'Paula', 'Medina', 'León', 'paula.medina@example.com', '633567890'),
(266077, 'Marcos', 'Iglesias', 'Bravo', 'marcos.iglesias@example.com', '644678901'),
(266078, 'Isabel', 'Domínguez', 'Núñez', 'isabel.dominguez@example.com', '655789012'),
(266079, 'Tomás', 'Sánchez', 'Rubio', 'tomas.sanchez@example.com', '666890123'),
(266084, 'Víctor', 'Delgado', 'Ríos', 'victor.delgado@example.com', '688012345'),
(266086, 'Ana', 'Gil', 'Serrano', 'ana.gil@example.com', '699123456'),
(266087, 'Francisco', 'Morales', 'Pascual', 'francisco.morales@example.com', '600234567'),
(266090, 'Nuria', 'León', 'Molina', 'nuria.leon@example.com', '611345679'),
(266091, 'Óscar', 'Cano', 'Bravo', 'oscar.cano@example.com', '622456780'),
(266092, 'Silvia', 'Castro', 'Ramos', 'silvia.castro@example.com', '633567891'),
(266093, 'Alejandro', 'Pérez', 'Romero', 'alejandro.perez@example.com', '644678902'),
(266098, 'Irene', 'Rubio', 'García', 'irene.rubio@example.com', '655789013'),
(266099, 'Sergio', 'Ortega', 'Jiménez', 'sergio.ortega@example.com', '666890124'),
(266100, 'Aitana', 'Núñez', 'López', 'aitana.nunez@example.com', '677901235'),
(266102, 'Daniel', 'Fernández', 'Herrera', 'daniel.fernandez@example.com', '688012346'),
(266103, 'Clara', 'Molina', 'Rodríguez', 'clara.molina@example.com', '699123457'),
(266104, 'Luis', 'Bravo', 'Sánchez', 'luis.bravo@example.com', '600234568'),
(266105, 'Teresa', 'Serrano', 'Morales', 'teresa.serrano@example.com', '611345670'),
(266106, 'Iván', 'Ríos', 'León', 'ivan.rios@example.com', '622456781'),
(266108, 'Marta', 'Pascual', 'Cano', 'marta.pascual@example.com', '633567892'),
(266109, 'Adrián', 'Gil', 'Vargas', 'adrian.gil@example.com', '644678903'),
(266110, 'Julia', 'Medina', 'Domínguez', 'julia.medina@example.com', '655789014'),
(266111, 'Rubén', 'Iglesias', 'Navarro', 'ruben.iglesias@example.com', '666890125'),
(266114, 'Guillermo', 'López', 'García', 'guillermo.lopez@example.com', '688012347'),
(266115, 'Patricia', 'Delgado', 'Moreno', 'patricia.delgado@example.com', '699123458'),
(266116, 'Raúl', 'Vargas', 'Pérez', 'raul.vargas@example.com', '600234569'),
(266118, 'Sonia', 'Ortega', 'Herrera', 'sonia.ortega@example.com', '611345671'),
(266119, 'Mateo', 'Torres', 'Ramos', 'mateo.torres@example.com', '622456782'),
(266120, 'Celia', 'Romero', 'Bravo', 'celia.romero@example.com', '633567893'),
(266121, 'Joaquín', 'Morales', 'Molina', 'joaquin.morales@example.com', '644678904'),
(266122, 'Alicia', 'Navarro', 'Sánchez', 'alicia.navarro@example.com', '655789015'),
(266125, 'Mario', 'Gil', 'Cano', 'mario.gil@example.com', '666890126'),
(266126, 'Eva', 'Rodríguez', 'León', 'eva.rodriguez@example.com', '677901237'),
(266127, 'Samantha', 'Pérez', 'Sánchez', 'samdssd@gmail.com', '+34 637276216'),
(266141, 'Andrés', 'Vidal', 'Ortega', 'andres.vidal@mail.com', '+34 699001122'),
(266158, 'Tomás', 'Moreno', 'Esteban', 't.moreno@mail.com', '+34 611112233'),
(266167, 'Irene', 'Rubio', NULL, 'irenerubio@mail.com', '+34 622223344'),
(266175, 'Antonio', 'Garrido Gómez', NULL, 'antoniogarrido@mail.com', '+34 633334455'),
(266179, 'CLARA', 'León', 'ALBERT', 'clara.leonalbert@mail.com', '+34 644445566');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_entrada` date DEFAULT NULL,
  `fecha_salida` date DEFAULT NULL,
  `fecha_actualizada` datetime DEFAULT NULL,
  `origen` varchar(50) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `anulada_por` varchar(200) DEFAULT NULL,
  `producto` varchar(100) DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `ocupacion` varchar(50) DEFAULT NULL,
  `comentario` text,
  `comentario_interno` text,
  `estado` varchar(50) DEFAULT NULL,
  `importe` varchar(500) DEFAULT NULL,
  `factura` varchar(100) DEFAULT NULL,
  `visa` decimal(10,2) DEFAULT NULL,
  `efectivo` decimal(10,2) DEFAULT NULL,
  `id_cliente` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `fecha_creacion`, `fecha_entrada`, `fecha_salida`, `fecha_actualizada`, `origen`, `usuario`, `anulada_por`, `producto`, `hora`, `ocupacion`, `comentario`, `comentario_interno`, `estado`, `importe`, `factura`, `visa`, `efectivo`, `id_cliente`) VALUES
(260642, '2002-12-24 12:34:43', '2025-05-02', NULL, '2002-05-25 11:10:15', 'Planning', 'hermi@suaventura.com', '-', 'DTO. CRUCERO GRUPO  +25 PAX', '11:30:00', 'A57, N0, S0, G1', 'ver os', NULL, 'Confirmada', '1083,00€ Pagada, revisar historico de pagos <div class=\"text-right\"><b class=\"importe\">1083,00€ <i class=\"fa fa-money-bill-alt ico-reserva-cobrada\" title=\"Cobrada total\" alt=\"Cobrada total\"></i> <span class=\"estadoPago\">\nPagada, revisar historico de pagos</span>\n<b class=\"metodoPago\">', 'No Facturada', NULL, NULL, 260642),
(261155, '2015-01-25 12:04:26', '2025-05-02', NULL, '2002-05-25 09:40:22', 'Planning', 'hermi@suaventura.com', '-', 'PACK ESPECIAL AGENCIAS', '13:00:00', 'A51, N0, S0, G1', 'No tiene comentarios', NULL, 'Confirmada', '1938,00€ Pagada T.Bancaria', 'No Facturada', NULL, NULL, 261155),
(265831, '2029-04-25 14:54:49', '2025-05-02', NULL, '2002-05-25 16:47:28', 'Planning', 'agencia@suaventura.com', '-', 'CRUCERO DIVULGOTURIA', '10:00:00', 'A25, N0, S0, G0', 'efec agencia 020525, vienen 19 se cobran 25', NULL, 'Confirmada', '325,00€ Pagada Establecimiento', 'No Facturada', NULL, 325.00, 265831),
(266062, '2002-05-25 07:54:41', '2025-05-09', NULL, '2002-05-25 07:56:00', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '11:00:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '40,00€ Pagada T.Crédito', 'No Facturada', 40.00, NULL, 266062),
(266063, '2002-05-25 08:33:14', '2025-05-10', NULL, '2002-05-25 08:35:22', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '13:00:00', 'A1, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '20,00€ Pagada T.Crédito', 'No Facturada', 20.00, NULL, 266063),
(266064, '2002-05-25 08:59:34', '2025-05-02', NULL, '2002-05-25 09:00:01', 'Planning', 'agencia@suaventura.com', '-', 'TREN COFRENTES - HERVIDEROS REGRESO', '10:30:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '16,00€ Pagada Establecimiento', 'No Facturada', NULL, 16.00, 266064),
(266065, '2002-05-25 09:11:21', '2025-05-02', NULL, '2002-05-25 09:11:35', 'Planning', 'agencia@suaventura.com', '-', 'TREN COFRENTES', '10:00:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '16,00€ Pagada T.Crédito', 'No Facturada', 16.00, NULL, 266065),
(266069, '2002-05-25 09:49:46', '2025-05-03', NULL, '2002-05-25 09:49:47', 'Web', 'reservas@balneario.com', '-', 'CRUCERO POR EL JÚCAR ', '10:00:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '40,00€ Pagada Establecimiento', 'No Facturada', NULL, 40.00, 266069),
(266070, '2002-05-25 09:57:54', '2025-05-04', NULL, '2002-05-25 09:59:45', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '10:00:00', 'A4, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '80,00€ Pagada T.Crédito', 'No Facturada', 80.00, NULL, 266070),
(266071, '2002-05-25 10:05:42', '2025-05-02', NULL, '2002-05-25 10:07:57', 'Planning', 'embarcaderos@suaventura.com', 'aventura@suaventura.com (embarcaderos@suaventura.com)', 'CRUCERO 1 HORA PARTICULARES ', '16:00:00', 'A2, N0, S0, G0', NULL, 'la he puesto por error a las 16:00, la anulo y  la cambio a las 10:00 Miguelijo', 'Anulada', '36,00€ Pagada T.Crédito', 'No Facturada', 36.00, NULL, 266071),
(266072, '2002-05-25 10:16:45', '2025-05-03', NULL, '2002-05-25 10:17:49', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '10:00:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '40,00€ Pagada T.Crédito', 'No Facturada', 40.00, NULL, 266072),
(266073, '2002-05-25 10:20:04', '2025-05-03', NULL, '2002-05-25 10:20:41', 'Planning', 'agencia@suaventura.com', '-', '1º TREN MADERADA', '08:30:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '16,00€ Pagada T.Crédito', 'No Facturada', 16.00, NULL, 266073),
(266074, '2002-05-25 10:30:44', '2025-05-02', NULL, '2002-05-25 10:31:04', 'Planning', 'embarcaderos@suaventura.com', '-', 'CRUCERO 1 HORA PARTICULARES ', '10:00:00', 'A2, N0, S0, G0', NULL, 'cambio por error de la 071', 'Confirmada', '36,00€ Pagada Paypal', 'No Facturada', NULL, NULL, 266074),
(266075, '2002-05-25 10:31:32', '2025-05-03', NULL, '2002-05-25 10:33:45', 'Planning', 'agencia@suaventura.com', '-', 'CRUCERO POR EL JÚCAR ', '14:30:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '40,00€ Pagada T.Crédito', 'No Facturada', 40.00, NULL, 266075),
(266076, '2002-05-25 10:38:01', '2025-06-01', NULL, '2002-05-25 10:38:31', 'Planning', 'agencia@suaventura.com', '-', 'CRUCERO POR EL JÚCAR ', '11:30:00', 'A2, N0, S0, G0', 'sustituye a 265942  cambio del 11/05 al 01/06 amel ', NULL, 'Confirmada', '40,00€ Pagada Paypal', 'No Facturada', 20.00, 10.00, 266076),
(266077, '2002-05-25 10:40:47', '2025-05-03', NULL, '2002-05-25 13:26:53', 'Web', 'Anonimo', 'agencia (agencia@suaventura.com)', 'CRUCERO POR EL JÚCAR ', '17:30:00', 'A1, N0, S0, G0', 'dev web 020525', NULL, 'Anulada', '20,00€ Pagada T.Crédito', 'No Facturada', 20.00, NULL, 266077),
(266078, '2002-05-25 10:41:07', '2025-05-04', NULL, '2002-05-25 10:42:19', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '16:00:00', 'A6, N2, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '149,00€ Pagada T.Crédito', 'No Facturada', 149.00, NULL, 266078),
(266079, '2002-05-25 10:51:07', '2025-05-02', NULL, '2002-05-25 10:51:14', 'Planning', 'embarcaderos@suaventura.com', '-', 'CRUCERO POR EL JÚCAR ', '16:00:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '40,00€ Pagada T.Crédito', 'No Facturada', 40.00, NULL, 266079),
(266084, '2002-05-25 11:32:27', '2025-05-04', NULL, '2002-05-25 11:33:09', 'Planning', 'agencia@suaventura.com', '-', 'TREN VOLCÁN ', '10:00:00', 'A3, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '40,50€ Pagada T.Crédito', 'No Facturada', 40.50, NULL, 266084),
(266086, '2002-05-25 11:55:45', '2025-05-02', NULL, '2002-05-25 11:55:54', 'Planning', 'agencia@suaventura.com', '-', 'TREN + CRUCERO', '15:30:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '52,00€ Pagada T.Crédito', 'No Facturada', 52.00, NULL, 266086),
(266087, '2002-05-25 11:59:33', '2025-05-03', NULL, '2002-05-25 12:01:59', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '14:30:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '40,00€ Pagada T.Crédito', 'No Facturada', 40.00, NULL, 266087),
(266090, '2002-05-25 12:03:58', '2025-05-03', NULL, '2002-05-25 12:04:09', 'Planning', 'agencia@suaventura.com', '-', '1º TREN MADERADA', '08:30:00', 'A1, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '8,00€ Pagada Establecimiento', 'No Facturada', NULL, 8.00, 266090),
(266091, '2002-05-25 12:10:16', '2025-05-03', NULL, '2002-05-25 12:10:30', 'Planning', 'embarcaderos@suaventura.com', '-', 'CRUCERO POR EL JÚCAR ', '14:30:00', 'A4, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '80,00€ Pagada T.Crédito', 'No Facturada', 80.00, NULL, 266091),
(266092, '2002-05-25 12:12:11', '2025-05-03', NULL, '2002-05-25 12:13:16', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '14:30:00', 'A2, N3, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '83,50€ Pagada T.Crédito', 'No Facturada', 83.50, NULL, 266092),
(266093, '2002-05-25 12:24:01', '2025-05-02', NULL, '2002-05-25 12:24:10', 'Planning', 'embarcaderos@suaventura.com', '-', 'CRUCERO POR EL JÚCAR ', '13:00:00', 'A8, N0, S0, G0', NULL, '\n\n5 efect.\n\n2 visa.\n\n1 visa\n\n', 'Confirmada', '160,00€ Pagada Paypal', 'No Facturada', NULL, NULL, 266093),
(266098, '2002-05-25 12:52:06', '2025-05-17', NULL, '2002-05-25 12:53:31', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '16:00:00', 'A4, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '80,00€ Pagada T.Crédito', 'No Facturada', 80.00, NULL, 266098),
(266099, '2002-05-25 13:16:50', '2025-05-04', NULL, '2002-05-25 13:18:46', 'Planning', 'agencia@suaventura.com', '-', 'CRUCERO POR EL JÚCAR ', '10:00:00', 'A4, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '80,00€ Pagada T.Crédito', 'No Facturada', 80.00, NULL, 266099),
(266100, '2002-05-25 13:31:05', '2025-06-14', NULL, '2002-05-25 13:31:05', 'Planning', 'agencia@suaventura.com', '-', 'DTO. AGENCIAS CRUCERO ', '16:00:00', 'A60, N0, S0, G0', 'No tiene comentarios', NULL, 'sin confirmar', '1020,00€ Pdt de pago', 'No Facturada', NULL, NULL, 266100),
(266102, '2002-05-25 14:14:30', '2025-05-03', NULL, '2002-05-25 14:16:00', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '14:30:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '40,00€ Pagada T.Crédito', 'No Facturada', 40.00, NULL, 266102),
(266103, '2002-05-25 14:30:12', '2025-06-01', NULL, '2002-05-25 14:30:12', 'Planning', 'agencia@suaventura.com', '-', 'VIP_SINOA II', '11:00:00', 'A14, N0, S0, G0', 'No tiene comentarios', NULL, 'sin confirmar', '350,00€ Pdt de pago', 'No Facturada', NULL, NULL, 266103),
(266104, '2002-05-25 15:00:56', '2025-05-02', NULL, '2002-05-25 15:02:54', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '16:00:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '40,00€ Pagada T.Crédito', 'No Facturada', 40.00, NULL, 266104),
(266105, '2002-05-25 15:24:02', '2025-05-04', NULL, '2002-05-25 15:25:19', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '16:00:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '40,00€ Pagada T.Crédito', 'No Facturada', 40.00, NULL, 266105),
(266106, '2002-05-25 15:30:22', '2025-05-03', NULL, '2002-05-25 16:28:54', 'Web', 'Anonimo', 'agencia (agencia@suaventura.com)', 'CRUCERO POR EL JÚCAR ', '14:30:00', 'A1, N3, S0, G0', 'reserva duplicada (amel)', NULL, 'Anulada', '63,50€ Pdt de pago', 'No Facturada', NULL, NULL, 266106),
(266108, '2002-05-25 15:35:07', '2025-05-03', NULL, '2002-05-25 15:35:07', 'Web', 'info@cofrentesturismoactivo.com', '-', 'CRUCERO POR EL JÚCAR ', '14:30:00', 'A5, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '100,00€ Pagada Establecimiento', 'No Facturada', NULL, 100.00, 266108),
(266109, '2002-05-25 15:38:19', '2025-05-10', NULL, '2002-05-25 15:38:19', 'Web', 'info@cofrentesturismoactivo.com', '-', 'CRUCERO POR EL JÚCAR ', '10:00:00', 'A8, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '160,00€ Pagada Establecimiento', 'No Facturada', NULL, 160.00, 266109),
(266110, '2002-05-25 15:53:42', '2025-05-03', NULL, '2002-05-25 15:59:40', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '13:00:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '40,00€ Pagada T.Crédito', 'No Facturada', 40.00, NULL, 266110),
(266111, '2002-05-25 16:16:26', '2025-05-03', NULL, '2002-05-25 16:16:35', 'Planning', 'agencia@suaventura.com', '-', '1º TREN MADERADA', '08:30:00', 'A5, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '40,00€ Pagada Establecimiento', 'No Facturada', NULL, 40.00, 266111),
(266114, '2002-05-25 17:46:51', '2025-05-03', NULL, '2002-05-25 17:48:49', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '14:30:00', 'A1, N2, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '49,00€ Pagada T.Crédito', 'No Facturada', 49.00, NULL, 266114),
(266115, '2002-05-25 18:14:25', '2025-05-03', NULL, '2002-05-25 18:14:50', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '14:30:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Fallo TPV', '40,00€ Pdt de pago', 'No Facturada', NULL, NULL, 266115),
(266116, '2002-05-25 18:16:36', '2025-05-03', NULL, '2002-05-25 18:17:58', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '14:30:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '40,00€ Pagada T.Crédito', 'No Facturada', 40.00, NULL, 266116),
(266118, '2002-05-25 18:47:09', '2025-05-03', NULL, '2002-05-25 18:48:35', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '14:30:00', 'A2, N1, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '54,50€ Pagada T.Crédito', 'No Facturada', 54.50, NULL, 266118),
(266119, '2002-05-25 19:01:50', '2025-05-03', NULL, '2002-05-25 19:02:33', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '14:30:00', 'A1, N3, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '63,50€ Pagada T.Crédito', 'No Facturada', 63.50, NULL, 266119),
(266120, '2002-05-25 19:13:11', '2025-05-24', NULL, '2002-05-25 19:16:42', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '11:30:00', 'A1, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '20,00€ Pagada T.Crédito', 'No Facturada', 20.00, NULL, 266120),
(266121, '2002-05-25 20:01:23', '2025-05-03', NULL, '2002-05-25 20:02:40', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '14:30:00', 'A2, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '40,00€ Pagada T.Crédito', 'No Facturada', 40.00, NULL, 266121),
(266122, '2002-05-25 20:17:41', '2025-05-10', NULL, '2002-05-25 20:23:48', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '13:00:00', 'A4, N0, S0, G0', 'No tiene comentarios', NULL, 'Confirmada', '80,00€ Pagada T.Crédito', 'No Facturada', 80.00, NULL, 266122),
(266125, '2002-05-25 21:19:34', '2025-05-10', NULL, '2002-05-25 21:20:32', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '13:00:00', 'A4, N0, S0, G0', 'No tiene comentarios', NULL, 'Fallo TPV', '80,00€ Pdt de pago', 'No Facturada', NULL, NULL, 266125),
(266126, '2002-05-25 21:25:20', '2025-05-10', NULL, '2002-05-25 21:26:25', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '13:00:00', 'A4, N0, S0, G0', 'No tiene comentarios', NULL, 'Fallo TPV', '80,00€ Pdt de pago', 'No Facturada', NULL, NULL, 266126),
(266127, '2002-05-25 21:28:37', '2025-05-10', NULL, '2002-05-25 21:29:09', 'Web', 'Anonimo', '-', 'CRUCERO POR EL JÚCAR ', '13:00:00', 'A4, N0, S0, G0', 'No tiene comentarios', NULL, 'Fallo TPV', '80,00€ Pdt de pago', 'No Facturada', NULL, NULL, 266127);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
