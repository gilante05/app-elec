-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 30 mars 2025 à 22:25
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_jirama`
--
--CREATE DATABASE `gestion_jirama`;
--USE `gestion_jirama`;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `CodeCli` varchar(10) NOT NULL,
  `Nom` varchar(15) NOT NULL,
  `Prenom` varchar(15) DEFAULT NULL,
  `Sexe` enum('MASCULIN','FEMININ') DEFAULT NULL,
  `Quartier` varchar(15) NOT NULL,
  `Niveau` enum('VIP','FIDELE','REGULIER','NOUVEAU') DEFAULT NULL,
  `Mail` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`CodeCli`, `Nom`, `Prenom`, `Sexe`, `Quartier`, `Niveau`, `Mail`) VALUES
('3278', 'OIJZOGIHOQEZ', 'ihza', 'MASCULIN', 'OIJOIZEJ09', 'VIP', 'OIRZH98ZPRP@gmail.co'),
('98217981', 'RABARISON', 'VONU TIZN', 'FEMININ', 'IUZHGAU8RFGBIU', 'FIDELE', 'NRZALUGFIA@gmail.com'),
('C00002', 'David', 'Deacon', 'MASCULIN', 'Tanambao', 'FIDELE', 'daviddeacon@example.'),
('C00003', 'Sam', 'White', 'MASCULIN', 'Tanambao', 'FIDELE', 'samwhite@example.com'),
('C00004', 'Colin', 'Chaplin', 'MASCULIN', 'Isada', 'NOUVEAU', 'colinchaplin@example'),
('C00005', 'Ricky', 'Waltz', 'MASCULIN', 'Tanambao', 'VIP', 'rickywaltz@example.c'),
('C00006', 'Arnold', 'Hall', 'MASCULIN', 'Isada', 'NOUVEAU', 'arnoldhall@example.c'),
('C00007', 'Toni', 'Adams', 'MASCULIN', 'Isada', 'FIDELE', 'alvah1981@example.co'),
('C00008', 'Donald', 'Perry', 'MASCULIN', 'Isada', 'VIP', 'donald1983@example.c'),
('C00009', 'Joe', 'McKinney', 'MASCULIN', 'Tanambao', 'NOUVEAU', 'nadia.doole0@example'),
('C00010', 'Angela', 'Horst', 'FEMININ', 'Tanambao', 'FIDELE', 'angela1977@example.c'),
('C00011', 'James', 'Jameson', 'MASCULIN', 'Ampitakely', 'VIP', 'james1965@example.co'),
('C00012', 'Daniel', 'Deacon', 'MASCULIN', 'Tanambao', 'FIDELE', 'danieldeacon@example');

-- --------------------------------------------------------

--
-- Structure de la table `compteur`
--

CREATE TABLE `compteur` (
  `CodeCompteur` varchar(10) NOT NULL,
  `CodeCli` varchar(10) NOT NULL,
  `TypeCompteur` enum('ELECTRICITE','EAU') NOT NULL,
  `Pu` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `compteur`
--

INSERT INTO `compteur` (`CodeCompteur`, `CodeCli`, `TypeCompteur`, `Pu`) VALUES
('4', '98217981', 'EAU', 100),
('5385', 'C00003', 'ELECTRICITE', 1002),
('765546584H', '3278', 'EAU', 16),
('7655476597', '98217981', 'ELECTRICITE', 43),
('d', 'C00010', 'ELECTRICITE', 365),
('kjbmiuv', 'C00008', 'ELECTRICITE', 1111);

-- --------------------------------------------------------

--
-- Structure de la table `payer`
--

CREATE TABLE `payer` (
  `Idpaye` varchar(10) NOT NULL,
  `CodeCli` varchar(10) NOT NULL,
  `Date_paiement` date NOT NULL DEFAULT current_timestamp(),
  `Montant` int(7) NOT NULL,
  `Etat` int(1) DEFAULT 0,
  `CodeReleve` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `payer`
--

INSERT INTO `payer` (`Idpaye`, `CodeCli`, `Date_paiement`, `Montant`, `Etat`, `CodeReleve`) VALUES
('7665293688', '98217981', '2025-03-30', 55814, 0, '9817091'),
('7665298390', '98217981', '2025-03-30', 5633, 0, '9821793'),
('981985', '98217981', '2025-03-30', 3400, 0, '981981'),
('9836', '98217981', '2025-03-30', 2000, 0, '9832°94');

-- --------------------------------------------------------

--
-- Structure de la table `releve`
--

CREATE TABLE `releve` (
  `CodeReleve` varchar(10) NOT NULL,
  `CodeCompteur` varchar(10) NOT NULL,
  `Valeur` int(3) NOT NULL,
  `Date_releve` date NOT NULL,
  `Date_presentation` date DEFAULT NULL,
  `Date_limite_paiement` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `releve`
--

INSERT INTO `releve` (`CodeReleve`, `CodeCompteur`, `Valeur`, `Date_releve`, `Date_presentation`, `Date_limite_paiement`) VALUES
('9817091', '7655476597', 987, '2025-03-15', '2025-04-02', '2025-04-03'),
('981981', '4', 34, '2025-03-06', '2025-03-13', '2025-03-30'),
('9821793', '7655476597', 131, '2023-10-22', '2023-12-17', '2023-06-18'),
('9832°94', '4', 20, '0000-00-00', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'guillaume', 'rvonytianaguillaume@gmail.com', 'guillaume06', NULL),
(2, 'guyzaho', 'guyzaho@gmail.com', 'guyzaho05', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`CodeCli`);

--
-- Index pour la table `compteur`
--
ALTER TABLE `compteur`
  ADD PRIMARY KEY (`CodeCompteur`),
  ADD KEY `CodeCli` (`CodeCli`);

--
-- Index pour la table `payer`
--
ALTER TABLE `payer`
  ADD PRIMARY KEY (`Idpaye`),
  ADD KEY `CodeCli` (`CodeCli`),
  ADD KEY `payer` (`CodeReleve`);

--
-- Index pour la table `releve`
--
ALTER TABLE `releve`
  ADD PRIMARY KEY (`CodeReleve`),
  ADD KEY `CodeCompteur` (`CodeCompteur`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `compteur`
--
ALTER TABLE `compteur`
  ADD CONSTRAINT `compteur_ibfk_1` FOREIGN KEY (`CodeCli`) REFERENCES `client` (`CodeCli`) ON DELETE CASCADE;

--
-- Contraintes pour la table `payer`
--
ALTER TABLE `payer`
  ADD CONSTRAINT `payer` FOREIGN KEY (`CodeReleve`) REFERENCES `releve` (`CodeReleve`) ON DELETE CASCADE,
  ADD CONSTRAINT `payer_ibfk_1` FOREIGN KEY (`CodeCli`) REFERENCES `client` (`CodeCli`) ON DELETE CASCADE;

--
-- Contraintes pour la table `releve`
--
ALTER TABLE `releve`
  ADD CONSTRAINT `releve_ibfk_1` FOREIGN KEY (`CodeCompteur`) REFERENCES `compteur` (`CodeCompteur`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
