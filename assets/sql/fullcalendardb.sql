-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-05-2021 a las 14:21:13
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fullcalendardb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `owner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id`, `title`, `start`, `end`, `owner`) VALUES
(130, 'Evento 1', '2021-05-04 10:00:00', '2021-05-04 12:00:00', 4),
(131, 'Evento 2', '2021-05-05 10:00:00', '2021-05-05 12:00:00', 4),
(132, 'Evento 3', '2021-05-06 10:00:00', '2021-05-06 12:00:00', 4),
(133, 'Nuevo Evento', '2021-05-11 00:00:00', '2021-05-14 23:59:00', 4),
(134, 'Nuevo Evento', '2021-05-18 10:00:00', '2021-05-19 12:00:00', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_users`
--

CREATE TABLE `events_users` (
  `ID` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(25) NOT NULL,
  `PASS` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`ID`, `NAME`, `PASS`) VALUES
(4, 'admin', '$2y$10$27wde1gSOhGFihON5HKNrekzOHTSHuCT5X8PsgDvinn2LK61Kjn8a'),
(5, 'user01', '$2y$10$nGfpG/8RUbXkxJU1CMbnLurzCMpNTTIVMfCYvatfJphyg5jlVqT/.'),
(6, 'user02', '$2y$10$lXacjBtXpQNMtUKiKYyNNO8gHJmXVzb/yF8oZIrtEqCLPPMoVvnYi'),
(7, 'user03', '$2y$10$zAgcBfKnx29fUlyQRhDGt.D7xQsgmw1Wku2iKZDU785cxXWZ/kMOG'),
(8, 'user04', '$2y$10$DQcEbEUs/kXMj8WSGBItxORcEfJXn2FvBbiYZawAfNX8qiIMCZ3Vu'),
(60, 'user07', '$2y$10$HjrcdFZaUSkPJhM41bwwj.I8fcaqfQ4YHrjlsiEtlS0DUmOjasC8W');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EVE_OWN_FK` (`owner`);

--
-- Indices de la tabla `events_users`
--
ALTER TABLE `events_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `EU_EVE_FK` (`event_id`),
  ADD KEY `EU_USE_FK` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `NAME` (`NAME`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT de la tabla `events_users`
--
ALTER TABLE `events_users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=425;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `EVE_OWN_FK` FOREIGN KEY (`owner`) REFERENCES `users` (`ID`);

--
-- Filtros para la tabla `events_users`
--
ALTER TABLE `events_users`
  ADD CONSTRAINT `EU_EVE_FK` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `EU_USE_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
