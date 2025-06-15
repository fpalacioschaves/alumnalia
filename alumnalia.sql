-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-06-2025 a las 20:59:57
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
-- Base de datos: `alumnalia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `curso_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `fecha_nacimiento`, `curso_id`) VALUES
(128, '2025-06-01', 1),
(129, '2025-06-01', 1),
(130, '0000-00-00', 1),
(131, '0000-00-00', 1),
(132, '0000-00-00', 1),
(133, '0000-00-00', 1),
(134, '0000-00-00', 1),
(135, '0000-00-00', 1),
(136, '0000-00-00', 1),
(137, '0000-00-00', 1),
(138, '0000-00-00', 1),
(139, '0000-00-00', 1),
(140, '0000-00-00', 1),
(141, '0000-00-00', 1),
(142, '0000-00-00', 1),
(143, '0000-00-00', 1),
(144, '0000-00-00', 1),
(145, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE `asignaturas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `curso_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`id`, `nombre`, `descripcion`, `curso_id`) VALUES
(1, 'Bases de Datos', 'Modelo relacional y SQL', 1),
(2, 'Programación', 'Java, POO y estructuras de control', 1),
(3, 'Lenguaje de Marcas', 'HTML, XML, CSS', 1),
(4, 'Entornos de Desarrollo', '', 1),
(5, 'Sistemas Informáticos', '', 1),
(6, 'Digitalización', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `nombre`, `descripcion`) VALUES
(1, '1º DAM/DAW', 'Primer curso del ciclo Desarrollo de Aplicaciones Multiplataforma/Desarrollo de Aplicaciones Web'),
(2, '2º DAM', 'Segundo curso del ciclo Desarrollo de Aplicaciones Multiplataforma'),
(4, '2º DAW', 'Segundo curso del ciclo Desarrollo de Aplicaciones Web');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios`
--

CREATE TABLE `ejercicios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `examen_id` int(11) DEFAULT NULL,
  `enunciado` text DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL CHECK (`tipo` in ('abierta','test','multi')),
  `puntuacion` decimal(5,2) DEFAULT 1.00,
  `orden` int(11) DEFAULT NULL,
  `etiqueta_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejercicios`
--

INSERT INTO `ejercicios` (`id`, `examen_id`, `enunciado`, `tipo`, `puntuacion`, `orden`, `etiqueta_id`) VALUES
(4, 2, 'Devuelve los nombres de los personajes que pertenecen a la casa \"Stark\".', 'abierta', 1.60, 1, 3),
(5, 2, 'Devuelve el nombre de la batalla que se ha librado en \"Meereen\".', 'abierta', 1.60, 2, 3),
(6, 2, 'Devuelve el título del personaje que ha participado en una batalla cuyo resultado ha sido \"Derrota\".', 'abierta', 1.60, 3, 3),
(7, 2, 'Devuelve una lista con los personajes y el número de batallas en las que ha participado cada uno.', 'abierta', 1.60, 4, 4),
(8, 2, 'Devuelve un resumen en XML con todos los nombres de personajes y el nombre de cada batalla, con esta estructura:\r\n\r\n<resumen>\r\n\r\n  <personaje nombre=\"Jon Snow\">\r\n\r\n    <batalla>Batalla de los Bastardos</batalla>\r\n\r\n  </personaje>\r\n\r\n  ...\r\n\r\n</resumen>', 'abierta', 1.60, 5, 4),
(9, 2, 'Devuelve la lista de casas con el número total de victorias obtenidas por sus personajes, ordenada de mayor a menor número de victorias. EL resultado debe tener este formato: \r\n\r\n<casa nombre=\"Stark\" victorias=\"4\"/>\r\n\r\n<casa nombre=\"Lannister\" victorias=\"2\"/>\r\n\r\n<casa nombre=\"Targaryen\" victorias=\"1\"/>\r\n\r\n\r\n<casa nombre=\"Tarth\" victorias=\"1\"/>', 'abierta', 1.60, 6, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas`
--

CREATE TABLE `etiquetas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `etiquetas`
--

INSERT INTO `etiquetas` (`id`, `nombre`) VALUES
(1, 'DML'),
(2, 'POO'),
(3, 'XPath'),
(4, 'XQuery');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiqueta_ejercicio`
--

CREATE TABLE `etiqueta_ejercicio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ejercicio_id` int(11) DEFAULT NULL,
  `etiqueta_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes`
--

CREATE TABLE `examenes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `asignatura_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `examenes`
--

INSERT INTO `examenes` (`id`, `titulo`, `descripcion`, `asignatura_id`, `fecha`, `tipo`) VALUES
(2, 'Examen Final Tercer Trimestre', '', 3, '2025-06-05', 'evaluación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matricula`
--

CREATE TABLE `matricula` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `asignatura_id` int(11) DEFAULT NULL,
  `curso_escolar` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` int(11) NOT NULL,
  `departamento` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `departamento`) VALUES
(146, 'Grados'),
(147, 'Grados'),
(148, 'Grados'),
(149, 'Grados');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_asignatura`
--

CREATE TABLE `profesor_asignatura` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profesor_id` int(11) DEFAULT NULL,
  `asignatura_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesor_asignatura`
--

INSERT INTO `profesor_asignatura` (`id`, `profesor_id`, `asignatura_id`) VALUES
(11, 146, 1),
(12, 146, 3),
(16, 148, 4),
(17, 148, 5),
(18, 147, 2),
(19, 149, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resoluciones`
--

CREATE TABLE `resoluciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `ejercicio_id` int(11) DEFAULT NULL,
  `respuesta_texto` text DEFAULT NULL,
  `respuesta_id` int(11) DEFAULT NULL,
  `puntuacion_obtenida` decimal(5,2) DEFAULT 0.00,
  `fecha_respuesta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resoluciones`
--

INSERT INTO `resoluciones` (`id`, `alumno_id`, `ejercicio_id`, `respuesta_texto`, `respuesta_id`, `puntuacion_obtenida`, `fecha_respuesta`) VALUES
(4, 128, 4, NULL, NULL, 0.00, '2025-06-15 17:36:48'),
(5, 129, 4, NULL, NULL, 1.00, '2025-06-15 17:12:01'),
(6, 130, 4, NULL, NULL, 1.60, '2025-06-15 17:12:11'),
(7, 131, 4, NULL, NULL, 1.00, '2025-06-15 17:12:14'),
(8, 132, 4, NULL, NULL, 0.00, '2025-06-15 17:12:19'),
(9, 133, 4, NULL, NULL, 0.50, '2025-06-15 17:12:22'),
(10, 134, 4, NULL, NULL, 1.60, '2025-06-15 17:12:27'),
(11, 135, 4, NULL, NULL, 1.20, '2025-06-15 17:12:30'),
(12, 136, 4, NULL, NULL, 1.00, '2025-06-15 17:12:32'),
(13, 137, 4, NULL, NULL, 1.00, '2025-06-15 17:12:34'),
(14, 138, 4, NULL, NULL, 0.00, '2025-06-15 17:12:38'),
(15, 139, 4, NULL, NULL, 1.66, '2025-06-15 17:17:22'),
(16, 140, 4, NULL, NULL, 1.60, '2025-06-15 17:12:50'),
(17, 141, 4, NULL, NULL, 1.20, '2025-06-15 17:12:54'),
(18, 142, 4, NULL, NULL, 1.00, '2025-06-15 17:12:56'),
(19, 143, 4, NULL, NULL, 1.00, '2025-06-15 17:12:58'),
(20, 144, 4, NULL, NULL, 0.00, '2025-06-15 17:13:01'),
(21, 145, 4, NULL, NULL, 1.60, '2025-06-15 17:13:07'),
(22, 128, 5, NULL, NULL, 0.00, '2025-06-15 17:36:51'),
(23, 129, 5, NULL, NULL, 1.00, '2025-06-15 17:13:11'),
(24, 130, 5, NULL, NULL, 1.60, '2025-06-15 17:13:15'),
(25, 128, 6, NULL, NULL, 0.00, '2025-06-15 17:36:53'),
(26, 128, 7, NULL, NULL, 0.50, '2025-06-15 17:40:41'),
(27, 128, 8, NULL, NULL, 0.00, '2025-06-15 17:39:16'),
(28, 128, 9, NULL, NULL, 0.50, '2025-06-15 17:40:16'),
(29, 129, 6, NULL, NULL, 1.00, '2025-06-15 17:13:37'),
(30, 129, 7, NULL, NULL, 1.00, '2025-06-15 17:13:38'),
(31, 129, 8, NULL, NULL, 1.00, '2025-06-15 17:13:40'),
(32, 129, 9, NULL, NULL, 1.00, '2025-06-15 17:13:43'),
(33, 130, 6, NULL, NULL, 1.30, '2025-06-15 17:14:00'),
(34, 130, 7, NULL, NULL, 1.40, '2025-06-15 17:14:03'),
(35, 130, 8, NULL, NULL, 1.50, '2025-06-15 17:14:06'),
(36, 130, 9, NULL, NULL, 1.60, '2025-06-15 17:14:10'),
(37, 131, 5, NULL, NULL, 0.00, '2025-06-15 17:14:14'),
(38, 131, 6, NULL, NULL, 1.20, '2025-06-15 17:14:17'),
(39, 131, 7, NULL, NULL, 1.30, '2025-06-15 17:14:21'),
(40, 131, 8, NULL, NULL, 1.40, '2025-06-15 17:14:24'),
(41, 131, 9, NULL, NULL, 1.30, '2025-06-15 17:14:28'),
(42, 132, 5, NULL, NULL, 1.00, '2025-06-15 17:14:30'),
(43, 132, 6, NULL, NULL, 1.00, '2025-06-15 17:14:32'),
(44, 132, 7, NULL, NULL, 1.00, '2025-06-15 17:14:34'),
(45, 132, 8, NULL, NULL, 1.20, '2025-06-15 17:14:36'),
(46, 132, 9, NULL, NULL, 1.50, '2025-06-15 17:14:40'),
(47, 133, 5, NULL, NULL, 0.80, '2025-06-15 17:15:50'),
(48, 133, 6, NULL, NULL, 1.00, '2025-06-15 17:15:53'),
(49, 133, 7, NULL, NULL, 1.20, '2025-06-15 17:15:56'),
(50, 133, 8, NULL, NULL, 1.40, '2025-06-15 17:15:59'),
(51, 133, 9, NULL, NULL, 1.60, '2025-06-15 17:16:02'),
(52, 134, 5, NULL, NULL, 1.60, '2025-06-15 17:16:05'),
(53, 134, 6, NULL, NULL, 1.60, '2025-06-15 17:16:08'),
(54, 134, 7, NULL, NULL, 1.60, '2025-06-15 17:16:16'),
(55, 134, 8, NULL, NULL, 1.60, '2025-06-15 17:16:19'),
(56, 134, 9, NULL, NULL, 1.60, '2025-06-15 17:16:21'),
(57, 135, 5, NULL, NULL, 1.66, '2025-06-15 17:16:30'),
(58, 135, 6, NULL, NULL, 1.66, '2025-06-15 17:16:32'),
(59, 135, 7, NULL, NULL, 1.66, '2025-06-15 17:16:36'),
(60, 135, 8, NULL, NULL, 1.66, '2025-06-15 17:16:38'),
(61, 135, 9, NULL, NULL, 1.66, '2025-06-15 17:16:41'),
(62, 136, 5, NULL, NULL, 1.00, '2025-06-15 17:16:44'),
(63, 136, 6, NULL, NULL, 1.00, '2025-06-15 17:16:45'),
(64, 136, 7, NULL, NULL, 1.00, '2025-06-15 17:16:46'),
(65, 136, 8, NULL, NULL, 1.00, '2025-06-15 17:16:47'),
(66, 136, 9, NULL, NULL, 1.00, '2025-06-15 17:16:49'),
(67, 137, 5, NULL, NULL, 1.00, '2025-06-15 17:16:51'),
(68, 137, 6, NULL, NULL, 0.00, '2025-06-15 17:16:54'),
(69, 137, 7, NULL, NULL, 1.20, '2025-06-15 17:16:56'),
(70, 137, 8, NULL, NULL, 1.40, '2025-06-15 17:17:00'),
(71, 137, 9, NULL, NULL, 1.40, '2025-06-15 17:17:03'),
(72, 138, 5, NULL, NULL, 0.00, '2025-06-15 17:17:06'),
(73, 138, 6, NULL, NULL, 0.00, '2025-06-15 17:17:08'),
(74, 138, 7, NULL, NULL, 1.00, '2025-06-15 17:17:09'),
(75, 138, 8, NULL, NULL, 1.00, '2025-06-15 17:17:11'),
(76, 138, 9, NULL, NULL, 1.00, '2025-06-15 17:17:12'),
(77, 139, 5, NULL, NULL, 1.66, '2025-06-15 17:17:24'),
(78, 139, 6, NULL, NULL, 1.66, '2025-06-15 17:17:27'),
(79, 139, 7, NULL, NULL, 1.66, '2025-06-15 17:17:29'),
(80, 139, 8, NULL, NULL, 1.66, '2025-06-15 17:17:31'),
(81, 139, 9, NULL, NULL, 1.66, '2025-06-15 17:17:34'),
(82, 140, 5, NULL, NULL, 1.00, '2025-06-15 17:17:38'),
(83, 140, 6, NULL, NULL, 1.00, '2025-06-15 17:17:40'),
(84, 140, 7, NULL, NULL, 1.00, '2025-06-15 17:17:41'),
(85, 140, 8, NULL, NULL, 1.00, '2025-06-15 17:17:43'),
(86, 140, 9, NULL, NULL, 1.00, '2025-06-15 17:17:44'),
(87, 141, 5, NULL, NULL, 1.32, '2025-06-15 17:17:50'),
(88, 141, 6, NULL, NULL, 1.22, '2025-06-15 17:17:53'),
(89, 141, 7, NULL, NULL, 1.44, '2025-06-15 17:17:56'),
(90, 141, 8, NULL, NULL, 1.44, '2025-06-15 17:18:00'),
(91, 141, 9, NULL, NULL, 1.33, '2025-06-15 17:18:04'),
(92, 142, 5, NULL, NULL, 1.00, '2025-06-15 17:18:06'),
(93, 142, 6, NULL, NULL, 1.00, '2025-06-15 17:18:07'),
(94, 142, 7, NULL, NULL, 1.00, '2025-06-15 17:18:08'),
(95, 142, 8, NULL, NULL, 1.00, '2025-06-15 17:18:09'),
(96, 142, 9, NULL, NULL, 1.00, '2025-06-15 17:18:14'),
(97, 143, 5, NULL, NULL, 0.00, '2025-06-15 17:18:16'),
(98, 143, 6, NULL, NULL, 1.00, '2025-06-15 17:18:20'),
(99, 143, 7, NULL, NULL, 0.00, '2025-06-15 17:18:22'),
(100, 143, 8, NULL, NULL, 1.00, '2025-06-15 17:18:24'),
(101, 143, 9, NULL, NULL, 1.00, '2025-06-15 17:18:27'),
(102, 144, 5, NULL, NULL, 1.00, '2025-06-15 17:18:32'),
(103, 144, 6, NULL, NULL, 1.00, '2025-06-15 17:18:34'),
(104, 144, 7, NULL, NULL, 1.50, '2025-06-15 17:18:39'),
(105, 144, 8, NULL, NULL, 1.00, '2025-06-15 17:18:41'),
(106, 144, 9, NULL, NULL, 1.00, '2025-06-15 17:18:43'),
(107, 145, 5, NULL, NULL, 1.00, '2025-06-15 17:29:59'),
(108, 145, 6, NULL, NULL, 1.00, '2025-06-15 17:18:52'),
(109, 145, 7, NULL, NULL, 1.00, '2025-06-15 17:18:54'),
(110, 145, 8, NULL, NULL, 1.00, '2025-06-15 17:18:57'),
(111, 145, 9, NULL, NULL, 1.00, '2025-06-15 17:19:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ejercicio_id` int(11) DEFAULT NULL,
  `texto_respuesta` text DEFAULT NULL,
  `es_correcta` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_asignadas`
--

CREATE TABLE `tareas_asignadas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `ejercicio_id` bigint(20) DEFAULT NULL,
  `fecha_asignacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `completado` tinyint(1) DEFAULT 0,
  `estado` enum('sin_enviar','enviado','resuelto') DEFAULT 'sin_enviar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tareas_asignadas`
--

INSERT INTO `tareas_asignadas` (`id`, `alumno_id`, `ejercicio_id`, `fecha_asignacion`, `completado`, `estado`) VALUES
(1, 128, 6, '2025-06-15 17:52:49', 0, 'resuelto'),
(2, 128, 4, '2025-06-15 17:52:52', 0, 'sin_enviar'),
(8, 128, 5, '2025-06-15 17:53:53', 0, 'enviado'),
(10, 128, 7, '2025-06-15 17:58:38', 0, 'sin_enviar'),
(11, 128, 9, '2025-06-15 17:58:39', 0, 'sin_enviar'),
(28, 128, 8, '2025-06-15 18:12:10', 0, 'sin_enviar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password_hash` text DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL CHECK (`tipo` in ('alumno','profesor','admin')),
  `fecha_registro` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password_hash`, `tipo`, `fecha_registro`) VALUES
(127, 'Francisco', 'Palacios Chaves', 'fpalacioschaves@gmail.com', '$2y$10$T5HiHcV9Uh4gWN525snOk.7CHTT3uWHSOrYGKDy/etK3M0kSE4Vfe', 'admin', '2025-06-15'),
(128, 'Ezequiel', 'Aguilera Ruiz', 'ezequielar94@gmail.com', '$2y$10$IeYRnVG9O1Gtvsl3znK5seDFULefNCCAPQwgMPvJgYUb5Ra9tbCfG', 'alumno', '2025-06-15'),
(129, 'Hanna ', 'Andrushchenko', 'hannhand@gmail.com', '$2y$10$lv9cguwOEQ8DxGVd3OQ63.u2/JbRz8Urx8QyWPSOPx8SHLpCBv3lG', 'alumno', '2025-06-15'),
(130, 'Adrián', 'Arroyo García', 'adrianarroyo93@gmail.com', '$2y$10$pIEE3EQfP/lf3yXnHp94i.Lsc9siPl00L6fFYxKig7YnF9C7cb0em', 'alumno', '2025-06-15'),
(131, 'Anis ', 'Benhamed', 'anis02ben@gmail.com', '$2y$10$wT2EV68XJUOs9y.X/JQZzOgw5t2HbXOrGMwDfxagLrLvJxu1wbLe6', 'alumno', '2025-06-15'),
(132, 'Piotrek ', 'Budzowski', 'wilku_pl@hotmail.com', '$2y$10$QzA8CDvkln58nDe/LDT94.uPh7MoIljmOwUtPer94DgN6nj2VLhsa', 'alumno', '2025-06-15'),
(133, 'María Fernanda ', 'Espinoza Álvarez', 'mariajozse2005@hotmail.com', '$2y$10$ry1sVSj5xOsnDhNJQxyB5O/DM4gFPs4WnPPYsiBNPa/8QSxAjVmqS', 'alumno', '2025-06-15'),
(134, 'Javier ', 'Herranz Reina', 'javierherranzreina@gmail.com', '$2y$10$TKiD64/Fj26C9ISGxYxLIuCHp0kCZlAM0B.JFuPRiKZNrgT.A81KK', 'alumno', '2025-06-15'),
(135, 'Raúl ', 'Jiménez Néstar', 'rauljn700@gmail.com', '$2y$10$8XXsod6yD9CtCg6fkTuMq.gbLuJ0n5OCLBLWR9BX7H6pQGVFakoke', 'alumno', '2025-06-15'),
(136, 'Esmeralda ', 'López Rodero', 'esmeralda.lrodero@gmail.com', '$2y$10$XvhtEFRCXI38/Mc0hTdVieORUxx4ms8Bhn3D276mLnucA1mHP9rv2', 'alumno', '2025-06-15'),
(137, 'Jorge ', 'Moreno Adamuz', 'jorgemorenoadamuz@gmail.com', '$2y$10$IB5YDru2LGRu3EKQcEBP1Opc9S7dZTlqnJfoqkIbp/Vn/37wWUn6K', 'alumno', '2025-06-15'),
(138, 'Antonio ', 'Moreno Ojeda', 'adminaantoniomoreno55@gmail.com', '$2y$10$FrN0P2cTx1kkj5339ggm1eNoN6VNbbkV/YeAEepw4HckyRIteB/7.', 'alumno', '2025-06-15'),
(139, 'Mateo', 'Mudano', 'mateo.mudano1@gmail.com', '$2y$10$BBVfLvYjLCi.p6vV6bDbm..OZnJnaoYpndJMElRwKGrwYY8hH/6jW', 'alumno', '2025-06-15'),
(140, 'Alejandro', 'Nacio Plaza', 'ALEX_NACIO7@HOTMAIL.COM', '$2y$10$fnOACuazW4x96FStsX9y7eaCmO6n95qx.LU0Ten2JM6253CyjOE26', 'alumno', '2025-06-15'),
(141, 'Gabriel', 'Pardo Ruiz', 'pardoruizgabriel@gmail.com', '$2y$10$YsVSXqADX8cqXHOXjMP7IOt7P0K28epoatniwR2nLdsudYSTkddtS', 'alumno', '2025-06-15'),
(142, 'Sugam', 'Poudel', 'sugampoudel528@gmail.com', '$2y$10$0jo4U5Nia/Nk0XUoN53aVeoa9IrY44sxgoH08NGj/9sbN8Zpqe6f6', 'alumno', '2025-06-15'),
(143, 'Miguel ', 'Robles Picasso', 'miguel.robles.picasso.92@gmail.com', '$2y$10$rr81D7g1BDGYrHV62rkgsO363CCeFhSz7dnWrQmKIS/TULAppN9HK', 'alumno', '2025-06-15'),
(144, 'Fernando ', 'Rosas', 'fernandorosasjr@gmail.com', '$2y$10$z.7nqgfJcRicAgg7ReFySuxfaGFamZs2cYIS4eQN/lKetdGl4x0uC', 'alumno', '2025-06-15'),
(145, 'Fátima Esmeralda ', 'Valle Argueta', 'esmeraldaargueta2006@gmail.com', '$2y$10$ok1TbK1t/6BOE2M9pnxyBu2mF/vpAcvxi86XGNWCjF6GVbTG7ppoi', 'alumno', '2025-06-15'),
(146, 'Francisco', 'Palacios Chaves', 'fpalacioschaves@profesor.com', '$2y$10$0dHXna2XoRuH/1BCk99ZwO/UmY.EOW/kcvmon1Mm1twVW38Uy4eva', 'profesor', '2025-06-15'),
(147, 'Belén', 'Apellidos', 'belen@profesor.com', '$2y$10$y1TsQgGtKx2nM0E0fTf.x.v9algPBiYTjOG8SyqrodT7SGwdCu0Nq', 'profesor', '2025-06-15'),
(148, 'Alberto', 'Ruiz', 'albertoruizprofesor@gmail.com', '$2y$10$kudIc/byMdouq7.RHffmGehcwcvYkiZB6uboChN7bHunWZaoXdmue', 'profesor', '2025-06-15'),
(149, 'Isabel', 'Apellidos', 'isabel@profesor.com', '$2y$10$eUMJ.oJQfk1kYeMpitWVU.bA6MM8FP1ozkd4uNZGNVEHMxlz/xF62', 'profesor', '2025-06-15');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `etiqueta_ejercicio`
--
ALTER TABLE `etiqueta_ejercicio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `examenes`
--
ALTER TABLE `examenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profesor_asignatura`
--
ALTER TABLE `profesor_asignatura`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resoluciones`
--
ALTER TABLE `resoluciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `un_respuesta_por_alumno` (`alumno_id`,`ejercicio_id`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tareas_asignadas`
--
ALTER TABLE `tareas_asignadas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alumno_id` (`alumno_id`,`ejercicio_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `etiqueta_ejercicio`
--
ALTER TABLE `etiqueta_ejercicio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `examenes`
--
ALTER TABLE `examenes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `matricula`
--
ALTER TABLE `matricula`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `profesor_asignatura`
--
ALTER TABLE `profesor_asignatura`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `resoluciones`
--
ALTER TABLE `resoluciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tareas_asignadas`
--
ALTER TABLE `tareas_asignadas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
