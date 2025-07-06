-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-07-2025 a las 20:08:57
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
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `curso_id` bigint(20) UNSIGNED NOT NULL,
  `asignatura_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_entrega` date NOT NULL,
  `ponderacion` decimal(3,2) NOT NULL DEFAULT 1.00,
  `evaluacion` enum('1','2','3','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `titulo`, `descripcion`, `curso_id`, `asignatura_id`, `fecha_entrega`, `ponderacion`, `evaluacion`) VALUES
(1, 'Site en Wordpress', 'Crear un site en Wordpress con una serie de especificaciones a cumplir', 1, 1, '2025-06-29', 0.35, '1'),
(2, 'Crear Tema de Wordpress', 'Crea un tema de Wordpress', 4, 7, '2025-06-21', 0.25, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_alumnos`
--

CREATE TABLE `actividades_alumnos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `actividad_id` bigint(20) UNSIGNED NOT NULL,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `nota` decimal(5,2) DEFAULT NULL,
  `entregado` tinyint(1) DEFAULT 0,
  `fecha_entrega` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `actividades_alumnos`
--

INSERT INTO `actividades_alumnos` (`id`, `actividad_id`, `alumno_id`, `nota`, `entregado`, `fecha_entrega`) VALUES
(1, 1, 128, 6.00, 0, NULL),
(2, 1, 129, 7.00, 0, NULL),
(3, 1, 130, 8.00, 0, NULL),
(4, 1, 131, 9.00, 0, NULL),
(5, 1, 132, 6.00, 0, NULL),
(6, 1, 133, 6.00, 0, NULL),
(7, 1, 134, 6.00, 0, NULL),
(8, 1, 135, 6.00, 0, NULL),
(9, 1, 136, 6.00, 0, NULL),
(10, 1, 137, 7.00, 0, NULL),
(11, 1, 138, 7.00, 0, NULL),
(12, 1, 139, 7.00, 0, NULL),
(13, 1, 140, 7.90, 0, NULL),
(14, 1, 141, 8.00, 0, NULL),
(15, 1, 142, 8.00, 0, NULL),
(16, 1, 143, 8.00, 0, NULL),
(17, 1, 144, 9.00, 0, NULL),
(18, 1, 145, 10.00, 0, NULL),
(19, 2, 164, 10.00, 0, NULL),
(20, 2, 165, 10.00, 0, NULL),
(21, 2, 166, 10.00, 0, NULL),
(22, 2, 167, 10.00, 0, NULL),
(23, 2, 168, 10.00, 0, NULL),
(24, 2, 169, 10.00, 0, NULL),
(25, 2, 170, 10.00, 0, NULL),
(26, 2, 171, 10.00, 0, NULL),
(27, 2, 172, 10.00, 0, NULL),
(28, 2, 174, 0.00, 0, NULL),
(29, 2, 176, 10.00, 0, NULL),
(30, 2, 177, 10.00, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estructura de tabla para la tabla `alumnos_empresas`
--

CREATE TABLE `alumnos_empresas` (
  `alumno_id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `tutor_nombre` varchar(255) DEFAULT NULL,
  `tutor_email` varchar(255) DEFAULT NULL,
  `tutor_telefono` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos_empresas`
--

INSERT INTO `alumnos_empresas` (`alumno_id`, `empresa_id`, `fecha_inicio`, `fecha_fin`, `tutor_nombre`, `tutor_email`, `tutor_telefono`) VALUES
(151, 1, '2025-07-01', '2025-07-01', 'Tutor View', 'fpalacioschaves@gmail.com', '655925498'),
(152, 1, '2025-07-01', '2025-10-01', NULL, NULL, NULL),
(155, 1, '2025-07-05', '2025-07-06', 'ghgjfghjfthj', 'fpalacioschaves@gmail.com', '655925498');

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
(1, 'Bases de Datos', 'Asignatura común en 1º de DAM y DAW', 1),
(2, 'Programación', 'Asignatura común en 1º de DAM y DAW', 1),
(3, 'Lenguaje de Marcas', 'Asignatura común en 1º de DAM y DAW', 1),
(4, 'Entornos de Desarrollo', 'Asignatura común en 1º de DAM y DAW', 1),
(5, 'Sistemas Informáticos', 'Asignatura común en 1º de DAM y DAW', 1),
(6, 'Digitalización', 'Asignatura común en 1º de DAM y DAW', 1),
(7, 'Desarrollo Entorno Servidor', 'Asignatura de 2º curso de DAW', 4),
(8, 'Formación y Orientación Laboral', 'Asignatura común en 1º de DAM y DAW', 1),
(9, 'Acceso a Datos', 'Asignatura de 2º curso de DAM', 2),
(10, 'Desarrollo de Interfaces', 'Asignatura de 2º curso de DAM', 2),
(11, 'Programación Multimedia y Dispositivos Móviles', 'Asignatura de 2º curso de DAM', 2),
(12, 'Programación de Servicios y Procesos', 'Asignatura de 2º curso de DAM', 2),
(13, 'Sistemas de Gestión Empresarial', 'Asignatura de 2º curso de DAM', 2),
(14, 'Empresa e Iniciativa Emprendedora', 'Asignatura de 2º curso de DAM', 2),
(15, 'Proyecto de Desarrollo de Aplicaciones Multiplataforma', 'Asignatura de 2º curso de DAM', 2),
(16, 'Formación en Centros de Trabajo', 'Asignatura de 2º curso de DAM', 2),
(17, 'Desarrollo Web en Entorno Cliente', 'Asignatura de 2º curso de DAW', 4),
(18, 'Despliegue de Aplicaciones Web', 'Asignatura de 2º curso de DAW', 4),
(19, 'Diseño de Interfaces Web', 'Asignatura de 2º curso de DAW', 4),
(20, 'Empresa e Iniciativa Emprendedora', 'Asignatura de 2º curso de DAW', 4),
(21, 'Proyecto de Desarrollo de Aplicaciones Web', 'Asignatura de 2º curso de DAW', 4),
(22, 'Formación en Centros de Trabajo', 'Asignatura de 2º curso de DAW', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `asignatura_id` bigint(20) UNSIGNED NOT NULL,
  `evaluacion` tinyint(4) NOT NULL,
  `porcentaje_asistencia` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`id`, `alumno_id`, `asignatura_id`, `evaluacion`, `porcentaje_asistencia`) VALUES
(19, 128, 1, 1, 97.90),
(20, 129, 1, 1, 90.90),
(21, 130, 1, 1, 98.90),
(22, 131, 1, 1, 45.50),
(23, 132, 1, 1, 97.70),
(24, 133, 1, 1, 91.40),
(25, 134, 1, 1, 98.90),
(26, 135, 1, 1, 98.90),
(27, 136, 1, 1, 97.60),
(28, 137, 1, 1, 97.80),
(29, 138, 1, 1, 95.00),
(30, 139, 1, 1, 93.80),
(31, 140, 1, 1, 97.80),
(32, 141, 1, 1, 98.80),
(33, 142, 1, 1, 89.20),
(34, 143, 1, 1, 96.70),
(35, 144, 1, 1, 96.50),
(36, 145, 1, 1, 96.80);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco_preguntas`
--

CREATE TABLE `banco_preguntas` (
  `id` int(11) NOT NULL,
  `enunciado` text DEFAULT NULL,
  `dificultad` enum('baja','media','alta') DEFAULT 'media',
  `etiqueta_id` bigint(20) DEFAULT NULL,
  `tema_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `puntuacion` decimal(5,2) NOT NULL DEFAULT 1.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `banco_preguntas_en_examen`
--

INSERT INTO `banco_preguntas_en_examen` (`examen_id`, `pregunta_id`, `puntuacion`) VALUES
(2, 1, 1.00),
(3, 1, 4.50),
(3, 2, 4.50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterios_evaluacion`
--

CREATE TABLE `criterios_evaluacion` (
  `id` int(11) NOT NULL,
  `resultado_aprendizaje_id` int(11) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `criterios_evaluacion`
--

INSERT INTO `criterios_evaluacion` (`id`, `resultado_aprendizaje_id`, `descripcion`) VALUES
(1, 1, 'Se han analizado los sistemas lógicos de almacenamiento y sus características.'),
(2, 1, 'Se han identificado los distintos tipos de bases de datos según el modelo de datos utilizado.'),
(3, 1, 'Se han identificado los distintos tipos de bases de datos en función de la ubicación de la información.'),
(4, 1, 'Se ha evaluado la utilidad de un sistema gestor de bases de datos.'),
(5, 1, 'Se han clasificado los sistemas gestores de bases de datos.'),
(6, 1, 'Se ha reconocido la función de cada uno de los elementos de un sistema gestor de bases de datos.'),
(7, 1, 'Se ha reconocido la utilidad de las bases de datos distribuidas.'),
(8, 1, 'Se han analizado las políticas de fragmentación de la información.'),
(9, 2, 'Se ha analizado el formato de almacenamiento de la información.'),
(10, 2, 'Se han creado las tablas y las relaciones entre ellas.'),
(11, 2, 'Se han seleccionado los tipos de datos adecuados.'),
(12, 2, 'Se han definido los campos clave en las tablas.'),
(13, 2, 'Se han implantado las restricciones reflejadas en el diseño lógico.'),
(14, 2, 'Se han utilizado asistentes, herramientas gráficas y los lenguajes de definición y control de datos.'),
(15, 3, 'Se han identificado las herramientas y sentencias para realizar consultas.'),
(16, 3, 'Se han realizado consultas simples sobre una tabla.'),
(17, 3, 'Se han realizado consultas sobre el contenido de varias tablas mediante composiciones internas.'),
(18, 3, 'Se han realizado consultas sobre el contenido de varias tablas mediante composiciones externas.'),
(19, 3, 'Se han realizado consultas resumen.'),
(20, 3, 'Se han realizado consultas con subconsultas.'),
(21, 4, 'Se han identificado las herramientas y sentencias para modificar el contenido de la base de datos.'),
(22, 4, 'Se han insertado, borrado y actualizado datos en las tablas.'),
(23, 4, 'Se ha incluido en una tabla la información resultante de la ejecución de una consulta.'),
(24, 4, 'Se han diseñado guiones de sentencias para llevar a cabo tareas complejas.'),
(25, 4, 'Se ha reconocido el funcionamiento de las transacciones.'),
(26, 4, 'Se han anulado parcial o totalmente los cambios producidos por una transacción.'),
(27, 4, 'Se han identificado los efectos de las distintas políticas de bloqueo de registros.'),
(28, 4, 'Se han adoptado medidas para mantener la integridad y consistencia de la información.'),
(29, 5, 'Se han identificado las diversas formas de automatizar tareas.'),
(30, 5, 'Se han reconocido los métodos de ejecución de guiones.'),
(31, 5, 'Se han identificado las herramientas disponibles para editar guiones.'),
(32, 5, 'Se han definido y utilizado guiones para automatizar tareas.'),
(33, 5, 'Se han utilizado estructuras de control de flujo.'),
(34, 5, 'Se ha hecho uso de las funciones proporcionadas por el sistema gestor.'),
(35, 5, 'Se han definido funciones de usuario.'),
(36, 5, 'Se han definido disparadores.'),
(37, 5, 'Se han utilizado cursores.'),
(38, 6, 'Se han utilizado herramientas gráficas para representar el diseño lógico.'),
(39, 6, 'Se han identificado las tablas del diseño lógico.'),
(40, 6, 'Se han identificado los campos que forman parte de las tablas del diseño lógico.'),
(41, 6, 'Se han analizado las relaciones entre las tablas del diseño lógico.'),
(42, 6, 'Se han identificado los campos clave.'),
(43, 6, 'Se han aplicado reglas de integridad.'),
(44, 6, 'Se han aplicado reglas de normalización.'),
(45, 6, 'Se han analizado y documentado las restricciones que no pueden plasmarse en el diseño lógico.'),
(46, 7, 'Se han identificado las características de las bases de datos objeto-relacionales.'),
(47, 7, 'Se han creado tipos de datos objeto, sus atributos y métodos.'),
(48, 7, 'Se han creado tablas de objetos y tablas de columnas tipo objeto.'),
(49, 7, 'Se han creado tipos de datos colección.'),
(50, 7, 'Se han realizado consultas.'),
(51, 7, 'Se ha modificado la información almacenada manteniendo la integridad y consistencia de los datos.');

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
  `tipo` varchar(20) DEFAULT NULL,
  `puntuacion` decimal(5,2) DEFAULT 1.00,
  `orden` int(11) DEFAULT NULL,
  `etiqueta_id` int(11) DEFAULT NULL,
  `tema_id` int(11) DEFAULT NULL,
  `dificultad` enum('baja','media','alta') DEFAULT 'media'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejercicios`
--

INSERT INTO `ejercicios` (`id`, `examen_id`, `enunciado`, `tipo`, `puntuacion`, `orden`, `etiqueta_id`, `tema_id`, `dificultad`) VALUES
(4, 2, 'Devuelve los nombres de los personajes que pertenecen a la casa \"Stark\".', 'abierta', 1.60, 1, 3, NULL, 'media'),
(5, 2, 'Devuelve el nombre de la batalla que se ha librado en \"Meereen\".', 'abierta', 1.60, 2, 3, NULL, 'media'),
(6, 2, 'Devuelve el título del personaje que ha participado en una batalla cuyo resultado ha sido \"Derrota\".', 'abierta', 1.60, 3, 3, NULL, 'media'),
(7, 2, 'Devuelve una lista con los personajes y el número de batallas en las que ha participado cada uno.', 'abierta', 1.60, 4, 4, NULL, 'media'),
(8, 2, 'Devuelve un resumen en XML con todos los nombres de personajes y el nombre de cada batalla, con esta estructura:\r\n\r\n<resumen>\r\n\r\n  <personaje nombre=\"Jon Snow\">\r\n\r\n    <batalla>Batalla de los Bastardos</batalla>\r\n\r\n  </personaje>\r\n\r\n  ...\r\n\r\n</resumen>', 'abierta', 1.60, 5, 4, NULL, 'media'),
(9, 2, 'Devuelve la lista de casas con el número total de victorias obtenidas por sus personajes, ordenada de mayor a menor número de victorias. EL resultado debe tener este formato: \r\n\r\n<casa nombre=\"Stark\" victorias=\"4\"/>\r\n\r\n<casa nombre=\"Lannister\" victorias=\"2\"/>\r\n\r\n<casa nombre=\"Targaryen\" victorias=\"1\"/>\r\n\r\n\r\n<casa nombre=\"Tarth\" victorias=\"1\"/>', 'abierta', 1.60, 6, 4, NULL, 'media'),
(10, 3, 'dtjdfthjfhj', 'abierta', 1.00, 1, 1, NULL, 'media');

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
  `enunciado` text DEFAULT NULL,
  `solucion` text DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ejercicios_propuestos`
--

INSERT INTO `ejercicios_propuestos` (`id`, `tema_id`, `etiqueta_id`, `tipo`, `dificultad`, `enunciado`, `solucion`, `activo`, `creado_en`) VALUES
(1, 1, 3, 'desarrollo', 'media', 'sdfasdfasasdf', '', 1, '2025-06-16 07:38:06'),
(2, 1, 3, 'desarrollo', 'baja', 'vbndfghdfhdfghdfghdfghd', '', 1, '2025-06-16 08:47:29'),
(3, NULL, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\n\n**Enunciado:**\nCrea un documento XML que represente una base de datos de estudiantes con los siguientes campos:\n\n* nombre\n* edad\n* carrera (Ingeniería, Diseño Gráfico o Informática)\n* promedio\n\nLuego, utilizando la etiqueta XQuery, escribe un documento que liste todos los estudiantes que tienen un promedio superior a 8.5 y pertenecen a la carrera de Ingeniería.\n\n**Instrucciones:**\n\n1. Crea el documento XML que represente la base de datos de estudiantes.\n2. Utiliza la etiqueta XQuery para escribir un documento que liste los estudiantes con un promedio superior a 8.5 y pertenecen a la carrera de Ingeniería.\n3. No te olvides de utilizar la sintaxis correcta para la etiqueta XQuery.\n4. Procede a resolver el ejercicio sin ayudas ni consultas externas.\n\n**Tu tarea:**\nEscribe el documento XML y la consulta XQuery que cumplan con los requisitos del enunciado.', NULL, 1, '2025-07-03 15:19:04'),
(4, NULL, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\n\n**Ejercicio 1: Consulta de datos**\n\nConsiderando un conjunto de datos sobre empleados almacenados en un archivo XML, escribe una consulta XQuery que devuelva la lista de empleados con salario superior a 30.000 euros.\n\n**Puedes utilizar las siguientes sentencias XQuery para resolver el ejercicio:** \n\n* let\n* where\n* for\n* return\n\n**No te preocupes por la estructura del archivo XML, solo enfócate en escribir la consulta XQuery correcta.**\n\n?', NULL, 1, '2025-07-03 15:22:08'),
(5, 3, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\r\n\r\n**Enunciado:** Considere una base de datos XML que almacena información sobre libros y autores. La estructura de la base de datos es la siguiente:\r\n\r\n```xml\r\n<libros>\r\n  <libro>\r\n    <titulo>Título del libro</titulo>\r\n    <autor>Nombre del autor</autor>\r\n  </libro>\r\n  ...\r\n</libros>\r\n```\r\n\r\nEscriba un fragmento de código XQuery que recupere la lista de títulos de libros escritos por el autor \"John Doe\".\r\n\r\n**Nota:** No utilice funciones de ordenamiento ni limitación.', '', 1, '2025-07-03 15:24:33'),
(6, 3, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\r\n\r\nEn este ejercicio, te pedimos que utilices la etiqueta XQuery para consultar una base de datos XML y obtener los siguientes resultados:\r\n\r\n**Ejercicio 1:**\r\nConsultar la siguiente base de datos XML:\r\n```xml\r\n<libros>\r\n  <libro titulo=\"Harry Potter\" autor=\"J.K. Rowling\">\r\n    <capitulo num=\"1\">Capítulo inicial</capitulo>\r\n    <capitulo num=\"2\">El poder de los amigos</capitulo>\r\n    <!-- ... -->\r\n  </libro>\r\n  <libro titulo=\"El Señor de los Anillos\" autor=\"J.R.R. Tolkien\">\r\n    <capitulo num=\"1\">En el principio</capitulo>\r\n    <capítulo num=\"2\">La formación de las Compañías</capítulo>\r\n    <!-- ... -->\r\n  </libro>\r\n  <!-- ... -->\r\n</libros>\r\n```\r\nUtilizando XQuery, obtén la lista de títulos de los libros escritos por J.R.R. Tolkien.\r\n\r\n**Ejercicio 2:**\r\nConsigue la cantidad total de capítulos en todos los libros que tienen al menos un capítulo con el número \"1\".', '', 1, '2025-07-03 15:24:45'),
(7, 3, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\r\n\r\nEn esta actividad, te pedimos que crees un query XQuery para obtener la información necesaria a continuación:\r\n\r\nEscribe un query XQuery que devuelva la lista de empleados (nombre y edad) que tienen más de 30 años y trabajan en el departamento de Desarrollo de Aplicaciones.\r\n\r\n**Nota:** Asegúrate de utilizar correctamente las etiquetas y sintaxis de XQuery para resolver este ejercicio.', '', 1, '2025-07-03 15:24:56'),
(8, 3, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\r\n\r\nEn esta actividad, te pedimos que practiques con la etiqueta XQuery utilizando los siguientes ejercicios.\r\n\r\n**Ejercicio 1: Consulta simples**\r\n\r\nSupongamos que tienes un archivo XML llamado \"empleados.xml\" que contiene información sobre empleados. El archivo tiene la siguiente estructura:\r\n```xml\r\n<empleados>\r\n    <empleado>\r\n        <nombre>John</nombre>\r\n        <apellido>Doe</apellido>\r\n        <edad>30</edad>\r\n    </empleado>\r\n    ...\r\n</empleados>\r\n```\r\nEscribe un script XQuery que devuelva el nombre y la edad de todos los empleados.\r\n\r\n**Tiempo límite: 10 minutos**\r\n\r\nNo debes dar pistas ni soluciones, solo intenta responder al ejercicio con la etiqueta XQuery.', '', 1, '2025-07-03 15:25:49'),
(9, 3, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\r\n\r\n**Ejercicio 1: Consulta de datos en una base de datos XML**\r\n\r\nLa base de datos \"Alumnos\" contiene información sobre los estudiantes de un instituto, almacenada en un archivo XML con la siguiente estructura:\r\n\r\n```xml\r\n<alumnos>\r\n    <alumno>\r\n        <nombre>Juan</nombre>\r\n        <apellido>Pérez</apellido>\r\n        <edad>19</edad>\r\n        <promedio>8.5</promedio>\r\n    </alumno>\r\n    ...\r\n</alumnos>\r\n```\r\n\r\nEscriba una consulta XQuery que devuelva el nombre y promedio de todos los estudiantes cuyo apellido sea \"Pérez\" y su edad sea mayor o igual a 20.\r\n\r\n**Recuerda que no debes utilizar archivos adjuntos ni obtener pistas, solo utiliza tu conocimiento para resolver el ejercicio.**', '', 1, '2025-07-03 15:26:00'),
(10, 3, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\r\n\r\n**Ejercicio 1:** \"Consultar un conjunto de datos\"\r\n\r\nConsidere el siguiente conjunto de datos XML:\r\n```xml\r\n<productos>\r\n    <producto id=\"P001\" nombre=\"Camisa azul\" precio=\"25.00\">\r\n        <descripcion>Camisa para hombre</descripcion>\r\n    </producto>\r\n    <producto id=\"P002\" nombre=\"Pantalonazos rojos\" precio=\"30.00\">\r\n        <descripcion>Ropa interior para hombre</descripcion>\r\n    </producto>\r\n    <producto id=\"P003\" nombre=\"Zapatos negros\" precio=\"50.00\">\r\n        <descripcion>Zapatos para hombre</descripcion>\r\n    </producto>\r\n    <!-- más productos... -->\r\n</productos>\r\n```\r\nEscriba un XQuery que devuelva la lista de productos con precios inferiores a 30 euros.\r\n\r\n**Tiempo límite:** 15 minutos', '', 1, '2025-07-03 15:26:08'),
(11, 3, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: \"XQuery\"**\r\n\r\n**Enunciado:** Utiliza XQuery para obtener la lista de empleados que trabajan en el departamento de desarrollo de aplicaciones de una empresa llamada \"Emprendedores del Futuro\". La base de datos contiene las siguientes colecciones:\r\n\r\n* `empleados`: con los siguientes campos: `nombre`, `apellido`, `departamento` y `id`.\r\n* `departamentos`: con los siguientes campos: `id`, `nombre` y `jefe`.\r\n\r\nLa consulta debe devolver la lista de empleados que trabajan en el departamento de desarrollo de aplicaciones (con id=1) y mostrar los campos `nombre`, `apellido` y `departamento`.', '', 1, '2025-07-03 15:26:17'),
(12, 3, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\r\n\r\nEn este ejercicio, te pedimos que utilices la etiqueta XQuery para recuperar información de un archivo XML.\r\n\r\n**Ejercicio 1:** Supongamos que tienes un archivo XML que describe a diferentes empleados y sus respectivos departamentos. El archivo se llama `empleados.xml` y contiene los siguientes elementos:\r\n```xml\r\n<empleados>\r\n  <empleado id=\"1\">\r\n    <nombre>Juan</nombre>\r\n    <apellido>Pérez</apellido>\r\n    <departamento>Desarrollo</departamento>\r\n  </empleado>\r\n  <empleado id=\"2\">\r\n    <nombre>Maria</nombre>\r\n    <apellido>García</apellido>\r\n    <departamento>Ventas</departamento>\r\n  </empleado>\r\n  ...\r\n</empleados>\r\n```\r\nEscribe una consulta XQuery que devuelva el nombre y apellido de todos los empleados que trabajan en el departamento de Ventas.\r\n\r\n**Recuerda:** Utiliza la etiqueta `for` para iterar sobre los elementos `empleado`, y la función `contains` para filtrar por el departamento.', '', 1, '2025-07-03 15:26:28'),
(13, NULL, 3, 'desarrollo', 'media', '**Actividad de Refuerzo: XPath**\n\nEn esta actividad, te pedimos que utilices la etiqueta XPath para acceder y recopilar información de un archivo XML. A continuación, encontrarás un ejemplo de XML que debes trabajar:\n\n```\n<libros>\n  <libro>\n    <isbn>1234567890</isbn>\n    <titulo>Hemingway</titulo>\n    <autor>Erich Maria Remarque</autor>\n  </libro>\n  <libro>\n    <isbn>9876543210</isbn>\n    <titulo>1984</titulo>\n    <autor>George Orwell</autor>\n  </libro>\n</libros>\n```\n\n**Ejercicio:** Utilizando la etiqueta XPath, escribe una expresión para obtener la lista de títulos de los libros que tienen un autor que comience con la letra \"O\".\n\n(Remember, no hay pistas ni soluciones, solo el enunciado!)', NULL, 1, '2025-07-03 18:46:24'),
(14, NULL, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\n\n**Ejercicio 1:** Escribe un documento XQuery que devuelva la lista de empleados con edad superior a 30 años y salario mayor o igual a 25.000€, ordenados por edad descendentemente.\n\n(Remember to use the correct XQuery syntax and structure)', NULL, 1, '2025-07-05 10:30:41'),
(15, NULL, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\n\n**Ejercicio 1:** \"Consultando datos en una base de datos XML\"\n\nConsigue la siguiente información sobre un departamento de una empresa:\n\nDepartamento nombre=\"Ventas\"\nEmpleados (nombre=\"Juan\", edad=25, salario=2500)\nEmpleados (nombre=\"María\", edad=30, salario=3000)\nProductos (nombre=\"PC\", precio=500)\nProductos (nombre=\"Tablet\", precio=800)\n\nUsa la etiqueta XQuery para obtener la lista de empleados que ganan más de 2800 euros.', NULL, 1, '2025-07-05 10:39:36'),
(16, NULL, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\n\n**Ejercicio 1: Consulta de datos**\n\nSupongamos que tenemos una base de datos XML con la siguiente estructura:\n```xml\n<libros>\n  <libro>\n    <titulo>El Principito</itulo>\n    <autor>Antoine de Saint-Exupéry</autor>\n    <editorial>Edebé</editorial>\n  </libro>\n  <libro>\n    <titulo>1984</titulo>\n    <autor>George Orwell</autor>\n    <editorial>Martínez Roca</editorial>\n  </libro>\n  ...\n</libros>\n```\nNecesitamos obtener la lista de títulos de libros publicados por la editorial Edebé. Utiliza XQuery para resolver este problema y muestra el resultado.\n\n**Ejercicio 2: Filtro de datos**\n\nSupongamos que tenemos una base de datos XML con la siguiente estructura:\n```xml\n<autores>\n  <autor>\n    <nombre>John</nombre>\n    <apellido>Doe</apellido>\n    <edad>30</edad>\n  </autor>\n  <autor>\n    <nombre>Jane</nombre>\n    <apellido>Roe</apellido>\n    <edad>25</edad>\n  </autor>\n  ...\n</autores>\n```\nNecesitamos obtener la lista de autores que tienen más de 30 años. Utiliza XQuery para resolver este problema y muestra el resultado.\n\n**Ejercicio 3: Transformación de datos**\n\nSupongamos que tenemos una base de datos XML con la siguiente estructura:\n```xml\n<personas>\n  <persona>\n    <nombre>Pepe</nombre>\n    <apellido>Pérez</apellido>\n    <edad>25</edad>\n  </persona>\n  <persona>\n    <nombre>Juan</nombre>\n    <apellido>González</apellido>\n    <edad>30</edad>\n  </persona>\n  ...\n</personas>\n```\nNecesitamos convertir la estructura XML en un formato JSON que contenga solo los nombres y apellidos de las personas. Utiliza XQuery para resolver este problema y muestra el resultado.\n\n**Ejercicio 4: Agrupación de datos**\n\nSupongamos que tenemos una base de datos XML con la siguiente estructura:\n```xml\n<libros>\n  <libro>\n    <titulo>El Principito</itulo>\n    <autor>Antoine de Saint-Exupéry</autor>\n    <editorial>Edebé</editorial>\n  </libro>\n  <libro>\n    <titulo>1984</titulo>\n    <autor>George Orwell</autor>\n    <editorial>Martínez Roca</editorial>\n  </libro>\n  ...\n</libros>\n```\nNecesitamos obtener la lista de editoriales y el número de libros publicados por cada editorial. Utiliza XQuery para resolver este problema y muestra el resultado.\n\nPuedes utilizar cualquier herramienta o entorno que desees (por ejemplo, oXygen, BaseX, etc.) para realizar los ejercicios.', NULL, 1, '2025-07-05 10:40:03'),
(17, NULL, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\n\nEnunciado:\n\nCrea un consulta XQuery que devuelva la lista de empleados con edad superior a 35 años y que tienen como función principal \"Desarrollador de Aplicaciones\". La consulta debe considerar el siguiente esquema XML:\n```xml\n<empleados>\n    <empleado>\n        <nombre>Nombre1</nombre>\n        <edad>25</edad>\n        <funcion>Analista</funcion>\n    </empleado>\n    <empleado>\n        <nombre>Nombre2</nombre>\n        <edad>40</edad>\n        <funcion>Desarrollador de Aplicaciones</funcion>\n    </empleado>\n    ...\n</empleados>\n```\n¿Puedes crear una consulta XQuery que cumpla con los requisitos descritos?', NULL, 1, '2025-07-05 10:45:42'),
(18, NULL, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\n\nEn este ejercicio, te pedimos que escribas un conjunto de instrucciones XQuery que devuelvan la lista de empleados que tienen más de 30 años y trabajan en el departamento de marketing.\n\nLa base de datos contiene los siguientes campos:\n\n* `nombre`: String\n* `edad`: Integer\n* `departamento`: String\n\nEscribe una consulta XQuery que cumpla con las condiciones mencionadas y devuelva la lista de empleados que tienen más de 30 años y trabajan en el departamento de marketing.\n\nNo olvides utilizar correctamente la sintaxis de XQuery y los operadores para resolver este ejercicio.', NULL, 1, '2025-07-05 10:45:48'),
(19, NULL, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\n\n**Enunciado**: Implementa una consulta XQuery que devuelva la lista de empleados con su edad mayor o igual a 30 años y trabajando en el departamento \"Ventas\" en la base de datos siguiente:\n\n```\n<empleados>\n    <empleado id=\"1\">\n        <nombre>Juan</nombre>\n        <edad>35</edad>\n        <departamento>Ventas</departamento>\n    </empleado>\n    <empleado id=\"2\">\n        <nombre>Laura</nombre>\n        <edad>25</edad>\n        <departamento>Marketing</departamento>\n    </empleado>\n    <empleado id=\"3\">\n        <nombre>Pedro</nombre>\n        <edad>40</edad>\n        <departamento>Ventas</departamento>\n    </empleado>\n    ...\n</empleados>\n```\n\n**Tarea**: Escriba una consulta XQuery que cumpla con los siguientes requisitos:\n\n* Devuelve la lista de empleados con su edad mayor o igual a 30 años.\n* Filtra por el departamento \"Ventas\".\n* No incluya campos adicionales más allá del id y el nombre del empleado.\n\n**¿Qué puedes hacer?**: Utiliza tu conocimiento sobre XQuery para crear una consulta que satisfaga los requisitos descritos.', NULL, 1, '2025-07-05 10:47:29'),
(20, NULL, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\n\n**Enunciado:**\n\nCrea un documento XML que represente una base de datos de empleados con los siguientes campos: `id`, `nombre`, `apellidos`, `edad` y `departamento`. Luego, utilizando la etiqueta XQuery, escribe una consulta que devuelva la lista de empleados cuya edad sea mayor o igual a 30 años y que pertenezcan al departamento de \"Ingeniería\".\n\n**Recuerda utilizar solo las funciones y operadores XQuery aprendidos en clase.**\n\n? ¡Comienza!', NULL, 1, '2025-07-05 10:48:01'),
(21, NULL, 4, 'desarrollo', 'media', '**Actividad de Refuerzo: XQuery**\n\nEn este ejercicio, te pedimos que utilices la etiqueta XQuery para resolver un problema de bases de datos.\n\n**Ejercicio:**\n\nUn sistema de gestión de inventarios necesita obtener una lista de todos los productos cuyo precio sea mayor o igual a 50 euros y que estén almacenados en el almacén número 3. La base de datos contiene las siguientes colecciones:\n\n* `productos`: con los campos `nombre`, `precio` y `almacen`\n* `almacenes`: con los campos `id` y `ubicacion`\n\nUtiliza la etiqueta XQuery para escribir una consulta que devuelva la lista de productos que cumplan con las condiciones mencionadas.\n\n**Ponte a trabajar!**', NULL, 1, '2025-07-05 10:51:06'),
(22, NULL, 1, 'desarrollo', 'media', '**Actividad de Refuerzo: \"DML\" - Bases de Datos**\n\n**Enunciado:**\n\nSupongamos que tienes una base de datos con la siguiente estructura:\n\n* Una tabla llamada \"empleados\" con las columnas \"id\", \"nombre\", \"apellido\", \"edad\" y \"salario\".\n* Una tabla llamada \"departamentos\" con las columnas \"id\", \"nombre\" y \"jefe\".\n\nEscribe un comando DML (Data Manipulation Language) que permita actualizar el salario de todos los empleados que trabajan en el departamento de \"Ventas\" y tienen una edad superior a 35 años, asignándoles un aumento del 10%.\n\n**Tu objetivo es escribir el comando DML correspondiente. ¡Vamos! ?', NULL, 1, '2025-07-05 11:38:06'),
(23, NULL, 1, 'desarrollo', 'media', '**Actividad de Refuerzo: \"DML\" de la asignatura \"Bases de Datos\"**\n\n? Enunciado:\n\nConsidere una base de datos que contiene información sobre los empleados de una empresa. La tabla `empleados` tiene las siguientes columnas:\n\n| Columna | Tipo |\n| --- | --- |\n| id_empleado | integer (Primary Key) |\n| nombre | varchar(255) |\n| edad | integer |\n| departamento | varchar(50) |\n\nUtilice la etiqueta DML (Data Manipulation Language) para realizar las siguientes operaciones sobre la tabla `empleados`:\n\n1. Agregue un nuevo registro con los siguientes valores: id_empleado = 5, nombre = \"Juan Pérez\", edad = 32 y departamento = \"Ventas\".\n2. Actualice el registro que tiene el id_empleado = 3 para que tenga la edad de 45 años.\n3. Elimine el registro que tiene el id_empleado = 7.\n\n? ¡Puedes hacerlo!', NULL, 1, '2025-07-05 11:38:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cif` varchar(20) DEFAULT NULL,
  `responsable_nombre` varchar(255) DEFAULT NULL,
  `email_contacto` varchar(255) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `nombre`, `cif`, `responsable_nombre`, `email_contacto`, `telefono`) VALUES
(1, 'ViewNext', '555555555', 'Responsable', 'viewnext@viewnext.com', '666666666');

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
-- Estructura de tabla para la tabla `evaluaciones`
--

CREATE TABLE `evaluaciones` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `asignatura_id` int(11) NOT NULL,
  `numero_evaluacion` tinyint(4) NOT NULL,
  `ponderacion_examenes` decimal(4,2) NOT NULL,
  `ponderacion_actividades` decimal(4,2) NOT NULL,
  `ponderacion_asistencia` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `evaluaciones`
--

INSERT INTO `evaluaciones` (`id`, `curso_id`, `asignatura_id`, `numero_evaluacion`, `ponderacion_examenes`, `ponderacion_actividades`, `ponderacion_asistencia`) VALUES
(1, 1, 1, 1, 0.40, 0.40, 0.20);

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
  `hora` time NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `evaluacion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `examenes`
--

INSERT INTO `examenes` (`id`, `titulo`, `descripcion`, `asignatura_id`, `fecha`, `hora`, `tipo`, `evaluacion`) VALUES
(2, 'Examen Final Tercer Trimestre', '', 1, '2025-06-07', '11:30:00', 'evaluación', 1),
(3, 'Test de examen', 'Testeo del banco de preguntas', 1, '2025-07-31', '12:30:00', 'evaluación', 1),
(5, 'Examen Primer Parcial 24/25', '', 1, '2025-06-01', '08:30:00', 'diagnóstico', 1);

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
-- Estructura de tabla para la tabla `notas_examen_alumno`
--

CREATE TABLE `notas_examen_alumno` (
  `id` int(11) NOT NULL,
  `examen_id` bigint(20) NOT NULL,
  `alumno_id` int(11) NOT NULL,
  `nota_total` decimal(5,2) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `notas_examen_alumno`
--

INSERT INTO `notas_examen_alumno` (`id`, `examen_id`, `alumno_id`, `nota_total`, `fecha_registro`) VALUES
(1, 3, 128, 2.10, '2025-06-19 10:47:34'),
(2, 3, 129, 1.10, '2025-06-19 10:47:34'),
(3, 3, 130, 0.20, '2025-06-19 10:47:34'),
(4, 3, 131, 2.00, '2025-06-19 10:47:34'),
(5, 3, 132, 2.20, '2025-06-19 10:47:34'),
(6, 3, 133, 1.50, '2025-06-19 10:47:34'),
(7, 3, 134, 1.00, '2025-06-19 10:47:34'),
(8, 3, 135, 1.00, '2025-06-19 10:47:34'),
(9, 3, 136, 1.00, '2025-06-19 10:47:34'),
(10, 3, 137, 1.00, '2025-06-19 10:47:34'),
(11, 3, 138, 1.00, '2025-06-19 10:47:34'),
(12, 3, 139, 1.00, '2025-06-19 10:47:34'),
(13, 3, 140, 1.00, '2025-06-19 10:47:34'),
(14, 3, 141, 1.70, '2025-06-19 10:47:34'),
(15, 3, 142, 1.00, '2025-06-19 10:47:34'),
(16, 3, 143, 1.00, '2025-06-19 10:47:34'),
(17, 3, 144, 1.00, '2025-06-19 10:47:34'),
(18, 3, 145, 2.00, '2025-06-19 10:47:34'),
(55, 2, 128, 5.50, '2025-06-19 10:49:39'),
(56, 2, 129, 6.30, '2025-06-19 10:49:39'),
(57, 2, 130, 9.00, '2025-06-19 10:49:39'),
(58, 2, 131, 6.80, '2025-06-19 10:49:39'),
(59, 2, 132, 6.40, '2025-06-19 10:49:39'),
(60, 2, 133, 7.00, '2025-06-19 10:49:39'),
(61, 2, 134, 9.60, '2025-06-19 10:49:39'),
(62, 2, 135, 9.50, '2025-06-19 10:49:39'),
(63, 2, 136, 6.00, '2025-06-19 10:49:39'),
(64, 2, 137, 6.00, '2025-06-19 10:49:39'),
(65, 2, 138, 3.00, '2025-06-19 10:49:39'),
(66, 2, 139, 9.96, '2025-06-19 10:49:39'),
(67, 2, 140, 6.60, '2025-06-19 10:49:39'),
(68, 2, 141, 8.65, '2025-06-19 10:49:39'),
(69, 2, 142, 6.00, '2025-06-19 10:49:39'),
(70, 2, 143, 4.00, '2025-06-19 10:49:39'),
(71, 2, 144, 5.50, '2025-06-19 10:49:39'),
(72, 2, 145, 7.10, '2025-06-19 10:49:39'),
(73, 5, 128, 10.00, '2025-06-19 10:53:01'),
(74, 5, 129, 10.00, '2025-06-19 10:53:01'),
(75, 5, 130, 10.00, '2025-06-19 10:53:01'),
(76, 5, 131, 4.00, '2025-06-19 10:53:01'),
(77, 5, 132, 10.00, '2025-06-19 10:53:01'),
(78, 5, 133, 10.00, '2025-06-19 10:53:01'),
(79, 5, 134, 9.00, '2025-06-19 10:53:01'),
(80, 5, 135, 0.00, '2025-06-19 10:53:01'),
(81, 5, 136, 10.00, '2025-06-19 10:53:01'),
(82, 5, 137, 9.00, '2025-06-19 10:53:01'),
(83, 5, 138, 5.00, '2025-06-19 10:53:01'),
(84, 5, 139, 10.00, '2025-06-19 10:53:01'),
(85, 5, 140, 10.00, '2025-06-19 10:53:01'),
(86, 5, 141, 9.00, '2025-06-19 10:53:01'),
(87, 5, 142, 10.00, '2025-06-19 10:53:01'),
(88, 5, 143, 10.00, '2025-06-19 10:53:01'),
(89, 5, 144, 9.00, '2025-06-19 10:53:01'),
(90, 5, 145, 8.00, '2025-06-19 10:53:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas_finales_evaluacion`
--

CREATE TABLE `notas_finales_evaluacion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) UNSIGNED NOT NULL,
  `asignatura_id` bigint(20) UNSIGNED NOT NULL,
  `evaluacion_id` bigint(20) UNSIGNED NOT NULL,
  `nota_examenes` decimal(5,2) DEFAULT NULL,
  `nota_actividades` decimal(5,2) DEFAULT NULL,
  `asistencia` decimal(5,2) DEFAULT NULL,
  `nota_final` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notas_finales_evaluacion`
--

INSERT INTO `notas_finales_evaluacion` (`id`, `alumno_id`, `curso_id`, `asignatura_id`, `evaluacion_id`, `nota_examenes`, `nota_actividades`, `asistencia`, `nota_final`) VALUES
(1, 128, 1, 1, 1, 4.90, 6.00, 0.00, 4.36),
(2, 129, 1, 1, 1, 5.80, 7.00, 0.00, 5.12),
(3, 130, 1, 1, 1, 6.73, 8.00, 0.00, 5.89),
(4, 131, 1, 1, 1, 4.27, 9.00, 0.00, 5.31),
(5, 132, 1, 1, 1, 6.20, 6.00, 0.00, 4.88),
(6, 133, 1, 1, 1, 6.17, 6.00, 0.00, 4.87),
(7, 134, 1, 1, 1, 6.53, 6.00, 0.00, 5.01),
(8, 135, 1, 1, 1, 3.50, 6.00, 0.00, 3.80),
(9, 136, 1, 1, 1, 5.67, 6.00, 0.00, 4.67),
(10, 137, 1, 1, 1, 5.33, 7.00, 0.00, 4.93),
(11, 138, 1, 1, 1, 3.00, 7.00, 0.00, 4.00),
(12, 139, 1, 1, 1, 6.99, 7.00, 0.00, 5.60),
(13, 140, 1, 1, 1, 5.87, 7.90, 0.00, 5.51),
(14, 141, 1, 1, 1, 6.45, 8.00, 0.00, 5.78),
(15, 142, 1, 1, 1, 5.67, 8.00, 0.00, 5.47),
(16, 143, 1, 1, 1, 5.00, 8.00, 0.00, 5.20),
(17, 144, 1, 1, 1, 5.17, 9.00, 0.00, 5.67),
(18, 145, 1, 1, 1, 5.53, 10.00, 0.00, 6.21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones_banco_pregunta`
--

CREATE TABLE `opciones_banco_pregunta` (
  `id` int(11) NOT NULL,
  `pregunta_id` int(11) DEFAULT NULL,
  `texto` varchar(255) DEFAULT NULL,
  `es_correcta` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
-- Estructura de tabla para la tabla `ra_empresa_alumno`
--

CREATE TABLE `ra_empresa_alumno` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `ra_id` int(11) NOT NULL,
  `trabajado` tinyint(1) DEFAULT 0,
  `observaciones` text DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resoluciones`
--

CREATE TABLE `resoluciones` (
  `id` int(11) NOT NULL,
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
(4, 128, 4, NULL, NULL, 1.60, '2025-07-02 18:22:06'),
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
(22, 128, 5, NULL, NULL, 1.60, '2025-07-02 18:22:11'),
(23, 129, 5, NULL, NULL, 1.00, '2025-06-15 17:13:11'),
(24, 130, 5, NULL, NULL, 1.60, '2025-06-15 17:13:15'),
(25, 128, 6, NULL, NULL, 1.00, '2025-06-16 15:34:57'),
(26, 128, 7, NULL, NULL, 0.20, '2025-06-18 13:55:44'),
(27, 128, 8, NULL, NULL, 0.00, '2025-06-15 17:39:16'),
(28, 128, 9, NULL, NULL, 0.10, '2025-06-16 16:33:38'),
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
(111, 145, 9, NULL, NULL, 1.00, '2025-06-15 17:19:00'),
(112, 128, 10, NULL, NULL, 1.00, '2025-06-20 07:11:38'),
(113, 129, 10, NULL, NULL, 0.50, '2025-06-19 10:48:07'),
(114, 130, 10, NULL, NULL, 0.20, '2025-07-02 20:00:28'),
(115, 132, 10, NULL, NULL, 1.00, '2025-06-18 14:06:12'),
(116, 134, 10, NULL, NULL, 1.00, '2025-06-18 14:06:13'),
(117, 131, 10, NULL, NULL, 1.00, '2025-06-18 14:06:16'),
(118, 133, 10, NULL, NULL, 1.00, '2025-06-18 14:06:19'),
(119, 135, 10, NULL, NULL, 1.00, '2025-06-18 14:06:21'),
(120, 136, 10, NULL, NULL, 1.00, '2025-06-18 14:06:26'),
(121, 137, 10, NULL, NULL, 1.00, '2025-06-18 14:06:27'),
(122, 138, 10, NULL, NULL, 1.00, '2025-06-18 14:06:29'),
(123, 139, 10, NULL, NULL, 1.00, '2025-06-18 14:06:30'),
(124, 140, 10, NULL, NULL, 1.00, '2025-06-18 14:06:31'),
(125, 141, 10, NULL, NULL, 1.00, '2025-06-18 14:06:33'),
(126, 142, 10, NULL, NULL, 1.00, '2025-06-18 14:06:34'),
(127, 143, 10, NULL, NULL, 1.00, '2025-06-18 14:06:36'),
(128, 144, 10, NULL, NULL, 1.00, '2025-06-18 14:06:39'),
(129, 145, 10, NULL, NULL, 1.00, '2025-06-18 14:06:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resoluciones_banco_preguntas`
--

CREATE TABLE `resoluciones_banco_preguntas` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `ejercicio_id` int(11) DEFAULT NULL,
  `respuesta_texto` text DEFAULT NULL,
  `respuesta_id` int(11) DEFAULT NULL,
  `puntuacion_obtenida` decimal(5,2) DEFAULT 0.00,
  `fecha_respuesta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resoluciones_banco_preguntas`
--

INSERT INTO `resoluciones_banco_preguntas` (`id`, `alumno_id`, `ejercicio_id`, `respuesta_texto`, `respuesta_id`, `puntuacion_obtenida`, `fecha_respuesta`) VALUES
(1, 129, 1, NULL, NULL, 0.30, '2025-06-18 15:28:29'),
(2, 128, 1, NULL, NULL, 1.00, '2025-07-02 16:59:02'),
(3, 128, 2, NULL, NULL, 0.10, '2025-06-18 15:22:49'),
(4, 129, 2, NULL, NULL, 0.30, '2025-06-18 15:22:51'),
(5, 130, 1, NULL, NULL, 0.00, '2025-06-19 16:45:36'),
(6, 130, 2, NULL, NULL, 0.00, '2025-07-02 20:00:27'),
(7, 131, 1, NULL, NULL, 0.60, '2025-06-19 10:48:24'),
(8, 131, 2, NULL, NULL, 0.40, '2025-06-19 10:48:12'),
(9, 132, 2, NULL, NULL, 0.50, '2025-06-19 10:48:14'),
(10, 132, 1, NULL, NULL, 0.70, '2025-06-19 10:48:16'),
(11, 133, 1, NULL, NULL, 0.50, '2025-06-19 10:48:26'),
(12, 141, 1, NULL, NULL, 0.70, '2025-06-19 10:48:29'),
(13, 145, 1, NULL, NULL, 0.50, '2025-06-19 11:03:50'),
(14, 145, 2, NULL, NULL, 0.50, '2025-06-19 11:03:53');

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
-- Estructura de tabla para la tabla `resultados_aprendizaje`
--

CREATE TABLE `resultados_aprendizaje` (
  `id` int(11) NOT NULL,
  `asignatura_id` int(11) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_aprendizaje`
--

INSERT INTO `resultados_aprendizaje` (`id`, `asignatura_id`, `codigo`, `descripcion`) VALUES
(1, 1, 'RA1', 'Reconoce los elementos de las bases de datos analizando sus funciones y valorando la utilidad de los sistemas gestores.'),
(2, 1, 'RA2', 'Crea bases de datos definiendo su estructura y las características de sus elementos según el modelo relacional.'),
(3, 1, 'RA3', 'Consulta la información almacenada en una base de datos empleando asistentes, herramientas gráficas y el lenguaje de manipulación de datos.'),
(4, 1, 'RA4', 'Modifica la información almacenada en la base de datos utilizando asistentes, herramientas gráficas y el lenguaje de manipulación de datos.'),
(5, 1, 'RA5', 'Desarrolla procedimientos almacenados evaluando y utilizando las sentencias del lenguaje incorporado en el sistema gestor de bases de datos.'),
(6, 1, 'RA6', 'Diseña modelos relacionales normalizados interpretando diagramas entidad/relación.'),
(7, 1, 'RA7', 'Gestiona la información almacenada en bases de datos objeto-relacionales, evaluando y utilizando las posibilidades que proporciona el sistema gestor.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_asignadas`
--

CREATE TABLE `tareas_asignadas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `ejercicio_id` bigint(20) DEFAULT NULL,
  `fecha_asignacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_limite_entrega` date DEFAULT NULL,
  `completado` tinyint(1) DEFAULT 0,
  `estado` enum('sin_enviar','enviado','resuelto') DEFAULT 'sin_enviar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tareas_asignadas`
--

INSERT INTO `tareas_asignadas` (`id`, `alumno_id`, `ejercicio_id`, `fecha_asignacion`, `fecha_limite_entrega`, `completado`, `estado`) VALUES
(69, 128, 8, '2025-07-03 15:25:49', '2025-08-07', 0, 'enviado'),
(70, 128, 9, '2025-07-03 15:26:00', '2025-07-31', 0, 'enviado'),
(71, 128, 10, '2025-07-03 15:26:08', '2025-07-24', 0, 'enviado'),
(72, 128, 11, '2025-07-03 15:26:17', '2025-07-17', 0, 'enviado'),
(73, 128, 12, '2025-07-03 15:26:28', '2025-07-10', 0, 'enviado'),
(74, 131, 13, '2025-07-03 18:46:24', '2025-08-07', 0, 'enviado'),
(75, 132, 13, '2025-07-03 18:58:30', '2025-08-10', 0, 'enviado'),
(76, 135, 12, '2025-07-03 19:03:45', '2025-08-04', 0, 'enviado'),
(77, 128, 14, '2025-07-05 10:30:41', NULL, 0, 'enviado'),
(78, 128, 16, '2025-07-05 10:41:13', NULL, 0, 'enviado'),
(79, 128, 18, '2025-07-05 10:47:10', '2025-08-10', 0, 'enviado'),
(80, 130, 23, '2025-07-05 11:38:51', '2025-08-10', 0, 'enviado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

CREATE TABLE `temas` (
  `id` int(11) NOT NULL,
  `asignatura_id` bigint(20) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `temas`
--

INSERT INTO `temas` (`id`, `asignatura_id`, `nombre`) VALUES
(2, 1, 'DML'),
(1, 3, 'XPath'),
(3, 3, 'XQuery');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password_hash` text DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
-- Indices de la tabla `alumnos_empresas`
--
ALTER TABLE `alumnos_empresas`
  ADD PRIMARY KEY (`alumno_id`,`empresa_id`),
  ADD KEY `empresa_id` (`empresa_id`);

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alumno_id` (`alumno_id`,`asignatura_id`,`evaluacion`);

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
-- Indices de la tabla `criterios_evaluacion`
--
ALTER TABLE `criterios_evaluacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resultado_aprendizaje_id` (`resultado_aprendizaje_id`);

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
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
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
-- Indices de la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
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
-- Indices de la tabla `notas_finales_evaluacion`
--
ALTER TABLE `notas_finales_evaluacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alumno_eval_asig` (`alumno_id`,`evaluacion_id`,`asignatura_id`);

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
-- Indices de la tabla `ra_empresa_alumno`
--
ALTER TABLE `ra_empresa_alumno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumno_id` (`alumno_id`),
  ADD KEY `empresa_id` (`empresa_id`),
  ADD KEY `ra_id` (`ra_id`);

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
-- Indices de la tabla `resultados_aprendizaje`
--
ALTER TABLE `resultados_aprendizaje`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
-- AUTO_INCREMENT de la tabla `criterios_evaluacion`
--
ALTER TABLE `criterios_evaluacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT de la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `examenes`
--
ALTER TABLE `examenes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `notas_examen_alumno`
--
ALTER TABLE `notas_examen_alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=356;

--
-- AUTO_INCREMENT de la tabla `notas_finales_evaluacion`
--
ALTER TABLE `notas_finales_evaluacion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `opciones_banco_pregunta`
--
ALTER TABLE `opciones_banco_pregunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `ra_empresa_alumno`
--
ALTER TABLE `ra_empresa_alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT de la tabla `resultados_aprendizaje`
--
ALTER TABLE `resultados_aprendizaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tareas_asignadas`
--
ALTER TABLE `tareas_asignadas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `temas`
--
ALTER TABLE `temas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Filtros para la tabla `alumnos_empresas`
--
ALTER TABLE `alumnos_empresas`
  ADD CONSTRAINT `alumnos_empresas_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alumnos_empresas_ibfk_2` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `criterios_evaluacion`
--
ALTER TABLE `criterios_evaluacion`
  ADD CONSTRAINT `criterios_evaluacion_ibfk_1` FOREIGN KEY (`resultado_aprendizaje_id`) REFERENCES `resultados_aprendizaje` (`id`);

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

--
-- Filtros para la tabla `ra_empresa_alumno`
--
ALTER TABLE `ra_empresa_alumno`
  ADD CONSTRAINT `ra_empresa_alumno_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ra_empresa_alumno_ibfk_2` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ra_empresa_alumno_ibfk_3` FOREIGN KEY (`ra_id`) REFERENCES `resultados_aprendizaje` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
