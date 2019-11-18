-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 18 nov. 2019 à 13:01
-- Version du serveur :  10.4.8-MariaDB
-- Version de PHP :  7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `immobilier`
--

-- --------------------------------------------------------

--
-- Structure de la table `logement`
--

CREATE TABLE `logement` (
  `id_logement` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `cp` varchar(5) NOT NULL,
  `surface` varchar(4) NOT NULL,
  `prix` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `type` enum('location','vente') NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `logement`
--

INSERT INTO `logement` (`id_logement`, `titre`, `adresse`, `ville`, `cp`, `surface`, `prix`, `photo`, `type`, `description`) VALUES
(51, 'Magnifique caverne', 'quelque part dans le tarn', 'Ambares', '33440', '800', '10', 'photos/logement_51.jpeg', 'location', 'Voisinage calme, a part quelques animaux'),
(52, 'Box', 'Partout', 'Paris', '75000', '1', '1500', 'photos/logement_52.jpeg', 'vente', 'Vends carton spacieux sur paris, tres bon état'),
(53, 'Appartement', 'rio', 'rio', '12354', '20', '350', 'photos/logement_53.jpeg', 'location', 'Superbe studio dans les favelas, quartier animé'),
(54, 'Emplacement', 'Dehors', 'Trappes', '78370', '2000', '1', '', 'location', 'Loue superbe place de parking, proche toutes commodités');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `logement`
--
ALTER TABLE `logement`
  ADD PRIMARY KEY (`id_logement`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `logement`
--
ALTER TABLE `logement`
  MODIFY `id_logement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
