-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 30 sep. 2025 à 09:36
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `marche_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `acheteur`
--

DROP TABLE IF EXISTS `acheteur`;
CREATE TABLE IF NOT EXISTS `acheteur` (
  `IdAcheteur` int NOT NULL AUTO_INCREMENT,
  `NomAcheteur` varchar(100) DEFAULT NULL,
  `PostNomAcheteur` varchar(100) DEFAULT NULL,
  `SexeAcheteur` enum('M','F') DEFAULT NULL,
  PRIMARY KEY (`IdAcheteur`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `acheteur`
--

INSERT INTO `acheteur` (`IdAcheteur`, `NomAcheteur`, `PostNomAcheteur`, `SexeAcheteur`) VALUES
(1, 'Jean', 'Pierre', 'M');

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `IdAdmin` int NOT NULL AUTO_INCREMENT,
  `NomAdmin` varchar(100) DEFAULT NULL,
  `EmailAdmin` varchar(100) DEFAULT NULL,
  `MotDePasseAdmin` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IdAdmin`),
  UNIQUE KEY `EmailAdmin` (`EmailAdmin`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`IdAdmin`, `NomAdmin`, `EmailAdmin`, `MotDePasseAdmin`) VALUES
(1, 'Dupont', 'dupont@admin.com', 'admin123');

-- --------------------------------------------------------

--
-- Structure de la table `agent`
--

DROP TABLE IF EXISTS `agent`;
CREATE TABLE IF NOT EXISTS `agent` (
  `IdAgent` int NOT NULL AUTO_INCREMENT,
  `NomAgent` varchar(100) DEFAULT NULL,
  `EmailAgent` varchar(100) DEFAULT NULL,
  `MotDePasseAgent` varchar(255) DEFAULT NULL,
  `IdAdmin` int DEFAULT NULL,
  PRIMARY KEY (`IdAgent`),
  UNIQUE KEY `IdAdmin` (`IdAdmin`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `agent`
--

INSERT INTO `agent` (`IdAgent`, `NomAgent`, `EmailAgent`, `MotDePasseAgent`, `IdAdmin`) VALUES
(1, 'Martin', 'martin@agent.com', 'agent123', 1);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `IdCommande` int NOT NULL AUTO_INCREMENT,
  `IdProduit` int DEFAULT NULL,
  `PrixUnitaire` decimal(10,2) DEFAULT NULL,
  `DateCmd` date DEFAULT NULL,
  `IdMarche` int DEFAULT NULL,
  PRIMARY KEY (`IdCommande`),
  KEY `IdProduit` (`IdProduit`),
  KEY `IdMarche` (`IdMarche`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`IdCommande`, `IdProduit`, `PrixUnitaire`, `DateCmd`, `IdMarche`) VALUES
(1, 1, 1500.00, '2025-09-21', 3),
(2, 1, 100.00, '2025-09-21', 2),
(3, 1, 2500.00, '2025-09-23', 3),
(4, 1, 2500.00, '2025-09-23', 2),
(5, 2, 100.00, '2025-09-23', 3),
(6, 3, 50.00, '2025-09-23', 2),
(7, 1, 200.00, '2025-08-25', 3),
(8, 1, 300.00, '2025-07-17', 3),
(9, NULL, NULL, NULL, NULL),
(10, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `demande_commande`
--

DROP TABLE IF EXISTS `demande_commande`;
CREATE TABLE IF NOT EXISTS `demande_commande` (
  `IdDemande` int NOT NULL AUTO_INCREMENT,
  `IdAcheteur` int DEFAULT NULL,
  `IdProduit` int DEFAULT NULL,
  `PrixPropose` decimal(10,2) DEFAULT NULL,
  `DateDemande` date DEFAULT NULL,
  `Statut` enum('En attente','Validée','Rejetée') DEFAULT 'En attente',
  PRIMARY KEY (`IdDemande`),
  KEY `IdAcheteur` (`IdAcheteur`),
  KEY `IdProduit` (`IdProduit`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `demande_commande`
--

INSERT INTO `demande_commande` (`IdDemande`, `IdAcheteur`, `IdProduit`, `PrixPropose`, `DateDemande`, `Statut`) VALUES
(1, 1, 2, 100.00, '2025-09-23', 'Validée'),
(3, 1, 3, 50.00, '2025-09-23', 'Validée'),
(4, 1, 2, 500.00, '2025-09-23', 'Rejetée'),
(5, 1, 1, 200.00, '2025-08-25', 'Validée'),
(6, 1, 1, 300.00, '2025-07-17', 'Validée');

-- --------------------------------------------------------

--
-- Structure de la table `marche`
--

DROP TABLE IF EXISTS `marche`;
CREATE TABLE IF NOT EXISTS `marche` (
  `IdMarche` int NOT NULL AUTO_INCREMENT,
  `NomMarche` varchar(100) DEFAULT NULL,
  `Localisation` varchar(255) DEFAULT NULL,
  `IdAgent` int DEFAULT NULL,
  PRIMARY KEY (`IdMarche`),
  KEY `IdAgent` (`IdAgent`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `marche`
--

INSERT INTO `marche` (`IdMarche`, `NomMarche`, `Localisation`, `IdAgent`) VALUES
(3, 'Kadutu', 'Nyamugo industriel', 1),
(2, 'Nyawera', 'nyawera', 1);

-- --------------------------------------------------------

--
-- Structure de la table `prix`
--

DROP TABLE IF EXISTS `prix`;
CREATE TABLE IF NOT EXISTS `prix` (
  `IdPrix` int NOT NULL AUTO_INCREMENT,
  `Valeur` decimal(10,2) DEFAULT NULL,
  `Unite` varchar(20) DEFAULT NULL,
  `DateReleve` date DEFAULT NULL,
  `IdProduit` int DEFAULT NULL,
  `IdMarche` int DEFAULT NULL,
  PRIMARY KEY (`IdPrix`),
  KEY `IdProduit` (`IdProduit`),
  KEY `IdMarche` (`IdMarche`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `prix`
--

INSERT INTO `prix` (`IdPrix`, `Valeur`, `Unite`, `DateReleve`, `IdProduit`, `IdMarche`) VALUES
(1, 1500.00, 'kg', '2025-09-21', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `IdProduit` int NOT NULL AUTO_INCREMENT,
  `NomProduit` varchar(100) DEFAULT NULL,
  `Description` text,
  `IdVendeur` int DEFAULT NULL,
  `IdMarche` int DEFAULT NULL,
  `DateMaj` date DEFAULT NULL,
  `Prix` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`IdProduit`),
  KEY `IdVendeur` (`IdVendeur`),
  KEY `IdMarche` (`IdMarche`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`IdProduit`, `NomProduit`, `Description`, `IdVendeur`, `IdMarche`, `DateMaj`, `Prix`) VALUES
(1, 'Tomate', 'Tomates fraîches', 1, 3, '2025-09-21', 50.00),
(2, 'sac de riz Azam', 'riz de qualité Tanzanienne', 1, 3, '2025-05-23', 20.00),
(3, 'Sac farine de blé Azam', 'farine de la tanzanie', 1, 3, '2025-09-23', 30.00),
(4, 'sac haricots blanc', 'Haricot de Kiliba', 2, 3, '2025-09-27', 50.00),
(8, 'Sac haricot rouge', 'haricot meilleur qualité', 2, 3, '2025-09-29', 100.00),
(7, 'Sac de farine blé Azam', 'Farine Tanzanie', 2, 3, '2025-09-29', 25.00),
(9, 'Sac OMO ', 'OMO bleu', 2, 3, '2025-09-29', 5.00),
(10, 'sac de riz Azam', 'Riz tanzanie', 2, 3, '2025-09-29', 20.00);

-- --------------------------------------------------------

--
-- Structure de la table `rapport`
--

DROP TABLE IF EXISTS `rapport`;
CREATE TABLE IF NOT EXISTS `rapport` (
  `IdRapport` int NOT NULL AUTO_INCREMENT,
  `Periode` varchar(20) DEFAULT NULL,
  `TableauVariation` text,
  `DiagrammeVariation` text,
  `IdAgent` int DEFAULT NULL,
  PRIMARY KEY (`IdRapport`),
  KEY `IdAgent` (`IdAgent`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `rapport`
--

INSERT INTO `rapport` (`IdRapport`, `Periode`, `TableauVariation`, `DiagrammeVariation`, `IdAgent`) VALUES
(1, 'Semaine 38', 'Variation stable', 'Diagramme1', 1);

-- --------------------------------------------------------

--
-- Structure de la table `releve_mensuel`
--

DROP TABLE IF EXISTS `releve_mensuel`;
CREATE TABLE IF NOT EXISTS `releve_mensuel` (
  `IdReleve` int NOT NULL AUTO_INCREMENT,
  `IdProduit` int DEFAULT NULL,
  `IdMarche` int DEFAULT NULL,
  `Mois` date DEFAULT NULL,
  `Prix` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`IdReleve`),
  KEY `IdProduit` (`IdProduit`),
  KEY `IdMarche` (`IdMarche`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `releve_mensuel`
--

INSERT INTO `releve_mensuel` (`IdReleve`, `IdProduit`, `IdMarche`, `Mois`, `Prix`) VALUES
(1, 1, 3, '2025-09-01', 6600.00),
(3, 3, 3, '2025-09-01', 5000.00),
(4, 1, 3, '2025-09-01', 4000.00),
(5, 1, 3, '2025-08-01', 4000.00),
(2, 1, 2, '2025-09-15', 1000.00),
(13, 4, 2, '0000-00-00', 0.00);

-- --------------------------------------------------------

--
-- Structure de la table `releve_trimestriel`
--

DROP TABLE IF EXISTS `releve_trimestriel`;
CREATE TABLE IF NOT EXISTS `releve_trimestriel` (
  `IdReleve` int NOT NULL AUTO_INCREMENT,
  `IdProduit` int DEFAULT NULL,
  `IdMarche` int DEFAULT NULL,
  `Trimestre` int DEFAULT NULL,
  `Annee` int DEFAULT NULL,
  `Prix` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`IdReleve`),
  KEY `IdProduit` (`IdProduit`),
  KEY `IdMarche` (`IdMarche`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `releve_trimestriel`
--

INSERT INTO `releve_trimestriel` (`IdReleve`, `IdProduit`, `IdMarche`, `Trimestre`, `Annee`, `Prix`) VALUES
(1, 1, 3, NULL, 2025, 450.00),
(4, 4, 2, NULL, 2025, 1500.00),
(3, 3, 2, NULL, 2025, 200.00),
(5, NULL, NULL, NULL, 2025, NULL),
(6, NULL, NULL, NULL, 2025, NULL),
(7, 3, 2, NULL, 2025, 2500.00);

-- --------------------------------------------------------

--
-- Structure de la table `vendeur`
--

DROP TABLE IF EXISTS `vendeur`;
CREATE TABLE IF NOT EXISTS `vendeur` (
  `IdVendeur` int NOT NULL AUTO_INCREMENT,
  `NomVendeur` varchar(100) DEFAULT NULL,
  `EmailVendeur` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `MotDePasseVendeur` varchar(255) DEFAULT NULL,
  `IdMarche` int DEFAULT NULL,
  PRIMARY KEY (`IdVendeur`),
  UNIQUE KEY `EmailVendeur` (`EmailVendeur`),
  KEY `IdMarche` (`IdMarche`),
  KEY `EmailVendeur_2` (`EmailVendeur`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `vendeur`
--

INSERT INTO `vendeur` (`IdVendeur`, `NomVendeur`, `EmailVendeur`, `MotDePasseVendeur`, `IdMarche`) VALUES
(1, 'L\'INFINI', 'linfini@vendeur.com', 'vendeur123', 3),
(2, 'MUKAMBA', 'mukamba@vendeur.com', 'mukamba123', 1),
(3, 'François ', 'francois@gmail.com', 'francois123', 3),
(4, 'Mbokani Bienfait', 'mbokani@gmail.com', 'mbokani123', NULL),
(5, 'Tohangye Jonathan ', 'tohangye@gmail.com', 'tohangye123', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
