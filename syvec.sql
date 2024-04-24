-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 24-04-2024 a las 01:25:14
-- Versión del servidor: 11.1.4-MariaDB-log
-- Versión de PHP: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `syvec`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_actividadtipo`
--

CREATE TABLE `tb_actividadtipo` (
  `id_actividadtipo` tinyint(4) NOT NULL,
  `nombre_actividadtipo` varchar(30) NOT NULL,
  `lupdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `tb_actividadtipo`
--

INSERT INTO `tb_actividadtipo` (`id_actividadtipo`, `nombre_actividadtipo`, `lupdate`) VALUES
(1, 'Control', NULL),
(2, 'Vigilancia', NULL),
(3, 'Recuperación', NULL),
(4, 'Cerco', NULL),
(40, 'otro', NULL),
(41, 'nuevo', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_capacidad`
--

CREATE TABLE `tb_capacidad` (
  `id_capacidad` tinyint(4) NOT NULL,
  `nombre_capacidad` varchar(30) NOT NULL,
  `lupdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `tb_capacidad`
--

INSERT INTO `tb_capacidad` (`id_capacidad`, `nombre_capacidad`, `lupdate`) VALUES
(1, 'LLeno', NULL),
(2, 'Vacio', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_control`
--

CREATE TABLE `tb_control` (
  `id_control` int(11) NOT NULL,
  `fecha_control` date NOT NULL,
  `id_eess` smallint(6) NOT NULL,
  `id_sector` smallint(6) NOT NULL,
  `id_actividadtipo` tinyint(4) NOT NULL,
  `id_inspector` tinyint(4) NOT NULL,
  `lupdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_departamento`
--

CREATE TABLE `tb_departamento` (
  `id_departamento` tinyint(4) NOT NULL,
  `id_region` tinyint(4) NOT NULL,
  `nombre_departamento` varchar(100) NOT NULL,
  `lupdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `tb_departamento`
--

INSERT INTO `tb_departamento` (`id_departamento`, `id_region`, `nombre_departamento`, `lupdate`) VALUES
(1, 1, 'ÁNCASH', NULL),
(2, 1, 'ICA', NULL),
(3, 1, 'LA LIBERTAD', NULL),
(4, 1, 'LAMBAYEQUE', NULL),
(5, 1, 'LIMA ', NULL),
(6, 1, 'PIURA', NULL),
(7, 1, 'TUMBES', NULL),
(8, 2, 'AMAZONAS', NULL),
(9, 2, 'APURÍMAC', NULL),
(10, 2, 'AYACUCHO', NULL),
(11, 2, 'CAJAMARCA', NULL),
(12, 2, 'CUSCO', NULL),
(13, 2, 'HUANCAVELICA', NULL),
(14, 2, 'HUÁNUCO', NULL),
(15, 2, 'JUNÍN', NULL),
(16, 2, 'PASCO', NULL),
(17, 2, 'PUNO', NULL),
(18, 3, 'LORETO', NULL),
(19, 3, 'MADRE DE DIOS', NULL),
(20, 3, 'SAN MARTÍN', NULL),
(21, 3, 'UCAYALI', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_depositostipos`
--

CREATE TABLE `tb_depositostipos` (
  `id_deposito_tipo` tinyint(4) NOT NULL,
  `nombre_deposito` varchar(30) NOT NULL,
  `id_capacidad` tinyint(4) NOT NULL,
  `fdelete` enum('1','2') NOT NULL DEFAULT '1',
  `lupdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `tb_depositostipos`
--

INSERT INTO `tb_depositostipos` (`id_deposito_tipo`, `nombre_deposito`, `id_capacidad`, `fdelete`, `lupdate`) VALUES
(1, 'Tanque Elevado', 1, '1', NULL),
(2, 'Tanque Bajo', 1, '1', NULL),
(3, 'Barril', 1, '1', NULL),
(4, 'Sansón-bidón', 1, '1', NULL),
(5, 'Baldes, Bateas, Tinajas', 1, '1', NULL),
(6, 'Llantas', 1, '1', NULL),
(7, 'Floreros, Maceteros', 1, '1', NULL),
(8, 'Latas, Botellas', 1, '2', NULL),
(9, 'Otros', 1, '2', NULL),
(10, 'sdfdsf', 1, '2', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_det_control`
--

CREATE TABLE `tb_det_control` (
  `id_detalle_control` int(11) NOT NULL,
  `codigo_manzana` varchar(20) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `eje_x` varchar(50) DEFAULT NULL,
  `eje_y` varchar(50) DEFAULT NULL,
  `fecha_hora_inicio` datetime NOT NULL,
  `fecha_hora_fin` datetime DEFAULT NULL,
  `nombre_persona_at` varchar(100) NOT NULL,
  `nombre_familia` varchar(100) NOT NULL,
  `cant_residentes` int(11) NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `consumo_larvicida_gr` decimal(5,2) DEFAULT NULL,
  `id_control` int(11) NOT NULL,
  `id_situacion_vivienda` tinyint(4) NOT NULL,
  `id_estado_control` tinyint(4) NOT NULL,
  `lupdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_det_depositos`
--

CREATE TABLE `tb_det_depositos` (
  `id_det_dep` int(11) NOT NULL,
  `id_detalle_control` int(11) NOT NULL,
  `id_depositotipo` tinyint(4) NOT NULL,
  `estado1` varchar(2) DEFAULT NULL,
  `estado2` varchar(2) DEFAULT NULL,
  `estado3` varchar(2) DEFAULT NULL,
  `estado4` varchar(2) DEFAULT NULL,
  `estado5` varchar(2) DEFAULT NULL,
  `lupdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_det_sospechoso`
--

CREATE TABLE `tb_det_sospechoso` (
  `id_sospechoso` smallint(6) NOT NULL,
  `fecha_inicio_sintomas` date NOT NULL,
  `id_detalle_control` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_localidad` smallint(6) NOT NULL,
  `lupdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci COMMENT='id_sector_procedencia  para mapear posteriormente el lugar de origen';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_distrito`
--

CREATE TABLE `tb_distrito` (
  `id_distrito` smallint(6) NOT NULL,
  `nombre_distrito` varchar(100) NOT NULL,
  `id_provincia` tinyint(4) NOT NULL,
  `lupdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `tb_distrito`
--

INSERT INTO `tb_distrito` (`id_distrito`, `nombre_distrito`, `id_provincia`, `lupdate`) VALUES
(1, 'PIURA', 1, NULL),
(2, 'CASTILLA', 1, NULL),
(3, 'CATACAOS', 1, NULL),
(4, 'CURA MORI', 1, NULL),
(5, 'EL TALLAN', 1, NULL),
(6, 'LA ARENA', 1, NULL),
(7, 'LA UNIÓN', 1, NULL),
(8, 'LAS LOMAS', 1, NULL),
(9, 'TAMBO GRANDE', 1, NULL),
(10, 'VEINTISEIS DE OCTUBRE', 1, NULL),
(11, 'SECHURA', 8, NULL),
(12, 'BELLAVISTA DE LA UNION', 8, NULL),
(13, 'BERNAL', 8, NULL),
(14, 'VICE', 8, NULL),
(15, 'RINCONADA DE LICUAR', 8, NULL),
(16, 'CRISTO NOS VALGA', 8, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_eess`
--

CREATE TABLE `tb_eess` (
  `id_eess` smallint(6) NOT NULL,
  `nombre_eess` varchar(100) NOT NULL,
  `id_sector` smallint(6) NOT NULL,
  `lupdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci COMMENT='1 centro de salud esta ubicado en 1 solo sector, existe tabla det_es_sector para asignar varios sectores a 1 centro de salud';

--
-- Volcado de datos para la tabla `tb_eess`
--

INSERT INTO `tb_eess` (`id_eess`, `nombre_eess`, `id_sector`, `lupdate`) VALUES
(1, 'CENTRO ESSALUD 1', 1, NULL),
(2, 'CENTRO ESSALUD 2', 1, NULL),
(3, 'nuevo', 1, NULL),
(4, 'dfgdf', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_estado_control`
--

CREATE TABLE `tb_estado_control` (
  `id_estado_control` tinyint(4) NOT NULL,
  `nombre_estado_control` varchar(30) NOT NULL,
  `lupdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `tb_estado_control`
--

INSERT INTO `tb_estado_control` (`id_estado_control`, `nombre_estado_control`, `lupdate`) VALUES
(1, 'En progreso', NULL),
(2, 'Finalizado', NULL),
(3, 'Otros', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_inspector`
--

CREATE TABLE `tb_inspector` (
  `id_inspector` tinyint(4) NOT NULL,
  `id_persona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_localidad`
--

CREATE TABLE `tb_localidad` (
  `id_localidad` smallint(6) NOT NULL,
  `nombre_localidad` varchar(100) NOT NULL,
  `id_distrito` smallint(6) NOT NULL,
  `lupdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `tb_localidad`
--

INSERT INTO `tb_localidad` (`id_localidad`, `nombre_localidad`, `id_distrito`, `lupdate`) VALUES
(1, 'Localidad 1', 1, NULL),
(2, 'Localidad 2', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_persona`
--

CREATE TABLE `tb_persona` (
  `id_persona` int(11) NOT NULL,
  `dni` char(8) NOT NULL,
  `apellidos_nombres` varchar(120) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `celular1` varchar(9) DEFAULT NULL,
  `celular2` varchar(9) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL,
  `lupdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `tb_persona`
--

INSERT INTO `tb_persona` (`id_persona`, `dni`, `apellidos_nombres`, `fecha_nacimiento`, `celular1`, `celular2`, `email`, `fecha_registro`, `lupdate`) VALUES
(1, '47418803', 'CORDOVA CALLE ALEX', '1999-06-11', '925852365', NULL, 'alex@gmail.com', '2024-04-12 13:28:40', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_provincia`
--

CREATE TABLE `tb_provincia` (
  `id_provincia` tinyint(4) NOT NULL,
  `nombre_provincia` varchar(100) NOT NULL,
  `id_departamento` tinyint(4) NOT NULL,
  `lupdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `tb_provincia`
--

INSERT INTO `tb_provincia` (`id_provincia`, `nombre_provincia`, `id_departamento`, `lupdate`) VALUES
(1, 'PIURA ', 6, NULL),
(2, 'AYABACA ', 6, NULL),
(3, 'HUANCABAMBA ', 6, NULL),
(4, 'MORROPÓN ', 6, NULL),
(5, 'PAITA ', 6, NULL),
(6, 'SULLANA ', 6, NULL),
(7, 'TALARA ', 6, NULL),
(8, 'SECHURA ', 6, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_region`
--

CREATE TABLE `tb_region` (
  `id_region` tinyint(4) NOT NULL,
  `nombre_region` varchar(50) NOT NULL,
  `lupdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `tb_region`
--

INSERT INTO `tb_region` (`id_region`, `nombre_region`, `lupdate`) VALUES
(1, 'COSTA', NULL),
(2, 'SIERRA', NULL),
(3, 'SELVA', NULL),
(4, 'ALTIPLANO', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_sector`
--

CREATE TABLE `tb_sector` (
  `id_sector` smallint(6) NOT NULL,
  `nombre_sector` varchar(100) NOT NULL,
  `referencia_sector` varchar(255) DEFAULT NULL,
  `id_localidad` smallint(6) NOT NULL,
  `id_eess` smallint(6) DEFAULT NULL,
  `lupdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `tb_sector`
--

INSERT INTO `tb_sector` (`id_sector`, `nombre_sector`, `referencia_sector`, `id_localidad`, `id_eess`, `lupdate`) VALUES
(1, 'Sector 1', NULL, 1, NULL, NULL),
(2, 'Sector 2', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_situacion_viv`
--

CREATE TABLE `tb_situacion_viv` (
  `id_situacion_vivienda` tinyint(4) NOT NULL,
  `nombre_situacion_v` varchar(30) NOT NULL,
  `lupdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `tb_situacion_viv`
--

INSERT INTO `tb_situacion_viv` (`id_situacion_vivienda`, `nombre_situacion_v`, `lupdate`) VALUES
(1, 'Cerrada', NULL),
(2, 'Renuente', NULL),
(3, 'Deshabitada', NULL),
(4, 'Otros', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `id_usuario` tinyint(4) NOT NULL,
  `usu_usuario` varchar(50) NOT NULL,
  `usu_contrasena_encrypt` varchar(100) NOT NULL,
  `usu_contrasena_encrypt_mobil` varchar(100) DEFAULT NULL,
  `usu_ultimo_acceso` datetime NOT NULL,
  `usu_estado_habilitado` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1: Habilitado\r\n2: deshabilitado',
  `id_persona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `tb_usuario`
--

INSERT INTO `tb_usuario` (`id_usuario`, `usu_usuario`, `usu_contrasena_encrypt`, `usu_contrasena_encrypt_mobil`, `usu_ultimo_acceso`, `usu_estado_habilitado`, `id_persona`) VALUES
(1, 'alex', '$2y$10$Z6arXESyjEpI6itBkrDRcOxn5CzOYcCN364vGEQoDFt.jw15Igb5e', NULL, '2024-04-12 17:27:01', '1', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_actividadtipo`
--
ALTER TABLE `tb_actividadtipo`
  ADD PRIMARY KEY (`id_actividadtipo`);

--
-- Indices de la tabla `tb_capacidad`
--
ALTER TABLE `tb_capacidad`
  ADD PRIMARY KEY (`id_capacidad`),
  ADD UNIQUE KEY `nombre_capacidad_unique` (`nombre_capacidad`);

--
-- Indices de la tabla `tb_control`
--
ALTER TABLE `tb_control`
  ADD PRIMARY KEY (`id_control`),
  ADD KEY `fk_tb_control_tb_sector_1` (`id_sector`),
  ADD KEY `fk_tb_control_tb_eess_1` (`id_eess`),
  ADD KEY `fk_tb_control_tb_actividadtipo_1` (`id_actividadtipo`),
  ADD KEY `tb_control_fk1` (`id_inspector`);

--
-- Indices de la tabla `tb_departamento`
--
ALTER TABLE `tb_departamento`
  ADD PRIMARY KEY (`id_departamento`),
  ADD KEY `tb_departamento_fk1` (`id_region`);

--
-- Indices de la tabla `tb_depositostipos`
--
ALTER TABLE `tb_depositostipos`
  ADD PRIMARY KEY (`id_deposito_tipo`),
  ADD KEY `fk_tb_depositostipos_tb_capacidad_1` (`id_capacidad`);

--
-- Indices de la tabla `tb_det_control`
--
ALTER TABLE `tb_det_control`
  ADD PRIMARY KEY (`id_detalle_control`),
  ADD KEY `fk_tb_det_control_tb_control_1` (`id_control`),
  ADD KEY `fk_tb_det_control_tb_situacion_viv_1` (`id_situacion_vivienda`),
  ADD KEY `fk_tb_det_control_tb_estado_control_1` (`id_estado_control`);

--
-- Indices de la tabla `tb_det_depositos`
--
ALTER TABLE `tb_det_depositos`
  ADD PRIMARY KEY (`id_det_dep`),
  ADD KEY `fk_tb_det_depositos_tb_det_control_1` (`id_detalle_control`),
  ADD KEY `fk_tb_det_depositos_tb_depositostipos_1` (`id_depositotipo`);

--
-- Indices de la tabla `tb_det_sospechoso`
--
ALTER TABLE `tb_det_sospechoso`
  ADD PRIMARY KEY (`id_sospechoso`),
  ADD KEY `tb_det_sospechoso_fk1` (`id_localidad`),
  ADD KEY `tb_det_sospechoso_fk2` (`id_persona`),
  ADD KEY `tb_det_sospechoso_fk3` (`id_detalle_control`);

--
-- Indices de la tabla `tb_distrito`
--
ALTER TABLE `tb_distrito`
  ADD PRIMARY KEY (`id_distrito`),
  ADD KEY `fk_tb_distrito_tb_provincia_1` (`id_provincia`);

--
-- Indices de la tabla `tb_eess`
--
ALTER TABLE `tb_eess`
  ADD PRIMARY KEY (`id_eess`),
  ADD KEY `tb_eess_fk1` (`id_sector`);

--
-- Indices de la tabla `tb_estado_control`
--
ALTER TABLE `tb_estado_control`
  ADD PRIMARY KEY (`id_estado_control`),
  ADD UNIQUE KEY `nombre_estado_control_unique` (`nombre_estado_control`);

--
-- Indices de la tabla `tb_inspector`
--
ALTER TABLE `tb_inspector`
  ADD PRIMARY KEY (`id_inspector`),
  ADD KEY `tb_supervisor_fk1` (`id_persona`);

--
-- Indices de la tabla `tb_localidad`
--
ALTER TABLE `tb_localidad`
  ADD PRIMARY KEY (`id_localidad`),
  ADD KEY `fk_tb_localidad_tb_distrito_1` (`id_distrito`);

--
-- Indices de la tabla `tb_persona`
--
ALTER TABLE `tb_persona`
  ADD PRIMARY KEY (`id_persona`);

--
-- Indices de la tabla `tb_provincia`
--
ALTER TABLE `tb_provincia`
  ADD PRIMARY KEY (`id_provincia`),
  ADD KEY `fk_tb_provincia_tb_departamento_1` (`id_departamento`);

--
-- Indices de la tabla `tb_region`
--
ALTER TABLE `tb_region`
  ADD PRIMARY KEY (`id_region`);

--
-- Indices de la tabla `tb_sector`
--
ALTER TABLE `tb_sector`
  ADD PRIMARY KEY (`id_sector`),
  ADD KEY `fk_tb_sector_tb_localidad_1` (`id_localidad`),
  ADD KEY `tb_sector_fk1` (`id_eess`);

--
-- Indices de la tabla `tb_situacion_viv`
--
ALTER TABLE `tb_situacion_viv`
  ADD PRIMARY KEY (`id_situacion_vivienda`),
  ADD UNIQUE KEY `nombre_situacion_unique` (`nombre_situacion_v`);

--
-- Indices de la tabla `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `dt_usuario_fk1` (`id_persona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_actividadtipo`
--
ALTER TABLE `tb_actividadtipo`
  MODIFY `id_actividadtipo` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `tb_capacidad`
--
ALTER TABLE `tb_capacidad`
  MODIFY `id_capacidad` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_control`
--
ALTER TABLE `tb_control`
  MODIFY `id_control` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_departamento`
--
ALTER TABLE `tb_departamento`
  MODIFY `id_departamento` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tb_depositostipos`
--
ALTER TABLE `tb_depositostipos`
  MODIFY `id_deposito_tipo` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tb_det_depositos`
--
ALTER TABLE `tb_det_depositos`
  MODIFY `id_det_dep` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_det_sospechoso`
--
ALTER TABLE `tb_det_sospechoso`
  MODIFY `id_sospechoso` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_distrito`
--
ALTER TABLE `tb_distrito`
  MODIFY `id_distrito` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tb_eess`
--
ALTER TABLE `tb_eess`
  MODIFY `id_eess` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tb_estado_control`
--
ALTER TABLE `tb_estado_control`
  MODIFY `id_estado_control` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_inspector`
--
ALTER TABLE `tb_inspector`
  MODIFY `id_inspector` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_localidad`
--
ALTER TABLE `tb_localidad`
  MODIFY `id_localidad` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_persona`
--
ALTER TABLE `tb_persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_provincia`
--
ALTER TABLE `tb_provincia`
  MODIFY `id_provincia` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tb_region`
--
ALTER TABLE `tb_region`
  MODIFY `id_region` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tb_sector`
--
ALTER TABLE `tb_sector`
  MODIFY `id_sector` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_situacion_viv`
--
ALTER TABLE `tb_situacion_viv`
  MODIFY `id_situacion_vivienda` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `id_usuario` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tb_control`
--
ALTER TABLE `tb_control`
  ADD CONSTRAINT `tb_control_fk1` FOREIGN KEY (`id_inspector`) REFERENCES `tb_inspector` (`id_inspector`),
  ADD CONSTRAINT `tb_control_fk2` FOREIGN KEY (`id_sector`) REFERENCES `tb_sector` (`id_sector`),
  ADD CONSTRAINT `tb_control_fk3` FOREIGN KEY (`id_eess`) REFERENCES `tb_eess` (`id_eess`),
  ADD CONSTRAINT `tb_control_fk4` FOREIGN KEY (`id_actividadtipo`) REFERENCES `tb_actividadtipo` (`id_actividadtipo`);

--
-- Filtros para la tabla `tb_departamento`
--
ALTER TABLE `tb_departamento`
  ADD CONSTRAINT `tb_departamento_fk1` FOREIGN KEY (`id_region`) REFERENCES `tb_region` (`id_region`);

--
-- Filtros para la tabla `tb_depositostipos`
--
ALTER TABLE `tb_depositostipos`
  ADD CONSTRAINT `tb_depositostipos_fk1` FOREIGN KEY (`id_capacidad`) REFERENCES `tb_capacidad` (`id_capacidad`);

--
-- Filtros para la tabla `tb_det_control`
--
ALTER TABLE `tb_det_control`
  ADD CONSTRAINT `fk_tb_det_control_tb_control_1` FOREIGN KEY (`id_control`) REFERENCES `tb_control` (`id_control`),
  ADD CONSTRAINT `tb_det_control_fk1` FOREIGN KEY (`id_estado_control`) REFERENCES `tb_estado_control` (`id_estado_control`),
  ADD CONSTRAINT `tb_det_control_fk2` FOREIGN KEY (`id_situacion_vivienda`) REFERENCES `tb_situacion_viv` (`id_situacion_vivienda`);

--
-- Filtros para la tabla `tb_det_depositos`
--
ALTER TABLE `tb_det_depositos`
  ADD CONSTRAINT `fk_tb_det_depositos_tb_det_control_1` FOREIGN KEY (`id_detalle_control`) REFERENCES `tb_det_control` (`id_detalle_control`),
  ADD CONSTRAINT `tb_det_depositos_fk1` FOREIGN KEY (`id_depositotipo`) REFERENCES `tb_depositostipos` (`id_deposito_tipo`);

--
-- Filtros para la tabla `tb_det_sospechoso`
--
ALTER TABLE `tb_det_sospechoso`
  ADD CONSTRAINT `tb_det_sospechoso_fk1` FOREIGN KEY (`id_localidad`) REFERENCES `tb_localidad` (`id_localidad`),
  ADD CONSTRAINT `tb_det_sospechoso_fk2` FOREIGN KEY (`id_persona`) REFERENCES `tb_persona` (`id_persona`),
  ADD CONSTRAINT `tb_det_sospechoso_fk3` FOREIGN KEY (`id_detalle_control`) REFERENCES `tb_det_control` (`id_detalle_control`);

--
-- Filtros para la tabla `tb_distrito`
--
ALTER TABLE `tb_distrito`
  ADD CONSTRAINT `tb_distrito_fk1` FOREIGN KEY (`id_provincia`) REFERENCES `tb_provincia` (`id_provincia`);

--
-- Filtros para la tabla `tb_eess`
--
ALTER TABLE `tb_eess`
  ADD CONSTRAINT `tb_eess_fk1` FOREIGN KEY (`id_sector`) REFERENCES `tb_sector` (`id_sector`);

--
-- Filtros para la tabla `tb_inspector`
--
ALTER TABLE `tb_inspector`
  ADD CONSTRAINT `tb_inspector_fk1` FOREIGN KEY (`id_persona`) REFERENCES `tb_persona` (`id_persona`);

--
-- Filtros para la tabla `tb_localidad`
--
ALTER TABLE `tb_localidad`
  ADD CONSTRAINT `tb_localidad_fk1` FOREIGN KEY (`id_distrito`) REFERENCES `tb_distrito` (`id_distrito`);

--
-- Filtros para la tabla `tb_provincia`
--
ALTER TABLE `tb_provincia`
  ADD CONSTRAINT `tb_provincia_fk1` FOREIGN KEY (`id_departamento`) REFERENCES `tb_departamento` (`id_departamento`);

--
-- Filtros para la tabla `tb_sector`
--
ALTER TABLE `tb_sector`
  ADD CONSTRAINT `tb_sector_fk1` FOREIGN KEY (`id_localidad`) REFERENCES `tb_localidad` (`id_localidad`),
  ADD CONSTRAINT `tb_sector_fk2` FOREIGN KEY (`id_eess`) REFERENCES `tb_eess` (`id_eess`);

--
-- Filtros para la tabla `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD CONSTRAINT `dt_usuario_fk1` FOREIGN KEY (`id_persona`) REFERENCES `tb_persona` (`id_persona`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
