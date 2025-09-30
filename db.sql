DROP DATABASE IF EXISTS marche_db;
CREATE DATABASE marche_db;
USE marche_db;

CREATE TABLE admin (
  IdAdmin INT AUTO_INCREMENT PRIMARY KEY,
  NomAdmin VARCHAR(100),
  EmailAdmin VARCHAR(100) UNIQUE,
  MotDePasseAdmin VARCHAR(255)
);

CREATE TABLE agent (
  IdAgent INT AUTO_INCREMENT PRIMARY KEY,
  NomAgent VARCHAR(100),
  EmailAgent VARCHAR(100) UNIQUE,
  MotDePasseAgent VARCHAR(255),
  IdAdmin INT,
  FOREIGN KEY (IdAdmin) REFERENCES admin(IdAdmin)
);

CREATE TABLE acheteur (
  IdAcheteur INT AUTO_INCREMENT PRIMARY KEY,
  NomAcheteur VARCHAR(100),
  PostNomAcheteur VARCHAR(100),
  SexeAcheteur ENUM('M', 'F')
);

CREATE TABLE vendeur (
  IdVendeur INT AUTO_INCREMENT PRIMARY KEY,
  NomVendeur VARCHAR(100),
  EmailVendeur VARCHAR(100) UNIQUE,
  MotDePasseVendeur VARCHAR(255)
);

CREATE TABLE marche (
  IdMarche INT AUTO_INCREMENT PRIMARY KEY,
  NomMarche VARCHAR(100),
  Localisation VARCHAR(255),
  IdAgent INT,
  FOREIGN KEY (IdAgent) REFERENCES agent(IdAgent)
);

CREATE TABLE produit (
  IdProduit INT AUTO_INCREMENT PRIMARY KEY,
  NomProduit VARCHAR(100),
  Description TEXT,
  IdVendeur INT,
  IdMarche INT,
  DateMaj DATE,
  FOREIGN KEY (IdVendeur) REFERENCES vendeur(IdVendeur),
  FOREIGN KEY (IdMarche) REFERENCES marche(IdMarche)
);

CREATE TABLE prix (
  IdPrix INT AUTO_INCREMENT PRIMARY KEY,
  Valeur DECIMAL(10,2),
  Unite VARCHAR(20),
  DateReleve DATE,
  IdProduit INT,
  IdMarche INT,
  FOREIGN KEY (IdProduit) REFERENCES produit(IdProduit),
  FOREIGN KEY (IdMarche) REFERENCES marche(IdMarche)
);

CREATE TABLE rapport (
  IdRapport INT AUTO_INCREMENT PRIMARY KEY,
  Periode VARCHAR(20),
  TableauVariation TEXT,
  DiagrammeVariation TEXT,
  IdAgent INT,
  FOREIGN KEY (IdAgent) REFERENCES agent(IdAgent)
);

CREATE TABLE commande (
  IdCommande INT AUTO_INCREMENT PRIMARY KEY,
  IdProduit INT,
  PrixUnitaire DECIMAL(10,2),
  DateCmd DATE,
  IdMarche INT,
  FOREIGN KEY (IdMarche) REFERENCES marche(IdMarche),
  FOREIGN KEY (IdProduit) REFERENCES produit(IdProduit)
);

-- Insertion dans admin
INSERT INTO admin (NomAdmin, EmailAdmin, MotDePasseAdmin)
VALUES ('Dupont', 'dupont@admin.com', 'admin123');

-- Insertion dans agent (lié à admin)
INSERT INTO agent (NomAgent, EmailAgent, MotDePasseAgent, IdAdmin)
VALUES ('Martin', 'martin@agent.com', 'agent123', 1);

-- Insertion dans acheteur
INSERT INTO acheteur (NomAcheteur, PostNomAcheteur, SexeAcheteur)
VALUES ('Jean', 'Pierre', 'M');

-- Insertion dans vendeur
INSERT INTO vendeur (NomVendeur, EmailVendeur, MotDePasseVendeur)
VALUES ('Durand', 'durand@vendeur.com', 'vendeur123');

-- Insertion dans marche (lié à agent)
INSERT INTO marche (NomMarche, Localisation, IdAgent)
VALUES ('Marché Central', 'Centre-ville', 1);

-- Insertion dans produit (lié à vendeur et marche)
INSERT INTO produit (NomProduit, Description, IdVendeur, IdMarche, DateMaj)
VALUES ('Tomate', 'Tomates fraîches', 1, 1, '2025-09-21');

-- Insertion dans prix (lié à produit et marche)
INSERT INTO prix (Valeur, Unite, DateReleve, IdProduit, IdMarche)
VALUES (1500.00, 'kg', '2025-09-21', 1, 1);

-- Insertion dans rapport (lié à agent)
INSERT INTO rapport (Periode, TableauVariation, DiagrammeVariation, IdAgent)
VALUES ('Semaine 38', 'Variation stable', 'Diagramme1', 1);

-- Exemple d'insertion dans commande (lié au produit existant)
INSERT INTO commande (IdProduit, PrixUnitaire, DateCmd)
VALUES (1, 1500.00, '2025-09-21');

CREATE TABLE demande_commande (
  IdDemande INT AUTO_INCREMENT PRIMARY KEY,
  IdAcheteur INT,
  IdProduit INT,
  PrixPropose DECIMAL(10,2),
  DateDemande DATE,
  Statut ENUM('En attente', 'Validée', 'Rejetée') DEFAULT 'En attente',
  FOREIGN KEY (IdAcheteur) REFERENCES acheteur(IdAcheteur),
  FOREIGN KEY (IdProduit) REFERENCES produit(IdProduit)
);

CREATE TABLE releve_prix (
  IdReleve INT AUTO_INCREMENT PRIMARY KEY,
  IdProduit INT,
  IdMarche INT,
  Prix DECIMAL(10,2),
  DateReleve DATE,
  FOREIGN KEY (IdProduit) REFERENCES produit(IdProduit),
  FOREIGN KEY (IdMarche) REFERENCES marche(IdMarche)
);

CREATE TABLE releve_trimestriel (
  IdReleve INT AUTO_INCREMENT PRIMARY KEY,
  IdProduit INT,
  IdMarche INT,
  Trimestre INT,
  Annee INT,
  Prix DECIMAL(10,2),
  FOREIGN KEY (IdProduit) REFERENCES produit(IdProduit),
  FOREIGN KEY (IdMarche) REFERENCES marche(IdMarche)
);

CREATE TABLE releve_mensuel (
  IdReleve INT AUTO_INCREMENT PRIMARY KEY,
  IdProduit INT,
  IdMarche INT,
  Mois DATE,
  Prix DECIMAL(10,2),
  FOREIGN KEY (IdProduit) REFERENCES produit(IdProduit),
  FOREIGN KEY (IdMarche) REFERENCES marche(IdMarche)
);
