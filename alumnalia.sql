-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 22-06-2025 a las 10:42:41
-- Versión del servidor: 5.7.39
-- Versión de PHP: 7.4.33

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
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text,
  `curso_id` bigint(20) UNSIGNED NOT NULL,
  `asignatura_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_entrega` date NOT NULL,
  `ponderacion` decimal(3,2) NOT NULL DEFAULT '1.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `titulo`, `descripcion`, `curso_id`, `asignatura_id`, `fecha_entrega`, `ponderacion`) VALUES
(1, 'Site en Wordpress', 'Crear un site en Wordpress con una serie de especificaciones a cumplir', 1, 3, '2025-06-29', '0.35'),
(2, 'Crear Tema de Wordpress', 'Crea un tema de Wordpress', 4, 7, '2025-06-21', '0.25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_alumnos`
--

CREATE TABLE `actividades_alumnos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `actividad_id` bigint(20) UNSIGNED NOT NULL,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `nota` decimal(5,2) DEFAULT NULL,
  `entregado` tinyint(1) DEFAULT '0',
  `fecha_entrega` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `actividades_alumnos`
--

INSERT INTO `actividades_alumnos` (`id`, `actividad_id`, `alumno_id`, `nota`, `entregado`, `fecha_entrega`) VALUES
(1, 1, 128, '6.00', 0, NULL),
(2, 1, 129, '7.00', 0, NULL),
(3, 1, 130, '8.00', 0, NULL),
(4, 1, 131, '9.00', 0, NULL),
(5, 1, 132, '6.00', 0, NULL),
(6, 1, 133, '6.00', 0, NULL),
(7, 1, 134, '6.00', 0, NULL),
(8, 1, 135, '6.00', 0, NULL),
(9, 1, 136, '6.00', 0, NULL),
(10, 1, 137, '7.00', 0, NULL),
(11, 1, 138, '7.00', 0, NULL),
(12, 1, 139, '7.00', 0, NULL),
(13, 1, 140, '7.90', 0, NULL),
(14, 1, 141, '8.00', 0, NULL),
(15, 1, 142, '8.00', 0, NULL),
(16, 1, 143, '8.00', 0, NULL),
(17, 1, 144, '9.00', 0, NULL),
(18, 1, 145, '10.00', 0, NULL),
(19, 2, 164, '10.00', 0, NULL),
(20, 2, 165, '10.00', 0, NULL),
(21, 2, 166, '10.00', 0, NULL),
(22, 2, 167, '10.00', 0, NULL),
(23, 2, 168, '10.00', 0, NULL),
(24, 2, 169, '10.00', 0, NULL),
(25, 2, 170, '10.00', 0, NULL),
(26, 2, 171, '10.00', 0, NULL),
(27, 2, 172, '10.00', 0, NULL),
(28, 2, 174, '0.00', 0, NULL),
(29, 2, 176, '10.00', 0, NULL),
(30, 2, 177, '10.00', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `curso_id`) VALUES
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(142, 1),
(143, 1),
(144, 1),
(145, 1),
(151, 2),
(152, 2),
(153, 2),
(154, 2),
(155, 2),
(156, 2),
(157, 2),
(159, 2),
(160, 2),
(161, 2),
(162, 2),
(164, 4),
(165, 4),
(166, 4),
(167, 4),
(168, 4),
(169, 4),
(170, 4),
(171, 4),
(172, 4),
(174, 4),
(176, 4),
(177, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE `asignaturas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `curso_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`id`, `nombre`, `descripcion`, `curso_id`) VALUES
(1, 'Bases de Datos', 'Modelo relacional y SQL', 1),
(2, 'Programación', 'Java, POO y estructuras de control', 1),
(3, 'Lenguaje de Marcas', 'HTML, XML, CSS', 1),
(4, 'Entornos de Desarrollo', '', 1),
(5, 'Sistemas Informáticos', '', 1),
(6, 'Digitalización', '', 1),
(7, 'Desarrollo Entorno Servidor', '', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco_preguntas`
--

CREATE TABLE `banco_preguntas` (
  `id` int(11) NOT NULL,
  `enunciado` text,
  `dificultad` enum('baja','media','alta') DEFAULT 'media',
  `etiqueta_id` bigint(20) DEFAULT NULL,
  `tema_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `banco_preguntas`
--

INSERT INTO `banco_preguntas` (`id`, `enunciado`, `dificultad`, `etiqueta_id`, `tema_id`) VALUES
(1, 'Esta es la pregunta 1', 'media', 3, 1),
(2, 'Esta es la pregunta 2', 'media', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco_preguntas_en_examen`
--

CREATE TABLE `banco_preguntas_en_examen` (
  `examen_id` int(11) NOT NULL,
  `pregunta_id` int(11) NOT NULL,
  `puntuacion` decimal(5,2) NOT NULL DEFAULT '1.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `banco_preguntas_en_examen`
--

INSERT INTO `banco_preguntas_en_examen` (`examen_id`, `pregunta_id`, `puntuacion`) VALUES
(2, 1, '1.00'),
(3, 1, '2.50'),
(3, 2, '2.50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `enunciado` text,
  `tipo` varchar(20) DEFAULT NULL,
  `puntuacion` decimal(5,2) DEFAULT '1.00',
  `orden` int(11) DEFAULT NULL,
  `etiqueta_id` int(11) DEFAULT NULL,
  `tema_id` int(11) DEFAULT NULL,
  `dificultad` enum('baja','media','alta') DEFAULT 'media'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ejercicios`
--

INSERT INTO `ejercicios` (`id`, `examen_id`, `enunciado`, `tipo`, `puntuacion`, `orden`, `etiqueta_id`, `tema_id`, `dificultad`) VALUES
(4, 2, 'Devuelve los nombres de los personajes que pertenecen a la casa \"Stark\".', 'abierta', '1.60', 1, 3, NULL, 'media'),
(5, 2, 'Devuelve el nombre de la batalla que se ha librado en \"Meereen\".', 'abierta', '1.60', 2, 3, NULL, 'media'),
(6, 2, 'Devuelve el título del personaje que ha participado en una batalla cuyo resultado ha sido \"Derrota\".', 'abierta', '1.60', 3, 3, NULL, 'media'),
(7, 2, 'Devuelve una lista con los personajes y el número de batallas en las que ha participado cada uno.', 'abierta', '1.60', 4, 4, NULL, 'media'),
(8, 2, 'Devuelve un resumen en XML con todos los nombres de personajes y el nombre de cada batalla, con esta estructura:\r\n\r\n<resumen>\r\n\r\n  <personaje nombre=\"Jon Snow\">\r\n\r\n    <batalla>Batalla de los Bastardos</batalla>\r\n\r\n  </personaje>\r\n\r\n  ...\r\n\r\n</resumen>', 'abierta', '1.60', 5, 4, NULL, 'media'),
(9, 2, 'Devuelve la lista de casas con el número total de victorias obtenidas por sus personajes, ordenada de mayor a menor número de victorias. EL resultado debe tener este formato: \r\n\r\n<casa nombre=\"Stark\" victorias=\"4\"/>\r\n\r\n<casa nombre=\"Lannister\" victorias=\"2\"/>\r\n\r\n<casa nombre=\"Targaryen\" victorias=\"1\"/>\r\n\r\n\r\n<casa nombre=\"Tarth\" victorias=\"1\"/>', 'abierta', '1.60', 6, 4, NULL, 'media'),
(10, 3, 'dtjdfthjfhj', 'abierta', '1.00', 1, 1, NULL, 'media');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios_propuestos`
--

CREATE TABLE `ejercicios_propuestos` (
  `id` int(11) NOT NULL,
  `tema_id` int(11) DEFAULT NULL,
  `etiqueta_id` bigint(20) DEFAULT NULL,
  `tipo` enum('desarrollo','test','codigo') DEFAULT 'desarrollo',
  `dificultad` enum('baja','media','alta') DEFAULT 'media',
  `enunciado` text,
  `solucion` text,
  `activo` tinyint(1) DEFAULT '1',
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ejercicios_propuestos`
--

INSERT INTO `ejercicios_propuestos` (`id`, `tema_id`, `etiqueta_id`, `tipo`, `dificultad`, `enunciado`, `solucion`, `activo`, `creado_en`) VALUES
(1, 1, 3, 'desarrollo', 'media', 'sdfasdfasasdf', '', 1, '2025-06-16 07:38:06'),
(2, 1, 3, 'desarrollo', 'baja', 'vbndfghdfhdfghdfghdfghd', '', 1, '2025-06-16 08:47:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas`
--

CREATE TABLE `etiquetas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes`
--

CREATE TABLE `examenes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text,
  `asignatura_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `evaluacion` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `examenes`
--

INSERT INTO `examenes` (`id`, `titulo`, `descripcion`, `asignatura_id`, `fecha`, `hora`, `tipo`, `evaluacion`) VALUES
(2, 'Examen Final Tercer Trimestre', '', 3, '2025-06-07', '11:30:00', 'evaluación', 1),
(3, 'Test de examen', 'Testeo del banco de preguntas', 1, '2025-07-31', '12:30:00', 'evaluación', 3),
(5, 'Examen Primer Parcial 24/25', '', 3, '2025-06-01', '08:30:00', 'diagnóstico', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matricula`
--

CREATE TABLE `matricula` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `asignatura_id` int(11) DEFAULT NULL,
  `curso_escolar` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas_examen_alumno`
--

CREATE TABLE `notas_examen_alumno` (
  `id` int(11) NOT NULL,
  `examen_id` bigint(20) NOT NULL,
  `alumno_id` int(11) NOT NULL,
  `nota_total` decimal(5,2) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `notas_examen_alumno`
--

INSERT INTO `notas_examen_alumno` (`id`, `examen_id`, `alumno_id`, `nota_total`, `fecha_registro`) VALUES
(1, 3, 128, '2.70', '2025-06-19 10:47:34'),
(2, 3, 129, '1.10', '2025-06-19 10:47:34'),
(3, 3, 130, '1.00', '2025-06-19 10:47:34'),
(4, 3, 131, '2.00', '2025-06-19 10:47:34'),
(5, 3, 132, '2.20', '2025-06-19 10:47:34'),
(6, 3, 133, '1.50', '2025-06-19 10:47:34'),
(7, 3, 134, '1.00', '2025-06-19 10:47:34'),
(8, 3, 135, '1.00', '2025-06-19 10:47:34'),
(9, 3, 136, '1.00', '2025-06-19 10:47:34'),
(10, 3, 137, '1.00', '2025-06-19 10:47:34'),
(11, 3, 138, '1.00', '2025-06-19 10:47:34'),
(12, 3, 139, '1.00', '2025-06-19 10:47:34'),
(13, 3, 140, '1.00', '2025-06-19 10:47:34'),
(14, 3, 141, '1.70', '2025-06-19 10:47:34'),
(15, 3, 142, '1.00', '2025-06-19 10:47:34'),
(16, 3, 143, '1.00', '2025-06-19 10:47:34'),
(17, 3, 144, '1.00', '2025-06-19 10:47:34'),
(18, 3, 145, '2.00', '2025-06-19 10:47:34'),
(55, 2, 128, '2.00', '2025-06-19 10:49:39'),
(56, 2, 129, '6.30', '2025-06-19 10:49:39'),
(57, 2, 130, '9.20', '2025-06-19 10:49:39'),
(58, 2, 131, '6.80', '2025-06-19 10:49:39'),
(59, 2, 132, '6.40', '2025-06-19 10:49:39'),
(60, 2, 133, '7.00', '2025-06-19 10:49:39'),
(61, 2, 134, '9.60', '2025-06-19 10:49:39'),
(62, 2, 135, '9.50', '2025-06-19 10:49:39'),
(63, 2, 136, '6.00', '2025-06-19 10:49:39'),
(64, 2, 137, '6.00', '2025-06-19 10:49:39'),
(65, 2, 138, '3.00', '2025-06-19 10:49:39'),
(66, 2, 139, '9.96', '2025-06-19 10:49:39'),
(67, 2, 140, '6.60', '2025-06-19 10:49:39'),
(68, 2, 141, '8.65', '2025-06-19 10:49:39'),
(69, 2, 142, '6.00', '2025-06-19 10:49:39'),
(70, 2, 143, '4.00', '2025-06-19 10:49:39'),
(71, 2, 144, '5.50', '2025-06-19 10:49:39'),
(72, 2, 145, '6.60', '2025-06-19 10:49:39'),
(73, 5, 128, '10.00', '2025-06-19 10:53:01'),
(74, 5, 129, '10.00', '2025-06-19 10:53:01'),
(75, 5, 130, '10.00', '2025-06-19 10:53:01'),
(76, 5, 131, '4.00', '2025-06-19 10:53:01'),
(77, 5, 132, '10.00', '2025-06-19 10:53:01'),
(78, 5, 133, '10.00', '2025-06-19 10:53:01'),
(79, 5, 134, '9.00', '2025-06-19 10:53:01'),
(80, 5, 135, '0.00', '2025-06-19 10:53:01'),
(81, 5, 136, '10.00', '2025-06-19 10:53:01'),
(82, 5, 137, '9.00', '2025-06-19 10:53:01'),
(83, 5, 138, '5.00', '2025-06-19 10:53:01'),
(84, 5, 139, '10.00', '2025-06-19 10:53:01'),
(85, 5, 140, '10.00', '2025-06-19 10:53:01'),
(86, 5, 141, '9.00', '2025-06-19 10:53:01'),
(87, 5, 142, '10.00', '2025-06-19 10:53:01'),
(88, 5, 143, '10.00', '2025-06-19 10:53:01'),
(89, 5, 144, '9.00', '2025-06-19 10:53:01'),
(90, 5, 145, '8.00', '2025-06-19 10:53:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones_banco_pregunta`
--

CREATE TABLE `opciones_banco_pregunta` (
  `id` int(11) NOT NULL,
  `pregunta_id` int(11) DEFAULT NULL,
  `texto` varchar(255) DEFAULT NULL,
  `es_correcta` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `opciones_banco_pregunta`
--

INSERT INTO `opciones_banco_pregunta` (`id`, `pregunta_id`, `texto`, `es_correcta`) VALUES
(5, 1, 'Primera opción', 0),
(6, 1, 'Segunda opción', 1),
(7, 1, 'Tercera opción', 0),
(8, 1, 'Añado una cuarta opción', 0),
(9, 2, 'rghsrghdrgh', 1),
(10, 2, 'fghdfghdfgh', 0),
(11, 2, 'dfghdfghdfgh', 0),
(12, 2, '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` int(11) NOT NULL,
  `departamento` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `id` int(11) NOT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `ejercicio_id` int(11) DEFAULT NULL,
  `respuesta_texto` text,
  `respuesta_id` int(11) DEFAULT NULL,
  `puntuacion_obtenida` decimal(5,2) DEFAULT '0.00',
  `fecha_respuesta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `resoluciones`
--

INSERT INTO `resoluciones` (`id`, `alumno_id`, `ejercicio_id`, `respuesta_texto`, `respuesta_id`, `puntuacion_obtenida`, `fecha_respuesta`) VALUES
(4, 128, 4, NULL, NULL, '0.00', '2025-06-15 17:36:48'),
(5, 129, 4, NULL, NULL, '1.00', '2025-06-15 17:12:01'),
(6, 130, 4, NULL, NULL, '1.60', '2025-06-15 17:12:11'),
(7, 131, 4, NULL, NULL, '1.00', '2025-06-15 17:12:14'),
(8, 132, 4, NULL, NULL, '0.00', '2025-06-15 17:12:19'),
(9, 133, 4, NULL, NULL, '0.50', '2025-06-15 17:12:22'),
(10, 134, 4, NULL, NULL, '1.60', '2025-06-15 17:12:27'),
(11, 135, 4, NULL, NULL, '1.20', '2025-06-15 17:12:30'),
(12, 136, 4, NULL, NULL, '1.00', '2025-06-15 17:12:32'),
(13, 137, 4, NULL, NULL, '1.00', '2025-06-15 17:12:34'),
(14, 138, 4, NULL, NULL, '0.00', '2025-06-15 17:12:38'),
(15, 139, 4, NULL, NULL, '1.66', '2025-06-15 17:17:22'),
(16, 140, 4, NULL, NULL, '1.60', '2025-06-15 17:12:50'),
(17, 141, 4, NULL, NULL, '1.20', '2025-06-15 17:12:54'),
(18, 142, 4, NULL, NULL, '1.00', '2025-06-15 17:12:56'),
(19, 143, 4, NULL, NULL, '1.00', '2025-06-15 17:12:58'),
(20, 144, 4, NULL, NULL, '0.00', '2025-06-15 17:13:01'),
(21, 145, 4, NULL, NULL, '1.60', '2025-06-15 17:13:07'),
(22, 128, 5, NULL, NULL, '0.00', '2025-06-15 17:36:51'),
(23, 129, 5, NULL, NULL, '1.00', '2025-06-15 17:13:11'),
(24, 130, 5, NULL, NULL, '1.60', '2025-06-15 17:13:15'),
(25, 128, 6, NULL, NULL, '1.00', '2025-06-16 15:34:57'),
(26, 128, 7, NULL, NULL, '0.20', '2025-06-18 13:55:44'),
(27, 128, 8, NULL, NULL, '0.00', '2025-06-15 17:39:16'),
(28, 128, 9, NULL, NULL, '0.10', '2025-06-16 16:33:38'),
(29, 129, 6, NULL, NULL, '1.00', '2025-06-15 17:13:37'),
(30, 129, 7, NULL, NULL, '1.00', '2025-06-15 17:13:38'),
(31, 129, 8, NULL, NULL, '1.00', '2025-06-15 17:13:40'),
(32, 129, 9, NULL, NULL, '1.00', '2025-06-15 17:13:43'),
(33, 130, 6, NULL, NULL, '1.30', '2025-06-15 17:14:00'),
(34, 130, 7, NULL, NULL, '1.40', '2025-06-15 17:14:03'),
(35, 130, 8, NULL, NULL, '1.50', '2025-06-15 17:14:06'),
(36, 130, 9, NULL, NULL, '1.60', '2025-06-15 17:14:10'),
(37, 131, 5, NULL, NULL, '0.00', '2025-06-15 17:14:14'),
(38, 131, 6, NULL, NULL, '1.20', '2025-06-15 17:14:17'),
(39, 131, 7, NULL, NULL, '1.30', '2025-06-15 17:14:21'),
(40, 131, 8, NULL, NULL, '1.40', '2025-06-15 17:14:24'),
(41, 131, 9, NULL, NULL, '1.30', '2025-06-15 17:14:28'),
(42, 132, 5, NULL, NULL, '1.00', '2025-06-15 17:14:30'),
(43, 132, 6, NULL, NULL, '1.00', '2025-06-15 17:14:32'),
(44, 132, 7, NULL, NULL, '1.00', '2025-06-15 17:14:34'),
(45, 132, 8, NULL, NULL, '1.20', '2025-06-15 17:14:36'),
(46, 132, 9, NULL, NULL, '1.50', '2025-06-15 17:14:40'),
(47, 133, 5, NULL, NULL, '0.80', '2025-06-15 17:15:50'),
(48, 133, 6, NULL, NULL, '1.00', '2025-06-15 17:15:53'),
(49, 133, 7, NULL, NULL, '1.20', '2025-06-15 17:15:56'),
(50, 133, 8, NULL, NULL, '1.40', '2025-06-15 17:15:59'),
(51, 133, 9, NULL, NULL, '1.60', '2025-06-15 17:16:02'),
(52, 134, 5, NULL, NULL, '1.60', '2025-06-15 17:16:05'),
(53, 134, 6, NULL, NULL, '1.60', '2025-06-15 17:16:08'),
(54, 134, 7, NULL, NULL, '1.60', '2025-06-15 17:16:16'),
(55, 134, 8, NULL, NULL, '1.60', '2025-06-15 17:16:19'),
(56, 134, 9, NULL, NULL, '1.60', '2025-06-15 17:16:21'),
(57, 135, 5, NULL, NULL, '1.66', '2025-06-15 17:16:30'),
(58, 135, 6, NULL, NULL, '1.66', '2025-06-15 17:16:32'),
(59, 135, 7, NULL, NULL, '1.66', '2025-06-15 17:16:36'),
(60, 135, 8, NULL, NULL, '1.66', '2025-06-15 17:16:38'),
(61, 135, 9, NULL, NULL, '1.66', '2025-06-15 17:16:41'),
(62, 136, 5, NULL, NULL, '1.00', '2025-06-15 17:16:44'),
(63, 136, 6, NULL, NULL, '1.00', '2025-06-15 17:16:45'),
(64, 136, 7, NULL, NULL, '1.00', '2025-06-15 17:16:46'),
(65, 136, 8, NULL, NULL, '1.00', '2025-06-15 17:16:47'),
(66, 136, 9, NULL, NULL, '1.00', '2025-06-15 17:16:49'),
(67, 137, 5, NULL, NULL, '1.00', '2025-06-15 17:16:51'),
(68, 137, 6, NULL, NULL, '0.00', '2025-06-15 17:16:54'),
(69, 137, 7, NULL, NULL, '1.20', '2025-06-15 17:16:56'),
(70, 137, 8, NULL, NULL, '1.40', '2025-06-15 17:17:00'),
(71, 137, 9, NULL, NULL, '1.40', '2025-06-15 17:17:03'),
(72, 138, 5, NULL, NULL, '0.00', '2025-06-15 17:17:06'),
(73, 138, 6, NULL, NULL, '0.00', '2025-06-15 17:17:08'),
(74, 138, 7, NULL, NULL, '1.00', '2025-06-15 17:17:09'),
(75, 138, 8, NULL, NULL, '1.00', '2025-06-15 17:17:11'),
(76, 138, 9, NULL, NULL, '1.00', '2025-06-15 17:17:12'),
(77, 139, 5, NULL, NULL, '1.66', '2025-06-15 17:17:24'),
(78, 139, 6, NULL, NULL, '1.66', '2025-06-15 17:17:27'),
(79, 139, 7, NULL, NULL, '1.66', '2025-06-15 17:17:29'),
(80, 139, 8, NULL, NULL, '1.66', '2025-06-15 17:17:31'),
(81, 139, 9, NULL, NULL, '1.66', '2025-06-15 17:17:34'),
(82, 140, 5, NULL, NULL, '1.00', '2025-06-15 17:17:38'),
(83, 140, 6, NULL, NULL, '1.00', '2025-06-15 17:17:40'),
(84, 140, 7, NULL, NULL, '1.00', '2025-06-15 17:17:41'),
(85, 140, 8, NULL, NULL, '1.00', '2025-06-15 17:17:43'),
(86, 140, 9, NULL, NULL, '1.00', '2025-06-15 17:17:44'),
(87, 141, 5, NULL, NULL, '1.32', '2025-06-15 17:17:50'),
(88, 141, 6, NULL, NULL, '1.22', '2025-06-15 17:17:53'),
(89, 141, 7, NULL, NULL, '1.44', '2025-06-15 17:17:56'),
(90, 141, 8, NULL, NULL, '1.44', '2025-06-15 17:18:00'),
(91, 141, 9, NULL, NULL, '1.33', '2025-06-15 17:18:04'),
(92, 142, 5, NULL, NULL, '1.00', '2025-06-15 17:18:06'),
(93, 142, 6, NULL, NULL, '1.00', '2025-06-15 17:18:07'),
(94, 142, 7, NULL, NULL, '1.00', '2025-06-15 17:18:08'),
(95, 142, 8, NULL, NULL, '1.00', '2025-06-15 17:18:09'),
(96, 142, 9, NULL, NULL, '1.00', '2025-06-15 17:18:14'),
(97, 143, 5, NULL, NULL, '0.00', '2025-06-15 17:18:16'),
(98, 143, 6, NULL, NULL, '1.00', '2025-06-15 17:18:20'),
(99, 143, 7, NULL, NULL, '0.00', '2025-06-15 17:18:22'),
(100, 143, 8, NULL, NULL, '1.00', '2025-06-15 17:18:24'),
(101, 143, 9, NULL, NULL, '1.00', '2025-06-15 17:18:27'),
(102, 144, 5, NULL, NULL, '1.00', '2025-06-15 17:18:32'),
(103, 144, 6, NULL, NULL, '1.00', '2025-06-15 17:18:34'),
(104, 144, 7, NULL, NULL, '1.50', '2025-06-15 17:18:39'),
(105, 144, 8, NULL, NULL, '1.00', '2025-06-15 17:18:41'),
(106, 144, 9, NULL, NULL, '1.00', '2025-06-15 17:18:43'),
(107, 145, 5, NULL, NULL, '1.00', '2025-06-15 17:29:59'),
(108, 145, 6, NULL, NULL, '1.00', '2025-06-15 17:18:52'),
(109, 145, 7, NULL, NULL, '1.00', '2025-06-15 17:18:54'),
(110, 145, 8, NULL, NULL, '1.00', '2025-06-15 17:18:57'),
(111, 145, 9, NULL, NULL, '1.00', '2025-06-15 17:19:00'),
(112, 128, 10, NULL, NULL, '1.00', '2025-06-20 07:11:38'),
(113, 129, 10, NULL, NULL, '0.50', '2025-06-19 10:48:07'),
(114, 130, 10, NULL, NULL, '0.90', '2025-06-19 16:45:43'),
(115, 132, 10, NULL, NULL, '1.00', '2025-06-18 14:06:12'),
(116, 134, 10, NULL, NULL, '1.00', '2025-06-18 14:06:13'),
(117, 131, 10, NULL, NULL, '1.00', '2025-06-18 14:06:16'),
(118, 133, 10, NULL, NULL, '1.00', '2025-06-18 14:06:19'),
(119, 135, 10, NULL, NULL, '1.00', '2025-06-18 14:06:21'),
(120, 136, 10, NULL, NULL, '1.00', '2025-06-18 14:06:26'),
(121, 137, 10, NULL, NULL, '1.00', '2025-06-18 14:06:27'),
(122, 138, 10, NULL, NULL, '1.00', '2025-06-18 14:06:29'),
(123, 139, 10, NULL, NULL, '1.00', '2025-06-18 14:06:30'),
(124, 140, 10, NULL, NULL, '1.00', '2025-06-18 14:06:31'),
(125, 141, 10, NULL, NULL, '1.00', '2025-06-18 14:06:33'),
(126, 142, 10, NULL, NULL, '1.00', '2025-06-18 14:06:34'),
(127, 143, 10, NULL, NULL, '1.00', '2025-06-18 14:06:36'),
(128, 144, 10, NULL, NULL, '1.00', '2025-06-18 14:06:39'),
(129, 145, 10, NULL, NULL, '1.00', '2025-06-18 14:06:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resoluciones_banco_preguntas`
--

CREATE TABLE `resoluciones_banco_preguntas` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `ejercicio_id` int(11) DEFAULT NULL,
  `respuesta_texto` text,
  `respuesta_id` int(11) DEFAULT NULL,
  `puntuacion_obtenida` decimal(5,2) DEFAULT '0.00',
  `fecha_respuesta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `resoluciones_banco_preguntas`
--

INSERT INTO `resoluciones_banco_preguntas` (`id`, `alumno_id`, `ejercicio_id`, `respuesta_texto`, `respuesta_id`, `puntuacion_obtenida`, `fecha_respuesta`) VALUES
(1, 129, 1, NULL, NULL, '0.30', '2025-06-18 15:28:29'),
(2, 128, 1, NULL, NULL, '1.20', '2025-06-19 11:03:19'),
(3, 128, 2, NULL, NULL, '0.10', '2025-06-18 15:22:49'),
(4, 129, 2, NULL, NULL, '0.30', '2025-06-18 15:22:51'),
(5, 130, 1, NULL, NULL, '0.00', '2025-06-19 16:45:36'),
(6, 130, 2, NULL, NULL, '0.10', '2025-06-19 16:45:38'),
(7, 131, 1, NULL, NULL, '0.60', '2025-06-19 10:48:24'),
(8, 131, 2, NULL, NULL, '0.40', '2025-06-19 10:48:12'),
(9, 132, 2, NULL, NULL, '0.50', '2025-06-19 10:48:14'),
(10, 132, 1, NULL, NULL, '0.70', '2025-06-19 10:48:16'),
(11, 133, 1, NULL, NULL, '0.50', '2025-06-19 10:48:26'),
(12, 141, 1, NULL, NULL, '0.70', '2025-06-19 10:48:29'),
(13, 145, 1, NULL, NULL, '0.50', '2025-06-19 11:03:50'),
(14, 145, 2, NULL, NULL, '0.50', '2025-06-19 11:03:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ejercicio_id` int(11) DEFAULT NULL,
  `texto_respuesta` text,
  `es_correcta` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_asignadas`
--

CREATE TABLE `tareas_asignadas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `ejercicio_id` bigint(20) DEFAULT NULL,
  `fecha_asignacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_limite_entrega` date DEFAULT NULL,
  `completado` tinyint(1) DEFAULT '0',
  `estado` enum('sin_enviar','enviado','resuelto') DEFAULT 'sin_enviar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tareas_asignadas`
--

INSERT INTO `tareas_asignadas` (`id`, `alumno_id`, `ejercicio_id`, `fecha_asignacion`, `fecha_limite_entrega`, `completado`, `estado`) VALUES
(2, 128, 4, '2025-06-15 17:52:52', NULL, 0, 'sin_enviar'),
(8, 128, 5, '2025-06-15 17:53:53', NULL, 0, 'enviado'),
(10, 128, 7, '2025-06-15 17:58:38', NULL, 0, 'sin_enviar'),
(11, 128, 9, '2025-06-15 17:58:39', NULL, 0, 'sin_enviar'),
(21, 128, 1, '2025-06-16 08:29:34', '2025-07-21', 0, 'resuelto'),
(28, 128, 8, '2025-06-15 18:12:10', NULL, 0, 'sin_enviar'),
(51, 128, 6, '2025-06-15 17:52:49', NULL, 0, 'resuelto'),
(52, 128, 2, '2025-06-16 09:11:07', '2025-08-13', 0, 'resuelto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

CREATE TABLE `temas` (
  `id` int(11) NOT NULL,
  `asignatura_id` bigint(20) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `temas`
--

INSERT INTO `temas` (`id`, `asignatura_id`, `nombre`) VALUES
(1, 1, 'XPath');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `password_hash` text,
  `tipo` varchar(20) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(138, 'Antonio ', 'Moreno Ojeda', 'aantoniomoreno55@gmail.com', '$2y$10$FrN0P2cTx1kkj5339ggm1eNoN6VNbbkV/YeAEepw4HckyRIteB/7.', 'alumno', '2025-06-15'),
(139, 'Mateo', 'Mudano', 'mateo.mudano1@gmail.com', '$2y$10$BBVfLvYjLCi.p6vV6bDbm..OZnJnaoYpndJMElRwKGrwYY8hH/6jW', 'alumno', '2025-06-15'),
(140, 'Alejandro', 'Nacio Plaza', 'alex_nacio7@hotmail.com', '$2y$10$rh/QirDtnFASSs3nirENauLBOQQDoF/zcoO6ZQe/YX05hsxYm8JBm', 'alumno', '2025-06-15'),
(141, 'Gabriel', 'Pardo Ruiz', 'pardoruizgabriel@gmail.com', '$2y$10$YsVSXqADX8cqXHOXjMP7IOt7P0K28epoatniwR2nLdsudYSTkddtS', 'alumno', '2025-06-15'),
(142, 'Sugam', 'Poudel', 'sugampoudel528@gmail.com', '$2y$10$0jo4U5Nia/Nk0XUoN53aVeoa9IrY44sxgoH08NGj/9sbN8Zpqe6f6', 'alumno', '2025-06-15'),
(143, 'Miguel ', 'Robles Picasso', 'miguel.robles.picasso.92@gmail.com', '$2y$10$rr81D7g1BDGYrHV62rkgsO363CCeFhSz7dnWrQmKIS/TULAppN9HK', 'alumno', '2025-06-15'),
(144, 'Fernando ', 'Rosas', 'fernandorosasjr@gmail.com', '$2y$10$z.7nqgfJcRicAgg7ReFySuxfaGFamZs2cYIS4eQN/lKetdGl4x0uC', 'alumno', '2025-06-15'),
(145, 'Fátima Esmeralda ', 'Valle Argueta', 'esmeraldaargueta2006@gmail.com', '$2y$10$ok1TbK1t/6BOE2M9pnxyBu2mF/vpAcvxi86XGNWCjF6GVbTG7ppoi', 'alumno', '2025-06-15'),
(146, 'Francisco', 'Palacios Chaves', 'fpalacioschaves@profesor.com', '$2y$10$0dHXna2XoRuH/1BCk99ZwO/UmY.EOW/kcvmon1Mm1twVW38Uy4eva', 'profesor', '2025-06-15'),
(147, 'Belén', 'Apellidos', 'belen@profesor.com', '$2y$10$y1TsQgGtKx2nM0E0fTf.x.v9algPBiYTjOG8SyqrodT7SGwdCu0Nq', 'profesor', '2025-06-15'),
(148, 'Alberto', 'Ruiz', 'albertoruizprofesor@gmail.com', '$2y$10$kudIc/byMdouq7.RHffmGehcwcvYkiZB6uboChN7bHunWZaoXdmue', 'profesor', '2025-06-15'),
(149, 'Isabel', 'Apellidos', 'isabel@profesor.com', '$2y$10$eUMJ.oJQfk1kYeMpitWVU.bA6MM8FP1ozkd4uNZGNVEHMxlz/xF62', 'profesor', '2025-06-15'),
(151, 'Guillermo', 'Accino España', 'guilleaccesp@gmail.com', '$2y$10$BX6BaLe/HObfxdxyMfqai.Msm2RrIGiY8BWgO6I/C1jZ5gLU3NmN6', 'alumno', NULL),
(152, 'Oscar Leonardo', 'Arnez Copa', 'oscarleonardo098@gmail.com', '$2y$10$iMnoRkFAoS92ku/FfK0eWOtO0PQq4vDdQFwInfAhp55t2QfNrb626', 'alumno', NULL),
(153, 'Miguel', 'Dorronsoro Montero', 'mdorronsoromontero@gmail.com', '$2y$10$rHjjNXZ4ymvHj0QhmJ0QNuOjcbaCqSkVzplmC6y01VGHFuwDEZul.', 'alumno', NULL),
(154, 'Mohammed', 'El Oualid Bedda', 'mohammedeloualidbedda2004@gmail.com', '$2y$10$iIRLwK69t171oRFcSOqC9uqLlLAr79QHx2xJBvV20I7M4Ve4gVvsa', 'alumno', NULL),
(155, 'Álvaro', 'Marcos', 'alvaromsans@yahoo.es', '$2y$10$j6CguHBxyeGTbUMoHT3ev.Yixfy33dwoMLkntmLX/GS3gnGDxedD.', 'alumno', NULL),
(156, 'Sami', 'Massis Ouardane', 'samimassis2002@gmail.com', '$2y$10$eEGLBarzU3C1rRt/EExFJ.WZFPLuQpcnEWZ1/6voL.nSzTOnq.QT6', 'alumno', NULL),
(157, 'Abraham', 'Ortiz Tejada', 'abrahamotiz0112@gmail.com', '$2y$10$xlp1/3do6MZ/R5KsZM77Nu1ql2ffXtYobYYJQQzO/mSOWIUg2z/ou', 'alumno', NULL),
(159, 'Antonio José', 'Rodríguez Barba', 'antonnioro@gmail.com', '$2y$10$pcUQZ8uaUdHbXJmirzzJa.ZAvrTzrTdl4YUVg/AgpQA2y1mm5ykHq', 'alumno', NULL),
(160, 'Alejandro', 'Rodríguez González', 'arg230903@gmail.com', '$2y$10$Zdfn7JAxZ44L8bB8.zvXyu/.S.rGnAOJwxYE6bm8Ynax.pni6shx2', 'alumno', NULL),
(161, 'Gabi', 'Rodríguez Rodríguez', 'jsgabriel.rodriguez@gmail.com', '$2y$10$.9Fnkr96qR5hSXr2t9mOru3mh6XpeFkadruGcd0qGXmcRd3tSjigW', 'alumno', NULL),
(162, 'Sergio', 'Trujillo Saborido', 'sertrusa@gmail.com', '$2y$10$oECmcJlOkzfE/3wX8UhAY.PZJcC3RYDMVdUhKAcA.6ZDklITjAQSC', 'alumno', NULL),
(164, 'Javier', 'Anaya Ruiz', 'javiianaya95@gmail.com', '$2y$10$B7CqIQyqra1Pj2cu7/b1O..dTvPovIvu6w0eg2XukgjP1i81SJLau', 'alumno', NULL),
(165, 'Brandon', 'Bates Ortiz', 'brandonbatesortiz@gmail.com', '$2y$10$lqoOgFpZh2ktbWPO/7r/0uDTArBvwZrLv2jJAWUsFRO.Ve4wUm4Y2', 'alumno', NULL),
(166, 'Alba', 'Campaña Veiga', 'albacampanaveiga@gmail.com', '$2y$10$t/j9XOiYfLOyW/oXPM5tk.zlTX3Z.TZqghbUg2sWj01lIpiiF/O82', 'alumno', NULL),
(167, 'Ainoa', 'Fernandez Bello', 'ainoafernandez00@gmail.com', '$2y$10$YOSlR6JLNhQE1dYTepVHhexnw8.ovF5x4DBpcReoM7WMT1DLJXs1e', 'alumno', NULL),
(168, 'Miguel Ángel', 'González Gómez', 'miguea.gonzalez1993@gmail.com', '$2y$10$UYpI/tZFNFiJy0ZSWPWiAuagGN2jY/2snk7CGFMMkIn803WmrC4F2', 'alumno', NULL),
(169, 'Víctor', 'Jurado Sánchez', 'victorjuradosanchez@gmail.com', '$2y$10$v6KYalXGCI0ziK6mMYKQJu7u9xWEsdTd6gfXKD0gM9eP5lM5WZ1BG', 'alumno', NULL),
(170, 'Jose', 'Lujan Moya', 'jo_lumo@outlook.com', '$2y$10$i8X1z5apz3mzInNbCpGcOOaNOAA0.L5fQWqd4Fe4tdYH5f3wppun2', 'alumno', NULL),
(171, 'Joaquin Jesus', 'Moreno', 'quino_jjmv@hotmail.es', '$2y$10$2vO/TC2ylPsrrWU6MnTOleajm8bmYzjooiJkGKWJAYda2y2McVu7i', 'alumno', NULL),
(172, 'José', 'Muñoz Sánchez', 'jms2mil@gmail.com', '$2y$10$N2vY1XqxH1uL1Bdz70f6D.wZVcAl62/GKmEWAOQuRQdntrpFjMaSq', 'alumno', NULL),
(174, 'Francisco Javier', 'Pareja Arencón', 'Javierparejasoy@gmail.com', '$2y$10$r9PjO28TUzHrFQkKXi02dOw3nDtS.2GNyb/3c1h9tyGw0jUmWNCky', 'alumno', NULL),
(176, 'Daniel', 'Ronda Suviri', 'rondadaniel22@gmail.com', '$2y$10$8zl2dHcY91DvTc3t4b00F.JwLuirRHWGGormak6CcXSaeV1LeurZ.', 'alumno', NULL),
(177, 'Danniel', 'Shikina Loaiza', 'danny20030808@gmail.com', '$2y$10$WlVTfOXh6WobT2cS8FQIouzurAANwYejy4lkJQq0yUKrLQTPvMNEa', 'alumno', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_id` (`curso_id`),
  ADD KEY `asignatura_id` (`asignatura_id`);

--
-- Indices de la tabla `actividades_alumnos`
--
ALTER TABLE `actividades_alumnos`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `banco_preguntas`
--
ALTER TABLE `banco_preguntas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `banco_preguntas_en_examen`
--
ALTER TABLE `banco_preguntas_en_examen`
  ADD PRIMARY KEY (`examen_id`,`pregunta_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `tema_id` (`tema_id`);

--
-- Indices de la tabla `ejercicios_propuestos`
--
ALTER TABLE `ejercicios_propuestos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ejercicio_tema` (`tema_id`);

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
-- Indices de la tabla `notas_examen_alumno`
--
ALTER TABLE `notas_examen_alumno`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `examen_id` (`examen_id`,`alumno_id`);

--
-- Indices de la tabla `opciones_banco_pregunta`
--
ALTER TABLE `opciones_banco_pregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pregunta_id` (`pregunta_id`);

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
-- Indices de la tabla `resoluciones_banco_preguntas`
--
ALTER TABLE `resoluciones_banco_preguntas`
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
-- Indices de la tabla `temas`
--
ALTER TABLE `temas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asignatura_id` (`asignatura_id`,`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `actividades_alumnos`
--
ALTER TABLE `actividades_alumnos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `banco_preguntas`
--
ALTER TABLE `banco_preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `banco_preguntas_en_examen`
--
ALTER TABLE `banco_preguntas_en_examen`
  MODIFY `examen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ejercicios_propuestos`
--
ALTER TABLE `ejercicios_propuestos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `notas_examen_alumno`
--
ALTER TABLE `notas_examen_alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT de la tabla `opciones_banco_pregunta`
--
ALTER TABLE `opciones_banco_pregunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `resoluciones`
--
ALTER TABLE `resoluciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT de la tabla `resoluciones_banco_preguntas`
--
ALTER TABLE `resoluciones_banco_preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tareas_asignadas`
--
ALTER TABLE `tareas_asignadas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `temas`
--
ALTER TABLE `temas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `actividades_ibfk_2` FOREIGN KEY (`asignatura_id`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD CONSTRAINT `ejercicios_ibfk_1` FOREIGN KEY (`tema_id`) REFERENCES `temas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `ejercicios_propuestos`
--
ALTER TABLE `ejercicios_propuestos`
  ADD CONSTRAINT `fk_ejercicio_tema` FOREIGN KEY (`tema_id`) REFERENCES `temas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `opciones_banco_pregunta`
--
ALTER TABLE `opciones_banco_pregunta`
  ADD CONSTRAINT `opciones_banco_pregunta_ibfk_1` FOREIGN KEY (`pregunta_id`) REFERENCES `banco_preguntas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
