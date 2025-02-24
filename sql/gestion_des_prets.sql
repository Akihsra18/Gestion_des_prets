-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 16 Octobre 2024 à 16:39
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gestion_des_prets`
--

-- --------------------------------------------------------

--
-- Structure de la table `emprunts`
--

CREATE TABLE `emprunts` (
  `id_emprunt` int(11) NOT NULL AUTO_INCREMENT,
  `id_usager` int(11) NOT NULL,
  `id_periodique` int(11) NOT NULL,
  PRIMARY KEY (`id_emprunt`),
  FOREIGN KEY (`id_usager`) REFERENCES `usagers` (`id_usager`),
  FOREIGN KEY (`id_periodique`) REFERENCES `periodiques` (`id_periodique`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `emprunts`
--

INSERT INTO `emprunts` (`id_emprunt`, `id_usager`, `id_periodique`) VALUES
(1, 6, 1),
(2, 6, 3),
(3, 6, 5),
(4, 7, 2);

-- --------------------------------------------------------

--
-- Structure de la table `periodiques`
--

CREATE TABLE `periodiques` (
  `id_periodique` int(6) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `annee` int(11) NOT NULL,
  `mois` varchar(255) NOT NULL,
  `numero` int(11) NOT NULL,
  `url` varchar(1028) NOT NULL,
  PRIMARY KEY (`id_periodique`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `periodiques`
--

INSERT INTO `periodiques` (`id_periodique`, `nom`, `titre`, `annee`, `mois`, `numero`, `url`) VALUES
(1, 'The MagPi', 'Essential Electronics', 2024, 'August', 144, 'https://magazines-assets.raspberrypi.com/storage/representations/proxy/eyJfcmFpbHMiOnsiZGF0YSI6OTUwOSwicHVyIjoiYmxvYl9pZCJ9fQ==--586a26640c8a4135c3ba17b7728e8fc138d86c6a/eyJfcmFpbHMiOnsiZGF0YSI6eyJmb3JtYXQiOiJqcGciLCJyZXNpemVfdG9fZml0IjpbNTAwLG51bGxdfSwicHVyIjoidmFyaWF0aW9uIn19--0746f39dc02728e06a69580ce8b044931fd99fad/_MagPi%20_144%20Front%20flat%20cover_Grey%20BG.jpg'),
(2, 'The MagPi', 'Robot Explorers!', 2024, 'July', 143, 'https://magazines-assets.raspberrypi.com/storage/representations/proxy/eyJfcmFpbHMiOnsiZGF0YSI6OTM5NiwicHVyIjoiYmxvYl9pZCJ9fQ==--f3381e8d94e06f83978e17c120e95f9131a07a6a/eyJfcmFpbHMiOnsiZGF0YSI6eyJmb3JtYXQiOiJqcGciLCJyZXNpemVfdG9fZml0IjpbNTAwLG51bGxdfSwicHVyIjoidmFyaWF0aW9uIn19--0746f39dc02728e06a69580ce8b044931fd99fad/_MagPi%20_143%20Front%20flat%20cover.jpg'),
(3, 'The MagPi', 'Troubleshooting Guide', 2024, 'March', 139, 'https://magazines-assets.raspberrypi.com/storage/representations/proxy/eyJfcmFpbHMiOnsiZGF0YSI6OTE0MSwicHVyIjoiYmxvYl9pZCJ9fQ==--4192799b2c8f031d0d18190498ad2135cfc29695/eyJfcmFpbHMiOnsiZGF0YSI6eyJmb3JtYXQiOiJqcGciLCJyZXNpemVfdG9fZml0IjpbNTAwLG51bGxdfSwicHVyIjoidmFyaWF0aW9uIn19--0746f39dc02728e06a69580ce8b044931fd99fad/_MagPi%20%23139%20-%20210x276.jpg'),
(4, 'The MagPi', 'Python robots', 2023, 'July', 131, 'https://magazines-assets.raspberrypi.com/storage/representations/proxy/eyJfcmFpbHMiOnsiZGF0YSI6ODQ5NCwicHVyIjoiYmxvYl9pZCJ9fQ==--feac546197ece2a49b799133d19bdb8059ae54a4/eyJfcmFpbHMiOnsiZGF0YSI6eyJmb3JtYXQiOiJqcGciLCJyZXNpemVfdG9fZml0IjpbNTAwLG51bGxdfSwicHVyIjoidmFyaWF0aW9uIn19--0746f39dc02728e06a69580ce8b044931fd99fad/MagPi131_Magazine%20210x276%20Mockups.jpg'),
(5, 'The MagPi', 'Practical Programming', 2022, 'February', 114, 'https://magazines-assets.raspberrypi.com/storage/representations/proxy/eyJfcmFpbHMiOnsiZGF0YSI6NjI1OCwicHVyIjoiYmxvYl9pZCJ9fQ==--f2f7c680f099f45bdf4cdf91ad8669edd574b7a7/eyJfcmFpbHMiOnsiZGF0YSI6eyJmb3JtYXQiOiJqcGciLCJyZXNpemVfdG9fZml0IjpbNTAwLG51bGxdfSwicHVyIjoidmFyaWF0aW9uIn19--0746f39dc02728e06a69580ce8b044931fd99fad/001_MagPi114_COVER-MOCKUP.jpg'),
(6, 'The MagPi', '3D Printing & Making', 2020, 'September', 97, 'https://magazines-assets.raspberrypi.com/storage/representations/proxy/eyJfcmFpbHMiOnsiZGF0YSI6MTI3OSwicHVyIjoiYmxvYl9pZCJ9fQ==--132aee1cf4a140c0b8d284cd35ec2741439d83af/eyJfcmFpbHMiOnsiZGF0YSI6eyJmb3JtYXQiOiJqcGciLCJyZXNpemVfdG9fZml0IjpbNTAwLG51bGxdfSwicHVyIjoidmFyaWF0aW9uIn19--0746f39dc02728e06a69580ce8b044931fd99fad/MagPi97_COVER-MOCKUP.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `usagers`
--

CREATE TABLE `usagers` (
  `id_usager` int(10) NOT NULL AUTO_INCREMENT,
  `matricule` int(7) NOT NULL UNIQUE,
  `mot_de_passe` varchar(1024) NOT NULL,
  `adresse_courriel` varchar(255) NOT NULL UNIQUE,
  `position` varchar(255) NOT NULL,
  PRIMARY KEY (`id_usager`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `usagers`
--

INSERT INTO `usagers` (`id_usager`, `matricule`, `mot_de_passe`, `adresse_courriel`, `position`) VALUES
(1, 98765, '19865795547116ae27f09115e72c74d2c517d0b2', '98765@cegeptr.qc.ca', 'Professeur'),
(2, 87654, '5c69461e26c45dbaff2cc4e5cc766144bbcc017b', '87654@cegeptr.qc.ca', 'Professeur'),
(3, 76543, '27022dcd7577a93bf1a67d8a66a19918f32fbf66', '76543@cegeptr.qc.ca', 'Professeur'),
(4, 65432, '5a23ba37412bdc27a9a40eec1ea6597d659329cc', '65432@cegeptr.qc.ca', 'Professeur'),
(5, 54321, '348162101fc6f7e624681b7400b085eeac6df7bd', '54321@cegeptr.qc.ca', 'Professeur'),
(6, 1234567, '20eabe5d64b0e216796e834f52d61fd0b70332fc', '1234567@cegeptr.qc.ca', 'Etudiant'),
(7, 2345678, '1f03a0a8c9498844274f4d789a310b415060c1d0', '2345678@cegeptr.qc.ca', 'Etudiant'),
(8, 3456789, 'fd1518f063f1067313eb950f97c3553c1987c123', '3456789@cegeptr.qc.ca', 'Etudiant'),
(9, 4567890, '94038465034c7fcea862797087a6a90ee557ff2a', '4567890@cegeptr.qc.ca', 'Etudiant'),
(10, 5678901, '84dae7d90f71f2f3769318d984880bb4c7afc1b4', '5678901@cegeptr.qc.ca', 'Etudiant');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
