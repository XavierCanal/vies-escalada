-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Temps de generació: 09-01-2023 a les 12:27:26
-- Versió del servidor: 8.0.31-0ubuntu0.22.04.1
-- Versió de PHP: 8.1.2-1ubuntu2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `eleccions`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `candidatures`
--

CREATE TABLE `participant` (
                                `nom` varchar(20) NOT NULL,
                                `cognom` varchar(200) NOT NULL,
                                `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Estructura de la taula `comarques`
--

CREATE TABLE `assoliment` (
    `participant` varchar(200) NOT NULL,
    `via` varchar(200) NOT NULL,
    `intent` int NOT NULL,
    `data` date NOT NULL,
    `encadenat` boolean NOT NULL,
    `primer` boolean NOT NULL,
    `assegurador` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `via` (
  `nom` varchar(200) NOT NULL,
  `sector` varchar(200) NOT NULL,
  `grau` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bolcament de dades per a la taula `demarcacions`
--

CREATE TABLE `sector` (
    `nom` varchar(200) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



ALTER TABLE `assoliment`
  ADD UNIQUE KEY `id` (`participant`,`via`, `intent`),
  ADD KEY `participant` (`participant`),
    ADD KEY `via` (`via`),
    ADD KEY `intent` (`intent`);

--
-- Índexs per a la taula `comarques`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`email`);

--
-- Índexs per a la taula `demarcacions`
--
ALTER TABLE `via`
  ADD PRIMARY KEY (`nom`);

ALTER TABLE `sector`
  ADD PRIMARY KEY (`nom`);

ALTER TABLE `assoliment`
    ADD CONSTRAINT `assoliment_ibfk_1` FOREIGN KEY (`participant`) REFERENCES `participant` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `assoliment_ibfk_2` FOREIGN KEY (`via`) REFERENCES `via` (`nom`) ON DELETE CASCADE ON UPDATE CASCADE;--

-- Restriccions per a la taula `candidatures`
--
ALTER TABLE `via`
    ADD CONSTRAINT `via_ibfk_1` FOREIGN KEY (`sector`) REFERENCES `sector` (`nom`) ON DELETE CASCADE ON UPDATE CASCADE;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
