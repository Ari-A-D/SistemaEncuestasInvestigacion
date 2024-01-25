CREATE DATABASE  IF NOT EXISTS `fundacionobservarencuestas` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci */;
USE `fundacionobservarencuestas`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: fundacionobservarencuestas
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `encuesta`
--

DROP TABLE IF EXISTS `encuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `encuesta` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` varchar(400) DEFAULT NULL,
  `Objetivo` varchar(400) DEFAULT NULL,
  `CantidadPreguntas` int(11) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Id_usuario` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Id_usuario` (`Id_usuario`),
  CONSTRAINT `encuesta_ibfk_1` FOREIGN KEY (`Id_usuario`) REFERENCES `usuarios` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `encuestadores`
--

DROP TABLE IF EXISTS `encuestadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `encuestadores` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellido` varchar(100) DEFAULT NULL,
  `Edad` int(11) DEFAULT NULL,
  `DNI` varchar(8) NOT NULL,
  `NumTramiteDNI` varchar(11) DEFAULT NULL,
  `Id_Encuesta` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Id_Encuesta` (`Id_Encuesta`),
  CONSTRAINT `encuestadores_ibfk_1` FOREIGN KEY (`Id_Encuesta`) REFERENCES `encuesta` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `encuestados`
--

DROP TABLE IF EXISTS `encuestados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `encuestados` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellido` varchar(100) DEFAULT NULL,
  `Edad` int(11) DEFAULT NULL,
  `DNI` varchar(8) NOT NULL,
  `NumTramiteDNI` varchar(11) DEFAULT NULL,
  `Id_Encuestador` int(10) DEFAULT NULL,
  `Id_Encuesta` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Id_Encuestador` (`Id_Encuestador`),
  KEY `Id_Encuesta` (`Id_Encuesta`),
  CONSTRAINT `encuestados_ibfk_2` FOREIGN KEY (`Id_Encuesta`) REFERENCES `encuesta` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `encuestados_respuestas`
--

DROP TABLE IF EXISTS `encuestados_respuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `encuestados_respuestas` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Fecha` date DEFAULT NULL,
  `Id_Encuestado` int(10) unsigned NOT NULL,
  `Id_Respuesta` int(10) unsigned NOT NULL,
  `Detalle` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Id_Encuestado` (`Id_Encuestado`),
  KEY `Id_Respuesta` (`Id_Respuesta`),
  CONSTRAINT `encuestados_respuestas_ibfk_1` FOREIGN KEY (`Id_Encuestado`) REFERENCES `encuestados` (`ID`) ON UPDATE CASCADE,
  CONSTRAINT `encuestados_respuestas_ibfk_2` FOREIGN KEY (`Id_Respuesta`) REFERENCES `respuestas` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=702 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `georreferenciacion`
--

DROP TABLE IF EXISTS `georreferenciacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `georreferenciacion` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Longitud` decimal(8,6) DEFAULT NULL,
  `Latitud` decimal(8,6) DEFAULT NULL,
  `Id_Encuestado` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Id_Encuestado` (`Id_Encuestado`),
  CONSTRAINT `georreferenciacion_ibfk_1` FOREIGN KEY (`Id_Encuestado`) REFERENCES `encuestados` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `preguntas`
--

DROP TABLE IF EXISTS `preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preguntas` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Detalle` varchar(400) NOT NULL,
  `CantidadOpciones` int(11) DEFAULT NULL,
  `Id_Encuesta` int(10) unsigned NOT NULL,
  `Id_tipo_pregunta` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Id_Encuesta` (`Id_Encuesta`),
  KEY `Id_tipo_pregunta` (`Id_tipo_pregunta`),
  CONSTRAINT `preguntas_ibfk_1` FOREIGN KEY (`Id_Encuesta`) REFERENCES `encuesta` (`ID`) ON UPDATE CASCADE,
  CONSTRAINT `preguntas_ibfk_2` FOREIGN KEY (`Id_tipo_pregunta`) REFERENCES `preguntas` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `respuestas`
--

DROP TABLE IF EXISTS `respuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `respuestas` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Detalle` varchar(100) NOT NULL,
  `Valor` int(11) DEFAULT NULL,
  `Id_Pregunta` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Id_Pregunta` (`Id_Pregunta`),
  CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`Id_Pregunta`) REFERENCES `preguntas` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipos_preguntas`
--

DROP TABLE IF EXISTS `tipos_preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipos_preguntas` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dni` int(11) NOT NULL,
  `Contrasenia` varchar(100) NOT NULL,
  `NombreUsuario` varchar(50) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `codigo_activacion` varchar(45) DEFAULT NULL,
  `activado` int(11) DEFAULT 0,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'fundacionobservarencuestas'
--

--
-- Dumping routines for database 'fundacionobservarencuestas'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-19 16:10:58
