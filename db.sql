-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 11-07-2016 a las 20:28:21
-- Versión del servidor: 5.1.73
-- Versión de PHP: 5.4.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `faucet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admonfaucet`
--

CREATE TABLE IF NOT EXISTS `admonfaucet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api` varchar(40) NOT NULL,
  `balance` int(11) NOT NULL,
  `refbalance` int(11) NOT NULL,
  `timeClaims` int(11) NOT NULL,
  `rkp` varchar(40) NOT NULL,
  `rsk` varchar(40) NOT NULL,
  `valido` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajustes`
--

CREATE TABLE IF NOT EXISTS `ajustes` (
  `nombre` varchar(50) NOT NULL,
  `valor` text NOT NULL,
  PRIMARY KEY (`nombre`)
);

--
-- Volcado de datos para la tabla `ajustes`
--

INSERT INTO `ajustes` (`nombre`, `valor`) VALUES
('titulo', 'FAUCET TITLE'),
('subtitulo', 'BITCOIN NEWS'),
('botoncobro', 'CLAIM'),
('footerT', 'FAUCET + DICE'),
('footerC', 'YOUR CONTENT<br>\r\nYOUR CONTENT<br>\r\nYOUR CONTENT<br>'),
('c_Header', 'blue darken-1 white-text'),
('c_Subheader', 'blue lighten-1 black-text'),
('c_Footer', 'blue accent-1 black-text'),
('c_Text', 'black-text'),
('c_btnd1', 'purple darken-1'),
('c_btn1', 'blue darken-3 white-text'),
('c_btn2', 'blue accent-4 white-text'),
('c_btncobro', 'pink darken-1 white-text'),
('c_Panel', 'blue darken-1 white-text'),
('c_btnd2', 'indigo darken-1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE IF NOT EXISTS `articulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `contenido` mediumtext NOT NULL,
  `img` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faucetbox`
--

CREATE TABLE IF NOT EXISTS `faucetbox` (
  `count` int(60) NOT NULL AUTO_INCREMENT,
  `addy` varchar(100) NOT NULL,
  `time` int(50) NOT NULL,
  `bbb` int(12) NOT NULL,
  `ipp` varchar(100) NOT NULL,
  `reefer` varchar(100) NOT NULL,
  PRIMARY KEY (`count`),
  UNIQUE KEY `addy` (`addy`,`ipp`)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faucetboxgames`
--

CREATE TABLE IF NOT EXISTS `faucetboxgames` (
  `gid` varchar(60) NOT NULL,
  `addy` varchar(100) NOT NULL,
  `count` int(30) NOT NULL AUTO_INCREMENT,
  `salt` varchar(100) NOT NULL,
  `roll` decimal(5,2) NOT NULL,
  `bet` int(4) NOT NULL,
  `ltgt` int(1) NOT NULL,
  `uuu` decimal(5,2) NOT NULL,
  `profit` int(6) NOT NULL,
  `open` int(1) NOT NULL,
  `batb` int(20) NOT NULL,
  PRIMARY KEY (`count`),
  UNIQUE KEY `gid` (`gid`)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(100) NOT NULL,
  `clave` varchar(35) NOT NULL,
  `hash` varchar(40) NOT NULL,
  `refer` varchar(40) NOT NULL,
  `valido` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

