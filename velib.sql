-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 25 août 2021 à 08:01
-- Version du serveur :  5.7.31
-- Version de PHP : 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `velib`
--
CREATE DATABASE IF NOT EXISTS `velib` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `velib`;

-- --------------------------------------------------------

--
-- Structure de la table `dispo`
--

DROP TABLE IF EXISTS `dispo`;
CREATE TABLE IF NOT EXISTS `dispo` (
  `id_dispo` int(11) NOT NULL AUTO_INCREMENT,
  `codeStation_dispo` int(11) NOT NULL,
  `ouvert_dispo` tinyint(1) NOT NULL COMMENT 'Si la station est ouverte',
  `evelo_dispo` int(11) NOT NULL COMMENT 'nombre de velos électriques',
  `velo_dispo` int(11) NOT NULL COMMENT 'Nombre de vélos mécaniques',
  `total_dispo` int(11) NOT NULL COMMENT 'Total de vélos disponibles',
  `capacite_dispo` int(11) NOT NULL COMMENT 'Capacité d''accueil de la station',
  PRIMARY KEY (`id_dispo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `stations`
--

DROP TABLE IF EXISTS `stations`;
CREATE TABLE IF NOT EXISTS `stations` (
  `id_station` int(11) NOT NULL AUTO_INCREMENT,
  `code_station` int(11) NOT NULL,
  `nom_station` varchar(255) NOT NULL,
  PRIMARY KEY (`id_station`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stations`
--

INSERT INTO `stations` (`id_station`, `code_station`, `nom_station`) VALUES
(1, 17033, 'Carnot - Général Lanrezac'),
(2, 8056, 'Beaujon - Wagram'),
(3, 8057, 'Hoche - Tilsitt'),
(4, 8028, 'Arsène Houssaye - Champs-Elysées'),
(5, 8003, 'Galilée - Vernet'),
(6, 16001, 'Portugais - Kléber'),
(7, 16103, 'Traktir - Foch');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
