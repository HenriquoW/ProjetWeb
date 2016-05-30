-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 30 Mai 2016 à 15:27
-- Version du serveur :  10.1.13-MariaDB
-- Version de PHP :  7.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `asptt_dijon`
--

-- --------------------------------------------------------

--
-- Structure de la table `Adherent`
--

CREATE TABLE `Adherent` (
  `Id_Adherent` int(11) NOT NULL,
  `NumeroLicence` varchar(25) NOT NULL,
  `DateInscription` date NOT NULL,
  `Id_Utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Adherent`
--

INSERT INTO `Adherent` (`Id_Adherent`, `NumeroLicence`, `DateInscription`, `Id_Utilisateur`) VALUES
(1, '1265486325a', '2016-05-06', 2),
(2, '154613488615d', '2016-05-06', 3);

-- --------------------------------------------------------

--
-- Structure de la table `Categorie`
--

CREATE TABLE `Categorie` (
  `Id_Categorie` int(11) NOT NULL,
  `Nom` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Categorie`
--

INSERT INTO `Categorie` (`Id_Categorie`, `Nom`) VALUES
(1, 'Cadet'),
(2, 'Junior'),
(0, 'Minime'),
(3, 'Senior'),
(4, 'Veteran');

-- --------------------------------------------------------

--
-- Structure de la table `Charger`
--

CREATE TABLE `Charger` (
  `Id_Voyage` int(11) NOT NULL,
  `Id_Utilisateur` int(11) NOT NULL,
  `Id_Role` int(11) DEFAULT NULL,
  `Id_Tache` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Charger`
--

INSERT INTO `Charger` (`Id_Voyage`, `Id_Utilisateur`, `Id_Role`, `Id_Tache`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Club_Organisateur`
--

CREATE TABLE `Club_Organisateur` (
  `Id_Club_Organisateur` int(11) NOT NULL,
  `Nom` varchar(25) DEFAULT NULL,
  `President` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Club_Organisateur`
--

INSERT INTO `Club_Organisateur` (`Id_Club_Organisateur`, `Nom`, `President`) VALUES
(1, 'Club Titi', 'Monsieur Geal');

-- --------------------------------------------------------

--
-- Structure de la table `Competiteur`
--

CREATE TABLE `Competiteur` (
  `Id_Competiteur` int(11) NOT NULL,
  `Photo` varchar(25) NOT NULL,
  `Id_Adherent` int(11) NOT NULL,
  `Id_Specialite` int(11) DEFAULT NULL,
  `Id_Categorie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Competiteur`
--

INSERT INTO `Competiteur` (`Id_Competiteur`, `Photo`, `Id_Adherent`, `Id_Specialite`, `Id_Categorie`) VALUES
(1, '/photo/machinbidule.jpg', 1, 1, 1),
(2, '/photo/JuKi.jpg', 2, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Competition`
--

CREATE TABLE `Competition` (
  `Id_Competition` int(11) NOT NULL,
  `Adresse` varchar(25) DEFAULT NULL,
  `DateCompetition` date DEFAULT NULL,
  `Id_Sexe` int(11) DEFAULT NULL,
  `Id_Type_Competition` int(11) NOT NULL,
  `ID_Club_Organisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Competition`
--

INSERT INTO `Competition` (`Id_Competition`, `Adresse`, `DateCompetition`, `Id_Sexe`, `Id_Type_Competition`, `ID_Club_Organisateur`) VALUES
(1, '56 place truc', '2017-05-06', NULL, 1, 1),
(2, '56 stade bernard', '2001-05-06', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Course`
--

CREATE TABLE `Course` (
  `Id_Course` int(11) NOT NULL,
  `Distance` int(11) DEFAULT NULL,
  `Equipe` tinyint(1) DEFAULT NULL,
  `Id_Categorie` int(11) DEFAULT NULL,
  `Id_Competition` int(11) DEFAULT NULL,
  `Id_Type_Specialite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Course`
--

INSERT INTO `Course` (`Id_Course`, `Distance`, `Equipe`, `Id_Categorie`, `Id_Competition`, `Id_Type_Specialite`) VALUES
(1, 120, 1, 1, 1, 4),
(5, 120, 0, 1, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `Droits`
--

CREATE TABLE `Droits` (
  `Id_Droit_Acces` int(11) NOT NULL,
  `Id_Utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Droits`
--

INSERT INTO `Droits` (`Id_Droit_Acces`, `Id_Utilisateur`) VALUES
(0, 1),
(0, 2),
(0, 3),
(0, 4),
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(3, 1),
(6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Droit_Acces`
--

CREATE TABLE `Droit_Acces` (
  `Id_Droit_Acces` int(11) NOT NULL,
  `Nom` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Droit_Acces`
--

INSERT INTO `Droit_Acces` (`Id_Droit_Acces`, `Nom`) VALUES
(2, 'Adherent'),
(6, 'Administrateurs'),
(4, 'Entraineur'),
(1, 'Inscrit'),
(3, 'Parent'),
(5, 'Secretaire'),
(0, 'Visiteur');

-- --------------------------------------------------------

--
-- Structure de la table `Envoie`
--

CREATE TABLE `Envoie` (
  `Id_Utilisateur` int(11) NOT NULL,
  `Id_Message` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Equipe`
--

CREATE TABLE `Equipe` (
  `Id_Equipe` int(11) NOT NULL,
  `Nom` varchar(25) DEFAULT NULL,
  `Id_Type_Specialite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Equipe`
--

INSERT INTO `Equipe` (`Id_Equipe`, `Nom`, `Id_Type_Specialite`) VALUES
(1, 'Bidule-Ki', 4);

-- --------------------------------------------------------

--
-- Structure de la table `Message`
--

CREATE TABLE `Message` (
  `Id_Message` int(11) NOT NULL,
  `Sujet` varchar(100) DEFAULT NULL,
  `Corps` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Objectif`
--

CREATE TABLE `Objectif` (
  `Id_Competiteur` int(11) NOT NULL,
  `Id_Competition` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Objectif`
--

INSERT INTO `Objectif` (`Id_Competiteur`, `Id_Competition`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Palmares_Competiteur`
--

CREATE TABLE `Palmares_Competiteur` (
  `Id_Competiteur` int(11) NOT NULL,
  `Classement` int(11) DEFAULT NULL,
  `Id_Course` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Palmares_Competiteur`
--

INSERT INTO `Palmares_Competiteur` (`Id_Competiteur`, `Classement`, `Id_Course`) VALUES
(1, 8, 5);

-- --------------------------------------------------------

--
-- Structure de la table `Palmares_Equipe`
--

CREATE TABLE `Palmares_Equipe` (
  `Id_Equipe` int(11) NOT NULL,
  `Classement` int(11) DEFAULT NULL,
  `Id_Course` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Parente`
--

CREATE TABLE `Parente` (
  `Id_Parent` int(11) NOT NULL,
  `Id_Enfant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Parente`
--

INSERT INTO `Parente` (`Id_Parent`, `Id_Enfant`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `Participant_Equipe`
--

CREATE TABLE `Participant_Equipe` (
  `Id_Competiteur` int(11) NOT NULL,
  `Id_Equipe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Participant_Equipe`
--

INSERT INTO `Participant_Equipe` (`Id_Competiteur`, `Id_Equipe`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Participe_Competition_Equipe`
--

CREATE TABLE `Participe_Competition_Equipe` (
  `Id_Equipe` int(11) NOT NULL,
  `Id_Course` int(11) NOT NULL,
  `Validation` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Participe_Competition_Equipe`
--

INSERT INTO `Participe_Competition_Equipe` (`Id_Equipe`, `Id_Course`, `Validation`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Participe_Competition_Solo`
--

CREATE TABLE `Participe_Competition_Solo` (
  `Id_Course` int(11) NOT NULL,
  `Id_Competiteur` int(11) NOT NULL,
  `Validation` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Participe_Competition_Solo`
--

INSERT INTO `Participe_Competition_Solo` (`Id_Course`, `Id_Competiteur`, `Validation`) VALUES
(5, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Participe_Voyage`
--

CREATE TABLE `Participe_Voyage` (
  `Autoriser` tinyint(1) DEFAULT NULL,
  `Id_Voyage` int(11) NOT NULL,
  `Id_Competiteur` int(11) NOT NULL,
  `Id_Type_Voyage` int(11) NOT NULL,
  `Id_Utilisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Participe_Voyage`
--

INSERT INTO `Participe_Voyage` (`Autoriser`, `Id_Voyage`, `Id_Competiteur`, `Id_Type_Voyage`, `Id_Utilisateur`) VALUES
(1, 1, 1, 0, NULL),
(1, 2, 1, 0, NULL),
(1, 2, 2, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Recois`
--

CREATE TABLE `Recois` (
  `Id_Message` int(11) NOT NULL,
  `Id_Utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Role`
--

CREATE TABLE `Role` (
  `Id_Role` int(11) NOT NULL,
  `Titre` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Role`
--

INSERT INTO `Role` (`Id_Role`, `Titre`) VALUES
(3, 'Benevole'),
(2, 'Entraineur'),
(1, 'Juge'),
(0, 'Responsable officiel');

-- --------------------------------------------------------

--
-- Structure de la table `Sexe`
--

CREATE TABLE `Sexe` (
  `Id_Sexe` int(11) NOT NULL,
  `Type` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Sexe`
--

INSERT INTO `Sexe` (`Id_Sexe`, `Type`) VALUES
(1, 'F'),
(0, 'M'),
(2, 'O');

-- --------------------------------------------------------

--
-- Structure de la table `Specialite`
--

CREATE TABLE `Specialite` (
  `Id_Specialite` int(11) NOT NULL,
  `Nom` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Specialite`
--

INSERT INTO `Specialite` (`Id_Specialite`, `Nom`) VALUES
(0, 'Canoe'),
(1, 'Kayak');

-- --------------------------------------------------------

--
-- Structure de la table `Tache`
--

CREATE TABLE `Tache` (
  `Id_Tache` int(11) NOT NULL,
  `Nom` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Tache`
--

INSERT INTO `Tache` (`Id_Tache`, `Nom`) VALUES
(1, 'Depot des reclamation'),
(3, 'Gestion alimentation'),
(4, 'Gestion hebergement'),
(0, 'Reunion de confirmation des inscriptions'),
(2, 'Transport');

-- --------------------------------------------------------

--
-- Structure de la table `Type_Competition`
--

CREATE TABLE `Type_Competition` (
  `Id_Type_Competition` int(11) NOT NULL,
  `Nom` varchar(25) DEFAULT NULL,
  `Selectif` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Type_Competition`
--

INSERT INTO `Type_Competition` (`Id_Type_Competition`, `Nom`, `Selectif`) VALUES
(1, 'Championnat de France', 0);

-- --------------------------------------------------------

--
-- Structure de la table `Type_Specialite`
--

CREATE TABLE `Type_Specialite` (
  `Id_Type_Specialite` int(11) NOT NULL,
  `Nom` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Type_Specialite`
--

INSERT INTO `Type_Specialite` (`Id_Type_Specialite`, `Nom`) VALUES
(0, 'C1'),
(1, 'C2'),
(2, 'C4'),
(3, 'K1'),
(4, 'K2'),
(5, 'K4');

-- --------------------------------------------------------

--
-- Structure de la table `Type_Voyage`
--

CREATE TABLE `Type_Voyage` (
  `Id_Type_Voyage` int(11) NOT NULL,
  `Nom` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Type_Voyage`
--

INSERT INTO `Type_Voyage` (`Id_Type_Voyage`, `Nom`) VALUES
(0, 'Club'),
(1, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `Id_Utilisateur` int(11) NOT NULL,
  `Nom` varchar(25) DEFAULT NULL,
  `Prenom` varchar(25) DEFAULT NULL,
  `Password` varchar(100) NOT NULL,
  `DateNaissance` date DEFAULT NULL,
  `Adresse` varchar(25) DEFAULT NULL,
  `Mail` varchar(25) NOT NULL,
  `Telephone` varchar(25) DEFAULT NULL,
  `Id_Sexe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`Id_Utilisateur`, `Nom`, `Prenom`, `Password`, `DateNaissance`, `Adresse`, `Mail`, `Telephone`, `Id_Sexe`) VALUES
(1, 'Bonfils', 'Adrien', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1994-10-08', '14 rue bidon', 'bonfilsadrien@gmail.com', '0325262524', 0),
(2, 'Machin', 'Bidule', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2000-10-08', '14 rue bidon', 'machinbidule@gmail.com', '0325262524', 0),
(3, 'Ju', 'Ki', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2000-10-08', '14 rue tokyo', 'juki@gmail.com', '0325262524', 1),
(4, 'Bichet ', 'Morgane ', 'd033e22ae348aeb5660fc2140aec35850c4da997', '1995-04-12', '', 'morgane_lucy@hotmail.fr', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Voyage`
--

CREATE TABLE `Voyage` (
  `Id_Voyage` int(11) NOT NULL,
  `Transport_Propose` varchar(25) DEFAULT NULL,
  `Hebergement` varchar(25) DEFAULT NULL,
  `Id_Competition` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Voyage`
--

INSERT INTO `Voyage` (`Id_Voyage`, `Transport_Propose`, `Hebergement`, `Id_Competition`) VALUES
(1, 'Bus', 'Hotel', 2),
(2, 'Bus', 'Aucun', 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Adherent`
--
ALTER TABLE `Adherent`
  ADD PRIMARY KEY (`Id_Adherent`),
  ADD UNIQUE KEY `NumeroLicence` (`NumeroLicence`),
  ADD KEY `FK_Adherent_Id_Utilisateur` (`Id_Utilisateur`);

--
-- Index pour la table `Categorie`
--
ALTER TABLE `Categorie`
  ADD PRIMARY KEY (`Id_Categorie`),
  ADD UNIQUE KEY `Nom` (`Nom`);

--
-- Index pour la table `Charger`
--
ALTER TABLE `Charger`
  ADD PRIMARY KEY (`Id_Voyage`,`Id_Utilisateur`),
  ADD KEY `FK_Charger_Id_Utilisateur` (`Id_Utilisateur`),
  ADD KEY `FK_Charger_Id_Role` (`Id_Role`),
  ADD KEY `FK_Charger_Id_Tache` (`Id_Tache`);

--
-- Index pour la table `Club_Organisateur`
--
ALTER TABLE `Club_Organisateur`
  ADD PRIMARY KEY (`Id_Club_Organisateur`),
  ADD UNIQUE KEY `Nom` (`Nom`);

--
-- Index pour la table `Competiteur`
--
ALTER TABLE `Competiteur`
  ADD PRIMARY KEY (`Id_Competiteur`),
  ADD UNIQUE KEY `Photo` (`Photo`),
  ADD KEY `FK_Competiteur_Id_Adherent` (`Id_Adherent`),
  ADD KEY `FK_Competiteur_Id_Specialite` (`Id_Specialite`),
  ADD KEY `FK_Competiteur_Id_Categorie` (`Id_Categorie`);

--
-- Index pour la table `Competition`
--
ALTER TABLE `Competition`
  ADD PRIMARY KEY (`Id_Competition`),
  ADD KEY `FK_Competition_Id_Sexe` (`Id_Sexe`),
  ADD KEY `FK_Competition_Id_Type_Competition` (`Id_Type_Competition`),
  ADD KEY `FK_Competition_Id_Club_Organisateur` (`ID_Club_Organisateur`);

--
-- Index pour la table `Course`
--
ALTER TABLE `Course`
  ADD PRIMARY KEY (`Id_Course`),
  ADD KEY `FK_Course_Id_Categorie` (`Id_Categorie`),
  ADD KEY `FK_Course_Id_Type_Specialite` (`Id_Type_Specialite`),
  ADD KEY `FK_Course_Id_Competition` (`Id_Competition`);

--
-- Index pour la table `Droits`
--
ALTER TABLE `Droits`
  ADD PRIMARY KEY (`Id_Droit_Acces`,`Id_Utilisateur`),
  ADD KEY `FK_Droits_Id_Utilisateur` (`Id_Utilisateur`);

--
-- Index pour la table `Droit_Acces`
--
ALTER TABLE `Droit_Acces`
  ADD PRIMARY KEY (`Id_Droit_Acces`),
  ADD UNIQUE KEY `Nom` (`Nom`);

--
-- Index pour la table `Envoie`
--
ALTER TABLE `Envoie`
  ADD PRIMARY KEY (`Id_Utilisateur`,`Id_Message`),
  ADD KEY `FK_Envoie_Id_Message` (`Id_Message`);

--
-- Index pour la table `Equipe`
--
ALTER TABLE `Equipe`
  ADD PRIMARY KEY (`Id_Equipe`),
  ADD UNIQUE KEY `Nom` (`Nom`),
  ADD KEY `FK_Equipe_Id_Type_Specialite` (`Id_Type_Specialite`);

--
-- Index pour la table `Message`
--
ALTER TABLE `Message`
  ADD PRIMARY KEY (`Id_Message`);

--
-- Index pour la table `Objectif`
--
ALTER TABLE `Objectif`
  ADD PRIMARY KEY (`Id_Competiteur`,`Id_Competition`),
  ADD KEY `FK_Objectif_Id_Competition` (`Id_Competition`);

--
-- Index pour la table `Palmares_Competiteur`
--
ALTER TABLE `Palmares_Competiteur`
  ADD PRIMARY KEY (`Id_Competiteur`,`Id_Course`),
  ADD KEY `FK_Palmares_Competiteur_Id_Course` (`Id_Course`);

--
-- Index pour la table `Palmares_Equipe`
--
ALTER TABLE `Palmares_Equipe`
  ADD PRIMARY KEY (`Id_Equipe`,`Id_Course`),
  ADD KEY `FK_Palmares_Equipe_Id_Course` (`Id_Course`);

--
-- Index pour la table `Parente`
--
ALTER TABLE `Parente`
  ADD PRIMARY KEY (`Id_Parent`,`Id_Enfant`),
  ADD KEY `FK_Parente_Id_Enfant` (`Id_Enfant`);

--
-- Index pour la table `Participant_Equipe`
--
ALTER TABLE `Participant_Equipe`
  ADD PRIMARY KEY (`Id_Competiteur`,`Id_Equipe`),
  ADD KEY `FK_Participant_Equipe_Id_Equipe` (`Id_Equipe`);

--
-- Index pour la table `Participe_Competition_Equipe`
--
ALTER TABLE `Participe_Competition_Equipe`
  ADD PRIMARY KEY (`Id_Equipe`,`Id_Course`),
  ADD KEY `FK_Participe_Competition_Equipe_Id_Course` (`Id_Course`);

--
-- Index pour la table `Participe_Competition_Solo`
--
ALTER TABLE `Participe_Competition_Solo`
  ADD PRIMARY KEY (`Id_Course`,`Id_Competiteur`),
  ADD KEY `FK_Participe_Competition_Solo_Id_Competiteur` (`Id_Competiteur`);

--
-- Index pour la table `Participe_Voyage`
--
ALTER TABLE `Participe_Voyage`
  ADD PRIMARY KEY (`Id_Voyage`,`Id_Competiteur`,`Id_Type_Voyage`),
  ADD KEY `FK_Participe_Voyage_Id_Competiteur` (`Id_Competiteur`),
  ADD KEY `FK_Participe_Voyage_Id_Type_Voyage` (`Id_Type_Voyage`),
  ADD KEY `FK_Participe_Voyage_Id_Utilisateur` (`Id_Utilisateur`);

--
-- Index pour la table `Recois`
--
ALTER TABLE `Recois`
  ADD PRIMARY KEY (`Id_Message`,`Id_Utilisateur`),
  ADD KEY `FK_Recois_Id_Utilisateur` (`Id_Utilisateur`);

--
-- Index pour la table `Role`
--
ALTER TABLE `Role`
  ADD PRIMARY KEY (`Id_Role`),
  ADD UNIQUE KEY `Titre` (`Titre`);

--
-- Index pour la table `Sexe`
--
ALTER TABLE `Sexe`
  ADD PRIMARY KEY (`Id_Sexe`),
  ADD UNIQUE KEY `Type` (`Type`);

--
-- Index pour la table `Specialite`
--
ALTER TABLE `Specialite`
  ADD PRIMARY KEY (`Id_Specialite`),
  ADD UNIQUE KEY `Nom` (`Nom`);

--
-- Index pour la table `Tache`
--
ALTER TABLE `Tache`
  ADD PRIMARY KEY (`Id_Tache`),
  ADD UNIQUE KEY `Nom` (`Nom`);

--
-- Index pour la table `Type_Competition`
--
ALTER TABLE `Type_Competition`
  ADD PRIMARY KEY (`Id_Type_Competition`),
  ADD UNIQUE KEY `Nom` (`Nom`);

--
-- Index pour la table `Type_Specialite`
--
ALTER TABLE `Type_Specialite`
  ADD PRIMARY KEY (`Id_Type_Specialite`),
  ADD UNIQUE KEY `Nom` (`Nom`);

--
-- Index pour la table `Type_Voyage`
--
ALTER TABLE `Type_Voyage`
  ADD PRIMARY KEY (`Id_Type_Voyage`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`Id_Utilisateur`),
  ADD UNIQUE KEY `Mail` (`Mail`),
  ADD KEY `FK_Utilisateur_Id_Sexe` (`Id_Sexe`);

--
-- Index pour la table `Voyage`
--
ALTER TABLE `Voyage`
  ADD PRIMARY KEY (`Id_Voyage`),
  ADD KEY `FK_Voyage_Id_Competition` (`Id_Competition`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Adherent`
--
ALTER TABLE `Adherent`
  MODIFY `Id_Adherent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `Club_Organisateur`
--
ALTER TABLE `Club_Organisateur`
  MODIFY `Id_Club_Organisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `Competiteur`
--
ALTER TABLE `Competiteur`
  MODIFY `Id_Competiteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `Competition`
--
ALTER TABLE `Competition`
  MODIFY `Id_Competition` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `Course`
--
ALTER TABLE `Course`
  MODIFY `Id_Course` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `Equipe`
--
ALTER TABLE `Equipe`
  MODIFY `Id_Equipe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `Message`
--
ALTER TABLE `Message`
  MODIFY `Id_Message` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Type_Competition`
--
ALTER TABLE `Type_Competition`
  MODIFY `Id_Type_Competition` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `Id_Utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `Voyage`
--
ALTER TABLE `Voyage`
  MODIFY `Id_Voyage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Adherent`
--
ALTER TABLE `Adherent`
  ADD CONSTRAINT `FK_Adherent_Id_Utilisateur` FOREIGN KEY (`Id_Utilisateur`) REFERENCES `Utilisateur` (`Id_Utilisateur`);

--
-- Contraintes pour la table `Charger`
--
ALTER TABLE `Charger`
  ADD CONSTRAINT `FK_Charger_Id_Role` FOREIGN KEY (`Id_Role`) REFERENCES `Role` (`Id_Role`),
  ADD CONSTRAINT `FK_Charger_Id_Tache` FOREIGN KEY (`Id_Tache`) REFERENCES `Tache` (`Id_Tache`),
  ADD CONSTRAINT `FK_Charger_Id_Utilisateur` FOREIGN KEY (`Id_Utilisateur`) REFERENCES `Utilisateur` (`Id_Utilisateur`),
  ADD CONSTRAINT `FK_Charger_Id_Voyage` FOREIGN KEY (`Id_Voyage`) REFERENCES `Voyage` (`Id_Voyage`);

--
-- Contraintes pour la table `Competiteur`
--
ALTER TABLE `Competiteur`
  ADD CONSTRAINT `FK_Competiteur_Id_Adherent` FOREIGN KEY (`Id_Adherent`) REFERENCES `Adherent` (`Id_Adherent`),
  ADD CONSTRAINT `FK_Competiteur_Id_Categorie` FOREIGN KEY (`Id_Categorie`) REFERENCES `Categorie` (`Id_Categorie`),
  ADD CONSTRAINT `FK_Competiteur_Id_Specialite` FOREIGN KEY (`Id_Specialite`) REFERENCES `Specialite` (`Id_Specialite`);

--
-- Contraintes pour la table `Competition`
--
ALTER TABLE `Competition`
  ADD CONSTRAINT `FK_Competition_Id_Club_Organisateur` FOREIGN KEY (`ID_Club_Organisateur`) REFERENCES `Club_Organisateur` (`Id_Club_Organisateur`),
  ADD CONSTRAINT `FK_Competition_Id_Sexe` FOREIGN KEY (`Id_Sexe`) REFERENCES `Sexe` (`Id_Sexe`),
  ADD CONSTRAINT `FK_Competition_Id_Type_Competition` FOREIGN KEY (`Id_Type_Competition`) REFERENCES `Type_Competition` (`Id_Type_Competition`);

--
-- Contraintes pour la table `Course`
--
ALTER TABLE `Course`
  ADD CONSTRAINT `FK_Course_Id_Categorie` FOREIGN KEY (`Id_Categorie`) REFERENCES `Categorie` (`Id_Categorie`),
  ADD CONSTRAINT `FK_Course_Id_Competition` FOREIGN KEY (`Id_Competition`) REFERENCES `Competition` (`Id_Competition`),
  ADD CONSTRAINT `FK_Course_Id_Type_Specialite` FOREIGN KEY (`Id_Type_Specialite`) REFERENCES `Type_Specialite` (`Id_Type_Specialite`);

--
-- Contraintes pour la table `Droits`
--
ALTER TABLE `Droits`
  ADD CONSTRAINT `FK_Droits_Id_Droit_Acces` FOREIGN KEY (`Id_Droit_Acces`) REFERENCES `Droit_Acces` (`Id_Droit_Acces`),
  ADD CONSTRAINT `FK_Droits_Id_Utilisateur` FOREIGN KEY (`Id_Utilisateur`) REFERENCES `Utilisateur` (`Id_Utilisateur`);

--
-- Contraintes pour la table `Envoie`
--
ALTER TABLE `Envoie`
  ADD CONSTRAINT `FK_Envoie_Id_Message` FOREIGN KEY (`Id_Message`) REFERENCES `Message` (`Id_Message`),
  ADD CONSTRAINT `FK_Envoie_Id_Utilisateur` FOREIGN KEY (`Id_Utilisateur`) REFERENCES `Utilisateur` (`Id_Utilisateur`);

--
-- Contraintes pour la table `Equipe`
--
ALTER TABLE `Equipe`
  ADD CONSTRAINT `FK_Equipe_Id_Type_Specialite` FOREIGN KEY (`Id_Type_Specialite`) REFERENCES `Type_Specialite` (`Id_Type_Specialite`);

--
-- Contraintes pour la table `Objectif`
--
ALTER TABLE `Objectif`
  ADD CONSTRAINT `FK_Objectif_Id_Competiteur` FOREIGN KEY (`Id_Competiteur`) REFERENCES `Competiteur` (`Id_Competiteur`),
  ADD CONSTRAINT `FK_Objectif_Id_Competition` FOREIGN KEY (`Id_Competition`) REFERENCES `Competition` (`Id_Competition`);

--
-- Contraintes pour la table `Palmares_Competiteur`
--
ALTER TABLE `Palmares_Competiteur`
  ADD CONSTRAINT `FK_Palmares_Competiteur_Id_Competiteur` FOREIGN KEY (`Id_Competiteur`) REFERENCES `Competiteur` (`Id_Competiteur`),
  ADD CONSTRAINT `FK_Palmares_Competiteur_Id_Course` FOREIGN KEY (`Id_Course`) REFERENCES `Course` (`Id_Course`);

--
-- Contraintes pour la table `Palmares_Equipe`
--
ALTER TABLE `Palmares_Equipe`
  ADD CONSTRAINT `FK_Palmares_Equipe_Id_Course` FOREIGN KEY (`Id_Course`) REFERENCES `Course` (`Id_Course`),
  ADD CONSTRAINT `FK_Palmares_Equipe_Id_Equipe` FOREIGN KEY (`Id_Equipe`) REFERENCES `Equipe` (`Id_Equipe`);

--
-- Contraintes pour la table `Parente`
--
ALTER TABLE `Parente`
  ADD CONSTRAINT `FK_Parente_Id_Enfant` FOREIGN KEY (`Id_Enfant`) REFERENCES `Adherent` (`Id_Adherent`),
  ADD CONSTRAINT `FK_Parente_Id_Parent` FOREIGN KEY (`Id_Parent`) REFERENCES `Utilisateur` (`Id_Utilisateur`);

--
-- Contraintes pour la table `Participant_Equipe`
--
ALTER TABLE `Participant_Equipe`
  ADD CONSTRAINT `FK_Participant_Equipe_Id_Competiteur` FOREIGN KEY (`Id_Competiteur`) REFERENCES `Competiteur` (`Id_Competiteur`),
  ADD CONSTRAINT `FK_Participant_Equipe_Id_Equipe` FOREIGN KEY (`Id_Equipe`) REFERENCES `Equipe` (`Id_Equipe`);

--
-- Contraintes pour la table `Participe_Competition_Equipe`
--
ALTER TABLE `Participe_Competition_Equipe`
  ADD CONSTRAINT `FK_Participe_Competition_Equipe_Id_Course` FOREIGN KEY (`Id_Course`) REFERENCES `Course` (`Id_Course`),
  ADD CONSTRAINT `FK_Participe_Competition_Equipe_Id_Equipe` FOREIGN KEY (`Id_Equipe`) REFERENCES `Equipe` (`Id_Equipe`);

--
-- Contraintes pour la table `Participe_Competition_Solo`
--
ALTER TABLE `Participe_Competition_Solo`
  ADD CONSTRAINT `FK_Participe_Competition_Solo_Id_Competiteur` FOREIGN KEY (`Id_Competiteur`) REFERENCES `Competiteur` (`Id_Competiteur`),
  ADD CONSTRAINT `FK_Participe_Competition_Solo_Id_Course` FOREIGN KEY (`Id_Course`) REFERENCES `Course` (`Id_Course`);

--
-- Contraintes pour la table `Participe_Voyage`
--
ALTER TABLE `Participe_Voyage`
  ADD CONSTRAINT `FK_Participe_Voyage_Id_Competiteur` FOREIGN KEY (`Id_Competiteur`) REFERENCES `Competiteur` (`Id_Competiteur`),
  ADD CONSTRAINT `FK_Participe_Voyage_Id_Type_Voyage` FOREIGN KEY (`Id_Type_Voyage`) REFERENCES `Type_Voyage` (`Id_Type_Voyage`),
  ADD CONSTRAINT `FK_Participe_Voyage_Id_Utilisateur` FOREIGN KEY (`Id_Utilisateur`) REFERENCES `Utilisateur` (`Id_Utilisateur`),
  ADD CONSTRAINT `FK_Participe_Voyage_Id_Voyage` FOREIGN KEY (`Id_Voyage`) REFERENCES `Voyage` (`Id_Voyage`);

--
-- Contraintes pour la table `Recois`
--
ALTER TABLE `Recois`
  ADD CONSTRAINT `FK_Recois_Id_Message` FOREIGN KEY (`Id_Message`) REFERENCES `Message` (`Id_Message`),
  ADD CONSTRAINT `FK_Recois_Id_Utilisateur` FOREIGN KEY (`Id_Utilisateur`) REFERENCES `Utilisateur` (`Id_Utilisateur`);

--
-- Contraintes pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD CONSTRAINT `FK_Utilisateur_Id_Sexe` FOREIGN KEY (`Id_Sexe`) REFERENCES `Sexe` (`Id_Sexe`);

--
-- Contraintes pour la table `Voyage`
--
ALTER TABLE `Voyage`
  ADD CONSTRAINT `FK_Voyage_Id_Competition` FOREIGN KEY (`Id_Competition`) REFERENCES `Competition` (`Id_Competition`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
