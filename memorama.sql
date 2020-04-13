-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-05-2016 a las 00:29:00
-- Versión del servidor: 5.6.25
-- Versión de PHP: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `memorama`
--
CREATE DATABASE IF NOT EXISTS `memorama` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `memorama`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE IF NOT EXISTS `materias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `materias`
--

LOCK TABLES `materias` WRITE;
/*!40000 ALTER TABLE `materias` DISABLE KEYS */;
INSERT INTO `materias` VALUES (1,'filosofia cuantica'),(2,'Semat');
/*!40000 ALTER TABLE `materias` ENABLE KEYS */;
UNLOCK TABLES;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parejas`
--

CREATE TABLE IF NOT EXISTS `parejas` (
  `id` int(11) NOT NULL,
  `idmateria` int(11) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parejas`
--

LOCK TABLES `parejas` WRITE;
/*!40000 ALTER TABLE `parejas` DISABLE KEYS */;
INSERT INTO `parejas` VALUES (1,1,'concepto1','descripcion1'),(2,1,'concepto2','descripcion2'),(3,1,'pesiria','cantollanes'),(4,1,'concepto1','descripcion1'),(5,1,'concepto2','descripcion2'),(6,1,'pesiria','cantollanes'),(7,1,'concepto1','descripcion1'),(8,1,'concepto2','descripcion2'),(9,1,'pesiria','cantollanes'),(10,2,'Semat','Software Engineering Method and Theory.'),(11,2,'Alphas','Representations of the essential things to work with.'),(12,2,'Activity Spaces','Representations of the essential things to do.'),(13,2,'Customer','Area of concern the team needs to understand the stakeholders and the opportunity to be addressed'),(14,2,'Solution','Area of concern the team needs to establish a share understanding of the requirements, and implement, build, test, deploy and support a software system.'),(15,2,'Endeavor','Area of concern the team and its way-of-working have to be formed, and the work has to be done.'),(16,2,'Opportunity','The set of circumstances that makes it appropriate to develop or change a software system.'),(17,2,'Stakeholders','The people, groups, or organizations who affect or are affected by a software system.'),(18,2,'Requirements','What the software system must do to address the opportunity and satisfy the stakeholders.'),(19,2,'Software System','A system made up of software, hardware, and data that provides its primary value by the execution of the software.'),(20,2,'Work','Activity involving mental or physical effort done in order to achieve a result.'),(21,2,'Team','The group of people actively engaged in the development, maintenance, delivery and support of a specific software system.'),(22,2,'Way of work','The tailored set of practices and tools used by a team to guide and support their work.'),(23,2,'Stakeholder Representation','This competency encapsulates the ability to gather, communicate, and balance the needs of other stakeholders, and accurately represent their views.'),(24,2,'Analysis','This competency encapsulates the ability to understand opportunities and their related stakeholder needs, and transform them into an agreed upon and consistent set of  requirements.'),(25,2,'Development','This competency encapsulates the ability to design and program effective software systems following the standards and norms agreed upon by the team.'),(26,2,'Testing','This competency encapsulates the ability to test a system, verifying that it is usable and that it meets the requirements.'),(27,2,'Leadership','This competency enable a person to inspire and motivate a group of people to achieve a successful conclusion to their work and to meet their objectives.'),(28,2,'Management','This competency encapsulates the ability to coordinate, plan, and track the work done by a team.');
/*!40000 ALTER TABLE `parejas` ENABLE KEYS */;
UNLOCK TABLES;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntajes`
--

CREATE TABLE IF NOT EXISTS `puntajes` (
  `id_usuario` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `dificultad` varchar(7) NOT NULL,
  `puntaje` bigint(20) NOT NULL,
  `parejas_encontradas` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL DEFAULT 'usuario',
  `tipo` int(1) NOT NULL DEFAULT '0',
  `clave` varchar(100) NOT NULL DEFAULT 'memopass'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'pepe',0,'camello');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `parejas`
--
ALTER TABLE `parejas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idmateria_idx` (`idmateria`);

--
-- Indices de la tabla `puntajes`
--
ALTER TABLE `puntajes`
  ADD PRIMARY KEY (`id_materia`,`fecha`,`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `parejas`
--
ALTER TABLE `parejas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `parejas`
--
ALTER TABLE `parejas`
  ADD CONSTRAINT `idmateria` FOREIGN KEY (`idmateria`) REFERENCES `materias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
