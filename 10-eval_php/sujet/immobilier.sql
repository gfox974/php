SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

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


ALTER TABLE `logement`
  ADD PRIMARY KEY (`id_logement`);

ALTER TABLE `logement`
  MODIFY `id_logement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT