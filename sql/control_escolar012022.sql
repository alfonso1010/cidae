-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-01-2022 a las 15:27:47
-- Versión del servidor: 10.3.25-MariaDB-0ubuntu0.20.04.1
-- Versión de PHP: 7.2.34-13+ubuntu20.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `control_escolar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id_alumno` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `apellido_paterno` varchar(60) NOT NULL,
  `apellido_materno` varchar(45) NOT NULL,
  `direccion` text NOT NULL,
  `telefono_casa` varchar(45) DEFAULT NULL,
  `telefono_celular` varchar(45) NOT NULL,
  `sexo` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `matricula` varchar(200) NOT NULL,
  `edad` int(11) DEFAULT NULL,
  `fecha_nacimiento` varchar(45) DEFAULT NULL,
  `fecha_alta` datetime NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 0,
  `id_grupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id_alumno`, `nombre`, `apellido_paterno`, `apellido_materno`, `direccion`, `telefono_casa`, `telefono_celular`, `sexo`, `email`, `matricula`, `edad`, `fecha_nacimiento`, `fecha_alta`, `activo`, `id_grupo`) VALUES
(1, 'Alfonso', 'Arellanes', 'Mendoza', 'callesita 23', '5525636952', '55374896549', 'M', 'alfonso@gmail.com', '15122', 25, '1996-10-10', '2021-12-15 23:01:54', 0, 1),
(2, 'Alfonso', 'Arellanes', 'Mendoza', 'callesita 23', '5525636952', '55374896549', 'M', 'alfonso@gmail.com', '15122', 25, '1996-10-10', '2021-12-15 23:01:54', 0, 1),
(3, 'Juan', 'Guzman', 'Mendoza', 'callesita 23', '5525636952', '55374896549', 'M', 'alfonso@gmail.com', '15122', 25, '1996-10-10', '2021-12-15 23:01:54', 0, 1),
(4, 'Pedro', 'Perez', 'Mendoza', 'callesita 23', '5525636952', '55374896549', 'M', 'alfonso@gmail.com', '15122', 25, '1996-10-10', '2021-12-15 23:01:54', 0, 1),
(5, 'Jimena', 'Gonzalez', 'Mendoza', 'callesita 23', '5525636952', '55374896549', 'M', 'alfonso@gmail.com', '15122', 25, '1996-10-10', '2021-12-15 23:01:54', 0, 1),
(6, 'Diana', 'Jimenez', 'Mendoza', 'callesita 23', '5525636952', '55374896549', 'M', 'alfonso@gmail.com', '15122', 25, '1996-10-10', '2021-12-15 23:01:54', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_alumno`
--

CREATE TABLE `asistencia_alumno` (
  `id_asistencia_alumno` int(11) NOT NULL,
  `asistio` int(11) NOT NULL,
  `fecha_asistencia` date NOT NULL,
  `hora_asistencia` time NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_profesor` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `semestre` int(11) NOT NULL,
  `nombre_materia` varchar(255) NOT NULL,
  `nombre_profesor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asistencia_alumno`
--

INSERT INTO `asistencia_alumno` (`id_asistencia_alumno`, `asistio`, `fecha_asistencia`, `hora_asistencia`, `fecha_alta`, `id_alumno`, `id_materia`, `id_profesor`, `id_grupo`, `semestre`, `nombre_materia`, `nombre_profesor`) VALUES
(7, 1, '2022-01-10', '19:51:59', '2022-01-11 19:51:59', 1, 3, 1, 1, 1, 'Derecho 1', 'Juan Perez Gonzalez'),
(8, 1, '2022-01-10', '19:51:59', '2022-01-11 19:51:59', 2, 3, 1, 1, 1, 'Derecho 1', 'Juan Perez Gonzalez'),
(9, 1, '2022-01-10', '19:51:59', '2022-01-11 19:51:59', 3, 3, 1, 1, 1, 'Derecho 1', 'Juan Perez Gonzalez'),
(10, 1, '2022-01-10', '19:51:59', '2022-01-11 19:51:59', 4, 3, 1, 1, 1, 'Derecho 1', 'Juan Perez Gonzalez'),
(11, 1, '2022-01-10', '19:51:59', '2022-01-11 19:51:59', 5, 3, 1, 1, 1, 'Derecho 1', 'Juan Perez Gonzalez'),
(12, 0, '2022-01-10', '19:51:59', '2022-01-11 19:51:59', 6, 3, 1, 1, 1, 'Derecho 1', 'Juan Perez Gonzalez'),
(13, 0, '2022-01-11', '20:01:03', '2022-01-11 20:01:03', 1, 3, 1, 1, 1, 'Derecho 1', 'Juan Perez Gonzalez'),
(14, 1, '2022-01-11', '20:01:03', '2022-01-11 20:01:03', 2, 3, 1, 1, 1, 'Derecho 1', 'Juan Perez Gonzalez'),
(15, 1, '2022-01-11', '20:01:03', '2022-01-11 20:01:03', 3, 3, 1, 1, 1, 'Derecho 1', 'Juan Perez Gonzalez'),
(16, 1, '2022-01-11', '20:01:03', '2022-01-11 20:01:03', 4, 3, 1, 1, 1, 'Derecho 1', 'Juan Perez Gonzalez'),
(17, 1, '2022-01-11', '20:01:03', '2022-01-11 20:01:03', 5, 3, 1, 1, 1, 'Derecho 1', 'Juan Perez Gonzalez'),
(18, 1, '2022-01-11', '20:01:03', '2022-01-11 20:01:03', 6, 3, 1, 1, 1, 'Derecho 1', 'Juan Perez Gonzalez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', NULL),
('alumno', '3', NULL),
('profesor', '2', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('/alumnos/*', 2, NULL, NULL, NULL, NULL, NULL),
('/carreras/*', 2, NULL, NULL, NULL, NULL, NULL),
('/grupos/*', 2, NULL, NULL, NULL, NULL, NULL),
('/horarios/*', 2, NULL, NULL, NULL, NULL, NULL),
('/inicio/index', 2, NULL, NULL, NULL, NULL, NULL),
('/materias/*', 2, NULL, NULL, NULL, NULL, NULL),
('/profesor/*', 2, NULL, NULL, NULL, NULL, NULL),
('/profesor/buscasemestre', 2, NULL, NULL, NULL, NULL, NULL),
('/profesor/cargahorario', 2, NULL, NULL, NULL, NULL, NULL),
('/profesor/principal', 2, NULL, NULL, NULL, NULL, NULL),
('/profesores/*', 2, NULL, NULL, NULL, NULL, NULL),
('admin', 1, 'rol de admin', NULL, NULL, NULL, NULL),
('alumno', 1, 'rol de alumno', NULL, NULL, NULL, NULL),
('profesor', 1, 'rol de profesor', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', '/alumnos/*'),
('admin', '/carreras/*'),
('admin', '/grupos/*'),
('admin', '/horarios/*'),
('admin', '/inicio/index'),
('admin', '/materias/*'),
('admin', '/profesor/*'),
('profesor', '/profesores/*');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion_alumno`
--

CREATE TABLE `calificacion_alumno` (
  `id_calificacion_alumno` int(11) NOT NULL,
  `no_periodo` int(11) NOT NULL,
  `calificacion` float NOT NULL,
  `no_evaluacion` int(11) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_profesor` int(11) NOT NULL,
  `nombre_materia` varchar(255) NOT NULL,
  `nombre_profesor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id_carrera` int(11) NOT NULL,
  `tipo_carrera` int(11) NOT NULL DEFAULT 0,
  `nombre` varchar(255) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `rvoe` varchar(255) DEFAULT NULL,
  `total_periodos` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id_carrera`, `tipo_carrera`, `nombre`, `clave`, `rvoe`, `total_periodos`, `fecha_alta`, `activo`) VALUES
(1, 0, 'Licenciatura en Derecho', '1', 'RVOE2021', 6, '2021-12-01 10:06:45', 0),
(2, 0, 'Licenciatura en Criminologia', '012', 'RVOE2021121', 8, '2021-12-03 19:46:28', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id_grupo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `generacion` varchar(255) NOT NULL,
  `modalidad` varchar(255) NOT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `id_carrera` int(11) NOT NULL,
  `no_evaluaciones_periodo` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id_grupo`, `nombre`, `generacion`, `modalidad`, `capacidad`, `id_carrera`, `no_evaluaciones_periodo`, `fecha_alta`, `activo`) VALUES
(1, 'Grupo 100', '2022', 'Escolarizado', 50, 1, 2, '2021-12-15 20:37:28', 0),
(2, 'Grupo 200', '2022', '', 30, 2, 3, '2021-12-03 19:48:30', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios_profesor_materia`
--

CREATE TABLE `horarios_profesor_materia` (
  `id` int(11) NOT NULL,
  `dia_semana` varchar(45) NOT NULL,
  `hora_inicio` varchar(45) NOT NULL,
  `hora_fin` varchar(45) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_profesor` int(11) NOT NULL,
  `nombre_materia` varchar(255) NOT NULL,
  `nombre_profesor` varchar(255) NOT NULL,
  `semestre` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `horarios_profesor_materia`
--

INSERT INTO `horarios_profesor_materia` (`id`, `dia_semana`, `hora_inicio`, `hora_fin`, `id_materia`, `id_profesor`, `nombre_materia`, `nombre_profesor`, `semestre`, `id_grupo`) VALUES
(65, '1', '8', '9', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(66, '1', '9', '10', 5, 1, 'civica', 'Juan Perez Gonzalez', 1, 1),
(67, '1', '10', '11', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(68, '1', '11', '12', 5, 1, 'civica', 'Juan Perez Gonzalez', 1, 1),
(69, '1', '12', '13', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(70, '1', '13', '14', 5, 1, 'civica', 'Juan Perez Gonzalez', 1, 1),
(71, '1', '14', '15', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(72, '2', '8', '9', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(73, '2', '9', '10', 5, 1, 'civica', 'Juan Perez Gonzalez', 1, 1),
(74, '2', '10', '11', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(75, '2', '11', '12', 5, 1, 'civica', 'Juan Perez Gonzalez', 1, 1),
(76, '2', '12', '13', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(77, '2', '13', '14', 5, 1, 'civica', 'Juan Perez Gonzalez', 1, 1),
(78, '2', '14', '15', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(79, '3', '8', '9', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(80, '3', '9', '10', 5, 1, 'civica', 'Juan Perez Gonzalez', 1, 1),
(81, '3', '10', '11', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(82, '3', '11', '12', 5, 1, 'civica', 'Juan Perez Gonzalez', 1, 1),
(83, '3', '12', '13', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(84, '3', '13', '14', 5, 1, 'civica', 'Juan Perez Gonzalez', 1, 1),
(85, '3', '14', '15', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(86, '4', '8', '9', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(87, '4', '9', '10', 5, 1, 'civica', 'Juan Perez Gonzalez', 1, 1),
(88, '4', '10', '11', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(89, '4', '11', '12', 5, 1, 'civica', 'Juan Perez Gonzalez', 1, 1),
(90, '4', '12', '13', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(91, '4', '13', '14', 5, 1, 'civica', 'Juan Perez Gonzalez', 1, 1),
(92, '4', '14', '15', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(93, '5', '8', '9', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(94, '5', '9', '10', 5, 1, 'civica', 'Juan Perez Gonzalez', 1, 1),
(95, '5', '10', '11', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(96, '5', '11', '12', 5, 1, 'civica', 'Juan Perez Gonzalez', 1, 1),
(97, '5', '12', '13', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(98, '5', '13', '14', 5, 1, 'civica', 'Juan Perez Gonzalez', 1, 1),
(99, '5', '14', '15', 3, 1, 'Derecho 1', 'Juan Perez Gonzalez', 1, 1),
(102, '6', '8', '9', 4, 1, 'Materia ejemplo', 'Juan Perez Gonzalez', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id_materia` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `total_creditos` varchar(45) DEFAULT NULL,
  `periodo` int(11) NOT NULL,
  `mes_periodo` varchar(100) NOT NULL,
  `id_carrera` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_materia`, `nombre`, `clave`, `total_creditos`, `periodo`, `mes_periodo`, `id_carrera`, `fecha_alta`, `activo`) VALUES
(3, 'Derecho 1', '12', '100', 1, '1', 1, '2021-12-11 21:40:48', 0),
(4, 'Materia ejemplo', '01', '100', 1, '1,2', 2, '2021-12-15 20:29:05', 0),
(5, 'civica', '1212', '100', 2, '1,2', 1, '2021-12-21 21:28:32', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `name`, `parent`, `route`, `order`, `data`) VALUES
(1, '<i class=\"fa fa-home\"></i><span style=\"font-size:16px;\"> Inicio </span>', NULL, NULL, 1, NULL),
(2, '<i class=\"fa fa-book\"></i><span style=\"font-size:16px;\"> Carreras </span>', NULL, '/carreras/index', 2, NULL),
(3, '<i class=\"fa fa-group\"></i><span style=\"font-size:16px;\"> Grupos </span>', NULL, '/grupos/index', 4, NULL),
(4, '<i class=\"fa fa-book\"></i><span style=\"font-size:16px;\"> Materias </span>', NULL, '/materias/index', 3, NULL),
(5, '<i class=\"fa fa-group\"></i><span style=\"font-size:16px;\"> Alumnos </span>', NULL, '/alumnos/index', 5, NULL),
(6, '<i class=\"fa fa-group\"></i><span style=\"font-size:16px;\"> Docentes </span>', NULL, '/profesor/index', 6, NULL),
(7, '<i class=\"fa fa-clock-o\"></i><span style=\"font-size:16px;\"> Horarios </span>', NULL, '/horarios/index', 8, NULL),
(8, '<i class=\"fa fa-book\"></i><span style=\"font-size:16px;\"> Materias - Docente </span>', NULL, '/profesor/materias', 7, NULL),
(10, '<i class=\"fa fa-clock-o\"></i><span style=\"font-size:16px;\"> Horario </span>', NULL, '/profesores/principal', 9, NULL),
(11, '<i class=\"fa fa-group\"></i><span style=\"font-size:16px;\"> Grupos </span>', NULL, '/profesores/grupos', 10, NULL),
(12, '<i class=\"fa fa-group\"></i><span style=\"font-size:16px;\"> Tomar Asistencia </span>', NULL, '/profesores/asistencia', 11, NULL),
(13, '<i class=\"fa fa-book\"></i><span style=\"font-size:16px;\"> Calificaciones </span>', NULL, '/profesores/calificaciones', 13, NULL),
(14, '<i class=\"fa fa-group\"></i><span style=\"font-size:16px;\"> Registro de Asistencias </span>', NULL, '/profesores/reporteasisitencia', 12, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1635011161),
('m130524_201442_init', 1635011165),
('m140501_075311_oauth_clients', 1635011205),
('m140501_075312_oauth_access_tokens', 1635011205),
('m140501_075313_oauth_refresh_tokens', 1635011205),
('m140501_075314_oauth_authorization_codes', 1635011205),
('m140501_075315_oauth_scopes', 1635011205),
('m140501_075316_oauth_public_keys', 1635011205),
('m140506_102106_rbac_init', 1635011248),
('m140602_111327_create_menu_table', 1635100827),
('m160312_050000_create_user', 1635100827),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1635011248),
('m180523_151638_rbac_updates_indexes_without_prefix', 1635011248),
('m190124_110200_add_verification_token_column_to_user_table', 1635011165),
('m200409_110543_rbac_update_mssql_trigger', 1635011248);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `access_token` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expires` datetime NOT NULL,
  `scope` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_authorization_codes`
--

CREATE TABLE `oauth_authorization_codes` (
  `authorization_code` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `redirect_uri` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `expires` datetime NOT NULL,
  `scope` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `client_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `client_secret` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uri` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `grant_types` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `scope` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_public_keys`
--

CREATE TABLE `oauth_public_keys` (
  `client_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `public_key` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `private_key` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `encription_algorithm` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'RS256'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `refresh_token` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expires` datetime NOT NULL,
  `scope` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_scopes`
--

CREATE TABLE `oauth_scopes` (
  `scope` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `is_default` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `id_profesor` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido_paterno` varchar(45) NOT NULL,
  `apellido_materno` varchar(45) NOT NULL,
  `cedula` varchar(100) NOT NULL,
  `direccion` text DEFAULT NULL,
  `telefono_celular` varchar(45) NOT NULL,
  `telefono_casa` varchar(45) DEFAULT NULL,
  `sexo` varchar(10) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fecha_alta` datetime NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 0,
  `edad` int(11) DEFAULT NULL,
  `fecha_nacimiento` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`id_profesor`, `nombre`, `apellido_paterno`, `apellido_materno`, `cedula`, `direccion`, `telefono_celular`, `telefono_casa`, `sexo`, `email`, `fecha_alta`, `activo`, `edad`, `fecha_nacimiento`) VALUES
(1, 'Juan', 'Perez', 'Gonzalez', '0152255', 'callesita 23', '5587412563', '5589636963', 'M', 'juan@gmail.com', '2021-12-15 23:08:34', 0, 35, '1986-02-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_materia`
--

CREATE TABLE `profesor_materia` (
  `id_profesor_materia` int(11) NOT NULL,
  `id_profesor` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `profesor_materia`
--

INSERT INTO `profesor_materia` (`id_profesor_materia`, `id_profesor`, `id_materia`, `fecha_alta`, `activo`) VALUES
(11, 1, 3, '2022-01-06 16:15:25', 0),
(12, 1, 5, '2022-01-06 16:15:25', 0),
(13, 1, 4, '2022-01-06 16:15:25', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_responsable` int(11) DEFAULT NULL,
  `tipo_responsable` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`, `id_responsable`, `tipo_responsable`) VALUES
(1, 'admin', 'pO5r-tSzQfeFK1gRVrGJbWWB7aNOvUYd', '$2y$13$nYnIcXCTX2hm9rk3KTrGd.lRPn.7F3HHShMLzgZGsI088SC2JaVOe', NULL, 'admin@gmail.com', 10, 1635011391, 1635011391, 'duwYwb-cKSMoNqT7ZFhiB7Yv8EAEeg0O_1635011391', 0, 0),
(2, 'profesor', 'pO5r-tSzQfeFK1gRVrGJbWWB7aNOvUYd', '$2y$13$nYnIcXCTX2hm9rk3KTrGd.lRPn.7F3HHShMLzgZGsI088SC2JaVOe', NULL, 'profesor@gmail.com', 10, 1635011391, 1635011391, 'duwYwb-cKSMoNqT7ZFhiB7Yv8EAEeg0O_1635011391', 1, 1),
(3, 'alumno', 'pO5r-tSzQfeFK1gRVrGJbWWB7aNOvUYd', '$2y$13$nYnIcXCTX2hm9rk3KTrGd.lRPn.7F3HHShMLzgZGsI088SC2JaVOe', NULL, 'alumno@gmail.com', 10, 1635011391, 1635011391, 'duwYwb-cKSMoNqT7ZFhiB7Yv8EAEeg0O_1635011391', 1, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id_alumno`),
  ADD KEY `fk_alumnos_grupos1_idx` (`id_grupo`);

--
-- Indices de la tabla `asistencia_alumno`
--
ALTER TABLE `asistencia_alumno`
  ADD PRIMARY KEY (`id_asistencia_alumno`),
  ADD KEY `fk_asistencia_alumno_alumnos1_idx` (`id_alumno`);

--
-- Indices de la tabla `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Indices de la tabla `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indices de la tabla `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indices de la tabla `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indices de la tabla `calificacion_alumno`
--
ALTER TABLE `calificacion_alumno`
  ADD PRIMARY KEY (`id_calificacion_alumno`),
  ADD KEY `fk_calificacion_alumno_alumnos1_idx` (`id_alumno`);

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id_carrera`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id_grupo`),
  ADD KEY `fk_grupos_carreras_idx` (`id_carrera`);

--
-- Indices de la tabla `horarios_profesor_materia`
--
ALTER TABLE `horarios_profesor_materia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_horarios_profesor_materia_grupos1_idx` (`id_grupo`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id_materia`,`id_carrera`),
  ADD KEY `fk_materias_carreras1_idx` (`id_carrera`),
  ADD KEY `id_carrera` (`id_carrera`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent`);

--
-- Indices de la tabla `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`access_token`),
  ADD KEY `idx-oauth_access_tokens-client_id` (`client_id`);

--
-- Indices de la tabla `oauth_authorization_codes`
--
ALTER TABLE `oauth_authorization_codes`
  ADD PRIMARY KEY (`authorization_code`),
  ADD KEY `idx-oauth_authorization_codes-client_id` (`client_id`);

--
-- Indices de la tabla `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indices de la tabla `oauth_public_keys`
--
ALTER TABLE `oauth_public_keys`
  ADD PRIMARY KEY (`client_id`,`public_key`),
  ADD KEY `idx-oauth_public_keys-client_id` (`client_id`);

--
-- Indices de la tabla `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`refresh_token`),
  ADD KEY `idx-oauth_refresh_tokens-client_id` (`client_id`);

--
-- Indices de la tabla `oauth_scopes`
--
ALTER TABLE `oauth_scopes`
  ADD PRIMARY KEY (`scope`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`id_profesor`);

--
-- Indices de la tabla `profesor_materia`
--
ALTER TABLE `profesor_materia`
  ADD PRIMARY KEY (`id_profesor_materia`,`id_profesor`,`id_materia`),
  ADD KEY `fk_profesor_has_materias_materias1_idx` (`id_materia`),
  ADD KEY `fk_profesor_has_materias_profesor1_idx` (`id_profesor`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `asistencia_alumno`
--
ALTER TABLE `asistencia_alumno`
  MODIFY `id_asistencia_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `calificacion_alumno`
--
ALTER TABLE `calificacion_alumno`
  MODIFY `id_calificacion_alumno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id_carrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `horarios_profesor_materia`
--
ALTER TABLE `horarios_profesor_materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `profesor`
--
ALTER TABLE `profesor`
  MODIFY `id_profesor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `profesor_materia`
--
ALTER TABLE `profesor_materia`
  MODIFY `id_profesor_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `fk_alumnos_grupos1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `asistencia_alumno`
--
ALTER TABLE `asistencia_alumno`
  ADD CONSTRAINT `fk_asistencia_alumno_alumnos1` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `calificacion_alumno`
--
ALTER TABLE `calificacion_alumno`
  ADD CONSTRAINT `fk_calificacion_alumno_alumnos1` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `fk_grupos_carreras` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id_carrera`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `horarios_profesor_materia`
--
ALTER TABLE `horarios_profesor_materia`
  ADD CONSTRAINT `fk_horarios_profesor_materia_grupos1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `fk_carrera_materia` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id_carrera`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD CONSTRAINT `fk-oauth_access_tokens-client_id` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `oauth_authorization_codes`
--
ALTER TABLE `oauth_authorization_codes`
  ADD CONSTRAINT `fk-oauth_authorization_codes-client_id` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `oauth_public_keys`
--
ALTER TABLE `oauth_public_keys`
  ADD CONSTRAINT `fk-oauth_public_keys-client_id` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD CONSTRAINT `fk-oauth_refresh_tokens-client_id` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profesor_materia`
--
ALTER TABLE `profesor_materia`
  ADD CONSTRAINT `fk_profesor_has_materias_materias1` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_profesor_has_materias_profesor1` FOREIGN KEY (`id_profesor`) REFERENCES `profesor` (`id_profesor`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
