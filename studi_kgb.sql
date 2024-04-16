-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : mar. 16 avr. 2024 à 12:36
-- Version du serveur : 11.2.2-MariaDB
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `studi_kgb`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id_admin` char(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `email` (`email`) USING HASH
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id_admin`, `email`, `password`, `created_at`) VALUES
('ef6cec36-e2b3-11ee-a93d-f854f615a071', 'john.doe@test.com', '$2y$10$GoSqjBnaNfqnobFVN/iBiOPuxhXVcJHEtPnJzSv2Ohi0mUFOfoBjK', '2024-03-15'),
('04.07.2024.11.15.54person6612806ac2e', 'charly.scott@test.com', '$2y$10$2zifiM29eqvs05kLd/L6G.eFoJSNgaQNM3BnwzqOZ/ZLTqRjl4HCa', '2024-04-07'),
('04.16.2024.12.10.27person661e6ab30d8', 'bob.synclair@test.com', '$2y$10$aanT9Xz8yObdVgku5s.4XeWduQ.1zAed73qyUDoKnZ0KXVRA.EzK.', '2024-04-16');

-- --------------------------------------------------------

--
-- Structure de la table `agents`
--

DROP TABLE IF EXISTS `agents`;
CREATE TABLE IF NOT EXISTS `agents` (
  `id_agent` char(36) NOT NULL,
  `identify_code` varchar(60) NOT NULL,
  `id_mission` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_agent`),
  KEY `id_mission` (`id_mission`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `agents`
--

INSERT INTO `agents` (`id_agent`, `identify_code`, `id_mission`) VALUES
('0d552303-e2b4-11ee-a93d-f854f615a071', 'JB-007', 3),
('04.15.2024.07.54.49person661cdd499a5', 'aS-04.15.2024.07.54.49', 5),
('04.07.2024.10.39.45person661277f1a45', 'SC-04.07.2024.10.39.45', 1),
('04.15.2024.02.53.49person661d3f7d1bc', 'aI-04.15.2024.02.53.49', 4),
('04.15.2024.02.25.50person661d38ee1d7', 'aI-04.15.2024.02.25.50', 6),
('04.15.2024.02.26.20person661d390c7a9', 'aT-04.15.2024.02.26.20', NULL),
('04.15.2024.02.26.43person661d39237ff', 'ap-04.15.2024.02.26.43', 3),
('04.15.2024.04.56.25person661d5c39001', 'as-04.15.2024.04.56.25', 2);

-- --------------------------------------------------------

--
-- Structure de la table `agents_specialities`
--

DROP TABLE IF EXISTS `agents_specialities`;
CREATE TABLE IF NOT EXISTS `agents_specialities` (
  `id_agent` char(36) NOT NULL,
  `id_speciality` int(11) NOT NULL,
  PRIMARY KEY (`id_agent`,`id_speciality`),
  KEY `id_speciality` (`id_speciality`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `agents_specialities`
--

INSERT INTO `agents_specialities` (`id_agent`, `id_speciality`) VALUES
('04.07.2024.10.39.45person661277f1a45', 2),
('04.07.2024.10.39.45person661277f1a45', 7),
('04.07.2024.10.39.45person661277f1a45', 8),
('04.07.2024.10.45.50person6612795e68d', 2),
('04.11.2024.05.48.20person66182264d47', 10),
('04.11.2024.05.53.10person66182386456', 7),
('04.11.2024.05.58.29person661824c5842', 9),
('04.15.2024.02.25.50person661d38ee1d7', 7),
('04.15.2024.02.25.50person661d38ee1d7', 9),
('04.15.2024.02.26.20person661d390c7a9', 2),
('04.15.2024.02.26.20person661d390c7a9', 9),
('04.15.2024.02.26.43person661d39237ff', 7),
('04.15.2024.02.26.43person661d39237ff', 8),
('04.15.2024.02.53.49person661d3f7d1bc', 2),
('04.15.2024.02.53.49person661d3f7d1bc', 8),
('04.15.2024.02.53.49person661d3f7d1bc', 9),
('04.15.2024.02.53.49person661d3f7d1bc', 10),
('04.15.2024.04.56.25person661d5c39001', 2),
('04.15.2024.04.56.25person661d5c39001', 10),
('04.15.2024.07.54.49person661cdd499a5', 8),
('04.15.2024.07.54.49person661cdd499a5', 9),
('04.15.2024.07.54.49person661cdd499a5', 10),
('0d552303-e2b4-11ee-a93d-f854f615a071', 2),
('0d552303-e2b4-11ee-a93d-f854f615a071', 9),
('0d552303-e2b4-11ee-a93d-f854f615a071', 10);

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id_contact` char(36) NOT NULL,
  `code_name` varchar(60) NOT NULL,
  `id_mission` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_contact`),
  KEY `id_mission` (`id_mission`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id_contact`, `code_name`, `id_mission`) VALUES
('88bf439a-e2b7-11ee-a93d-f854f615a071', 'VC-2024', 4),
('04.07.2024.09.12.02person66126362a4a', 'OM-04.07.2024.09.12.02', 1),
('04.13.2024.01.00.07person661a81d769a', 'cC-04.13.2024.01.00.07', 1),
('04.13.2024.02.34.32person661a97f89cc', 'cc-04.13.2024.02.34.32', 1),
('04.13.2024.02.43.23person661a9a0bd51', 'cc-04.13.2024.02.43.23', NULL),
('04.13.2024.02.50.12person661a9ba4263', 'cc-04.13.2024.02.50.12', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(50) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `countries`
--

INSERT INTO `countries` (`id`, `country_name`, `nationality`) VALUES
(1, 'France', 'français'),
(22, 'Suède', 'suédois'),
(21, 'Russie', 'russe'),
(5, 'Italie', 'italien'),
(6, 'USA', 'américain'),
(7, 'AAAAA - Apatride', 'AAAAA - Aucune '),
(19, 'Espagne', 'espagnol'),
(9, 'Angleterre', 'Anglais'),
(20, 'Chine ', 'chinois');

-- --------------------------------------------------------

--
-- Structure de la table `hideouts`
--

DROP TABLE IF EXISTS `hideouts`;
CREATE TABLE IF NOT EXISTS `hideouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code_hide` varchar(60) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zipcode` char(5) NOT NULL,
  `address` varchar(255) NOT NULL,
  `id_country` int(11) NOT NULL,
  `id_typeHide` int(11) NOT NULL,
  `id_mission` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_country` (`id_country`),
  KEY `id_typeHide` (`id_typeHide`),
  KEY `id_mission` (`id_mission`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `hideouts`
--

INSERT INTO `hideouts` (`id`, `code_hide`, `city`, `zipcode`, `address`, `id_country`, `id_typeHide`, `id_mission`) VALUES
(1, '69Ly1-3', 'Lyon', '69000', '52 rue du Général de Leclerc                            ', 1, 3, NULL),
(2, '01Vi1-3', 'VilleCity', '01256', '25 Allée des Lilas ', 1, 3, 4),
(3, '91Lo9-1', 'London', '91542', '3  Big Ben Street                            ', 9, 1, NULL),
(4, '54Mo1-4', 'MontagneCity', '54820', 'Gîtes des Montagnards, 3 rue de la forêt                            ', 1, 4, 1),
(5, '71Li1-1', 'Limonades', '71568', '356 Rue des Girolles                            ', 1, 1, 6),
(6, '25Pl1-1', 'PlageVille', '25460', 'Rue Champêtre', 1, 1, NULL),
(8, '08Ba19-1', 'Barcelona', '08003', '          Avenida Argentera                  ', 19, 1, 2),
(9, '01df7-5', 'dfdfd', '01234', '                            adress', 7, 5, NULL),
(10, '01Mo21-3', 'Moscou', '01234', '                Place Poutine        ', 21, 3, 3),
(11, '02Ch1-7', 'Chevalerie', '02354', '15 rue des Chevaliers', 1, 7, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `missions`
--

DROP TABLE IF EXISTS `missions`;
CREATE TABLE IF NOT EXISTS `missions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `code_name` varchar(60) NOT NULL,
  `begin_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `id_country` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `id_typeMission` int(11) NOT NULL,
  `id_speciality` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_country` (`id_country`),
  KEY `id_status` (`id_status`),
  KEY `id_typeMission` (`id_typeMission`),
  KEY `id_speciality` (`id_speciality`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `missions`
--

INSERT INTO `missions` (`id`, `title`, `description`, `code_name`, `begin_date`, `end_date`, `id_country`, `id_status`, `id_typeMission`, `id_speciality`) VALUES
(1, 'Surveillance sur Lyon', 'Nous suspectons la cible d\'être à l\'origine d\'un trafic de cosmétiques modifiés.', 'Surve-6-1-1004.12.2024.09.06.25', '2024-03-15', '2024-04-27', 1, 1, 6, 10),
(2, 'Recherche de témoin', 'Recherche de témoin après une bagarre ayant entraîner la mort d\'un jeune homme.', 'Reche-5-19-1004.11.2024.09.27.12', '2024-04-05', '2024-04-18', 19, 2, 5, 10),
(3, 'Infiltration dans la mafia Russe', 'Infiltration pour déjouer un trafic de stupéfiant', 'Infil-3-21-904.11.2024.07.57.00', '2024-04-10', '2024-04-24', 21, 2, 3, 9),
(4, 'recherche personne disparue', 'Un enfant a disparu et a peut-être été enlevé.', 'reche-5-1-204.16.2024.12.33.53', '2024-04-03', '2024-04-26', 1, 2, 5, 2),
(5, 'recherche de fugitif', 'Recherche d\'un évadé de prison armé et dangereux.', 'reche-2-20-204.11.2024.08.54.51', '2024-04-06', '2024-04-09', 20, 2, 2, 2),
(6, 'Infiltration dans un groupe de traficants', 'Infiltration d\'un réseau soupçonné de trafic de drogue dans la région de Marseille', 'Infil-3-1-304.09.2024.02.50.33', '2024-04-10', '2024-05-02', 1, 11, 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `persons`
--

DROP TABLE IF EXISTS `persons`;
CREATE TABLE IF NOT EXISTS `persons` (
  `id` char(36) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `birthdate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `persons`
--

INSERT INTO `persons` (`id`, `first_name`, `last_name`, `birthdate`) VALUES
('ef6cec36-e2b3-11ee-a93d-f854f615a071', 'John', 'Doe', '1982-02-10'),
('0d552303-e2b4-11ee-a93d-f854f615a071', 'James', 'Bond', '1984-03-23'),
('73b37947-e2b4-11ee-a93d-f854f615a071', 'Jack', 'Nicholson', '1937-04-22'),
('88bf439a-e2b7-11ee-a93d-f854f615a071', 'Vincent', 'Cassel', '1966-11-23'),
('04.13.2024.01.00.07person661a81d769a', 'Jean', 'Réno', '1948-07-30'),
('04.13.2024.02.34.32person661a97f89cc', 'Eva', 'Green', '1980-07-06'),
('04.07.2024.09.12.02person66126362a4a', 'Olivier', 'Martinez', '1966-01-12'),
('04.14.2024.04.27.22person661c03eaafe', 'Hugo', 'Weaving', '1960-04-04'),
('04.07.2024.10.39.45person661277f1a45', 'Sean', 'Connery', '1930-08-25'),
('04.13.2024.02.43.23person661a9a0bd51', 'Lambert', 'Wilson', '1958-08-03'),
('04.07.2024.10.45.50person6612795e68d', 'Pierce', 'Brosnan', '1953-05-16'),
('04.07.2024.11.15.54person6612806ac2e', 'Charly', 'Scott', '1975-09-23'),
('04.14.2024.04.27.50person661c04067d9', 'Alan', 'Rickman', '1946-02-21'),
('04.14.2024.04.28.17person661c04218c0', 'Vladimir', 'Poutine', '1952-10-07'),
('04.16.2024.12.10.27person661e6ab30d8', 'Bob', 'Synclair', '1967-06-02'),
('04.13.2024.02.50.12person661a9ba4263', 'Rebecca', 'Fergusson', '1983-10-19'),
('04.15.2024.07.54.49person661cdd499a5', 'Daneil', 'Craig', '1968-03-02'),
('04.15.2024.02.25.50person661d38ee1d7', 'Emma ', 'Watson', '1990-04-15'),
('04.15.2024.02.26.20person661d390c7a9', 'Julianne', 'Moore', '1960-12-03'),
('04.15.2024.02.26.43person661d39237ff', 'Pénélop', 'Cruz', '1974-04-28'),
('04.15.2024.02.53.49person661d3f7d1bc', 'Pierce', 'Brosnan', '1953-05-16'),
('04.15.2024.04.56.25person661d5c39001', 'Thimothy', 'Dalton', '1946-03-21'),
('04.16.2024.12.29.14person661e6f1a460', 'Anne', 'Hathaway', '1982-11-12');

-- --------------------------------------------------------

--
-- Structure de la table `persons_countries`
--

DROP TABLE IF EXISTS `persons_countries`;
CREATE TABLE IF NOT EXISTS `persons_countries` (
  `id_person` char(36) NOT NULL,
  `id_country` int(11) NOT NULL,
  PRIMARY KEY (`id_person`,`id_country`),
  KEY `id_country` (`id_country`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `persons_countries`
--

INSERT INTO `persons_countries` (`id_person`, `id_country`) VALUES
('04.07.2024.09.12.02person66126362a4a', 1),
('04.07.2024.10.39.45person661277f1a45', 9),
('04.07.2024.10.45.50person6612795e68d', 6),
('04.07.2024.10.45.50person6612795e68d', 9),
('04.07.2024.11.15.54person6612806ac2e', 6),
('04.10.2024.02.32.51person6616a31372a', 6),
('04.10.2024.02.35.28person6616a3b0654', 6),
('04.10.2024.02.36.38person6616a3f6e14', 9),
('04.11.2024.05.48.20person66182264d47', 7),
('04.11.2024.05.53.10person66182386456', 7),
('04.11.2024.05.58.29person661824c5842', 7),
('04.13.2024.01.00.07person661a81d769a', 1),
('04.13.2024.01.00.07person661a81d769a', 19),
('04.13.2024.01.00.07person661a81d769a', 21),
('04.13.2024.02.34.32person661a97f89cc', 1),
('04.13.2024.02.34.32person661a97f89cc', 20),
('04.13.2024.02.43.23person661a9a0bd51', 1),
('04.13.2024.02.50.12person661a9ba4263', 21),
('04.13.2024.02.50.12person661a9ba4263', 22),
('04.14.2024.04.27.22person661c03eaafe', 9),
('04.14.2024.04.27.50person661c04067d9', 9),
('04.14.2024.04.28.17person661c04218c0', 21),
('04.15.2024.02.25.50person661d38ee1d7', 1),
('04.15.2024.02.26.20person661d390c7a9', 6),
('04.15.2024.02.26.43person661d39237ff', 19),
('04.15.2024.02.53.49person661d3f7d1bc', 6),
('04.15.2024.02.53.49person661d3f7d1bc', 9),
('04.15.2024.04.56.25person661d5c39001', 9),
('04.15.2024.04.56.25person661d5c39001', 19),
('04.15.2024.07.54.49person661cdd499a5', 6),
('04.15.2024.07.54.49person661cdd499a5', 9),
('04.16.2024.12.10.27person661e6ab30d8', 6),
('04.16.2024.12.29.14person661e6f1a460', 6),
('0d552303-e2b4-11ee-a93d-f854f615a071', 9),
('73b37947-e2b4-11ee-a93d-f854f615a071', 6),
('88bf439a-e2b7-11ee-a93d-f854f615a071', 1);

-- --------------------------------------------------------

--
-- Structure de la table `specialities`
--

DROP TABLE IF EXISTS `specialities`;
CREATE TABLE IF NOT EXISTS `specialities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `specialities`
--

INSERT INTO `specialities` (`id`, `name`) VALUES
(10, 'Surveillance'),
(2, 'Tireur d\'élite'),
(7, 'polyglotte'),
(9, 'Infiltration'),
(8, 'Combats rapprochés');

-- --------------------------------------------------------

--
-- Structure de la table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'En préparation'),
(2, 'En cours'),
(10, 'Terminé'),
(5, 'Echec'),
(14, 'En attente de confirmation'),
(12, 'Bientôt terminé');

-- --------------------------------------------------------

--
-- Structure de la table `targets`
--

DROP TABLE IF EXISTS `targets`;
CREATE TABLE IF NOT EXISTS `targets` (
  `id_target` char(36) NOT NULL,
  `code_name` varchar(60) NOT NULL,
  `id_mission` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_target`),
  KEY `id_mission` (`id_mission`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `targets`
--

INSERT INTO `targets` (`id_target`, `code_name`, `id_mission`) VALUES
('73b37947-e2b4-11ee-a93d-f854f615a071', 'JN-2024', 1),
('04.14.2024.04.27.22person661c03eaafe', 'cc-04.14.2024.04.27.22', 3),
('04.14.2024.04.27.50person661c04067d9', 'cc-04.14.2024.04.27.50', 1),
('04.14.2024.04.28.17person661c04218c0', 'cc-04.14.2024.04.28.17', 3),
('04.16.2024.12.29.14person661e6f1a460', 'AH-04.16.2024.12.29.14', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `typehideouts`
--

DROP TABLE IF EXISTS `typehideouts`;
CREATE TABLE IF NOT EXISTS `typehideouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_hide` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `typehideouts`
--

INSERT INTO `typehideouts` (`id`, `type_hide`) VALUES
(1, 'maison isolée'),
(7, 'appartement'),
(3, 'chez un contact'),
(4, 'Châlet de montagne'),
(5, 'cabane dans les arbres'),
(6, 'cabane de chasseur');

-- --------------------------------------------------------

--
-- Structure de la table `typemissions`
--

DROP TABLE IF EXISTS `typemissions`;
CREATE TABLE IF NOT EXISTS `typemissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_mission` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `typemissions`
--

INSERT INTO `typemissions` (`id`, `type_mission`) VALUES
(6, 'Surveillance'),
(2, 'Assassinat'),
(3, 'Infiltration'),
(4, 'Protection de témoin'),
(5, 'Recherche de personne');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
