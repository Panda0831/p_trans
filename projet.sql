-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 22 juin 2025 à 15:31
-- Version du serveur : 8.0.42-0ubuntu0.24.04.1
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `CLUB`
--

CREATE TABLE `CLUB` (
  `id_club` int NOT NULL,
  `nom_club` text,
  `description_club` text,
  `domaine_club` text,
  `date_reunion_hebdo_club` date DEFAULT NULL,
  `etudiant_id_etudiant` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `COMMENTAIRE`
--

CREATE TABLE `COMMENTAIRE` (
  `id_commentaire` bigint NOT NULL,
  `contenu_commentaire` text,
  `date_lancement_evenement` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Envoyer`
--

CREATE TABLE `Envoyer` (
  `id_message` int NOT NULL,
  `id_etudiant` varchar(10) NOT NULL,
  `date_envoie_message` date DEFAULT NULL,
  `heure_envoie_message` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ETUDIANT`
--

CREATE TABLE `ETUDIANT` (
  `id_etudiant` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nom_etudiant` varchar(255) DEFAULT NULL,
  `nie_etudiant` varchar(20) DEFAULT NULL,
  `prenom_etudiant` varchar(255) DEFAULT NULL,
  `filiere_etudiant` varchar(10) DEFAULT NULL,
  `niveau_etudiant` varchar(20) DEFAULT NULL,
  `classe_etudiant` varchar(20) DEFAULT NULL,
  `email_etudiant` varchar(100) DEFAULT NULL,
  `club_id_club` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ETUDIANT`
--

INSERT INTO `ETUDIANT` (`id_etudiant`, `nom_etudiant`, `nie_etudiant`, `prenom_etudiant`, `filiere_etudiant`, `niveau_etudiant`, `classe_etudiant`, `email_etudiant`, `club_id_club`) VALUES
('ETU68581acbe5ab8', 'fanamby', '200', 'manjaka', 'SIO', 'L1', 'L1SIO1', 'fanambymanjaka9@gmail.com', NULL),
('ETU68581b8ce353c', 'tang', 'SE20242001', 'willia', 'SIO', 'L1', 'L1SIO1', 'williatang7@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `EVENEMENT`
--

CREATE TABLE `EVENEMENT` (
  `id_evenement` int NOT NULL,
  `nom_evenement` text,
  `date_evenement` date DEFAULT NULL,
  `heure_evenement` time DEFAULT NULL,
  `lieu_evenement` varchar(100) DEFAULT NULL,
  `date_fin_inscription` date DEFAULT NULL,
  `id_club` int DEFAULT NULL,
  `date_lancement_evenement` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `MESSAGE`
--

CREATE TABLE `MESSAGE` (
  `id_message` int NOT NULL,
  `contenu_message` text,
  `objet_message` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Participer`
--

CREATE TABLE `Participer` (
  `id_etudiant` varchar(10) NOT NULL,
  `date_lancement_evenement` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Recevoir`
--

CREATE TABLE `Recevoir` (
  `id_message` int NOT NULL,
  `id_etudiant` varchar(10) NOT NULL,
  `date_reception_message` date DEFAULT NULL,
  `heure_reception_message` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Soumettre`
--

CREATE TABLE `Soumettre` (
  `id_etudiant` varchar(10) NOT NULL,
  `id_commentaire` bigint NOT NULL,
  `date_soumission_commentaire` date DEFAULT NULL,
  `heure_soumission_commentaire` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `S_inscrire`
--

CREATE TABLE `S_inscrire` (
  `id_club` int NOT NULL,
  `id_etudiant` varchar(10) NOT NULL,
  `date_inscription_etudiant` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `CLUB`
--
ALTER TABLE `CLUB`
  ADD PRIMARY KEY (`id_club`),
  ADD KEY `FK_CLUB_etudiant` (`etudiant_id_etudiant`);

--
-- Index pour la table `COMMENTAIRE`
--
ALTER TABLE `COMMENTAIRE`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `FK_COMMENTAIRE_evenement` (`date_lancement_evenement`);

--
-- Index pour la table `Envoyer`
--
ALTER TABLE `Envoyer`
  ADD PRIMARY KEY (`id_message`,`id_etudiant`),
  ADD KEY `FK_Envoyer_etudiant` (`id_etudiant`);

--
-- Index pour la table `ETUDIANT`
--
ALTER TABLE `ETUDIANT`
  ADD PRIMARY KEY (`id_etudiant`),
  ADD KEY `FK_ETUDIANT_club` (`club_id_club`);

--
-- Index pour la table `EVENEMENT`
--
ALTER TABLE `EVENEMENT`
  ADD PRIMARY KEY (`id_evenement`),
  ADD UNIQUE KEY `date_lancement_evenement` (`date_lancement_evenement`),
  ADD KEY `FK_EVENEMENT_club` (`id_club`);

--
-- Index pour la table `MESSAGE`
--
ALTER TABLE `MESSAGE`
  ADD PRIMARY KEY (`id_message`);

--
-- Index pour la table `Participer`
--
ALTER TABLE `Participer`
  ADD PRIMARY KEY (`id_etudiant`,`date_lancement_evenement`),
  ADD KEY `FK_Participer_evenement` (`date_lancement_evenement`);

--
-- Index pour la table `Recevoir`
--
ALTER TABLE `Recevoir`
  ADD PRIMARY KEY (`id_message`,`id_etudiant`),
  ADD KEY `FK_Recevoir_etudiant` (`id_etudiant`);

--
-- Index pour la table `Soumettre`
--
ALTER TABLE `Soumettre`
  ADD PRIMARY KEY (`id_etudiant`,`id_commentaire`),
  ADD KEY `FK_Soumettre_commentaire` (`id_commentaire`);

--
-- Index pour la table `S_inscrire`
--
ALTER TABLE `S_inscrire`
  ADD PRIMARY KEY (`id_club`,`id_etudiant`),
  ADD KEY `FK_Sinscrire_etudiant` (`id_etudiant`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `CLUB`
--
ALTER TABLE `CLUB`
  MODIFY `id_club` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `COMMENTAIRE`
--
ALTER TABLE `COMMENTAIRE`
  MODIFY `id_commentaire` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `EVENEMENT`
--
ALTER TABLE `EVENEMENT`
  MODIFY `id_evenement` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `MESSAGE`
--
ALTER TABLE `MESSAGE`
  MODIFY `id_message` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `CLUB`
--
ALTER TABLE `CLUB`
  ADD CONSTRAINT `FK_CLUB_etudiant` FOREIGN KEY (`etudiant_id_etudiant`) REFERENCES `ETUDIANT` (`id_etudiant`);

--
-- Contraintes pour la table `COMMENTAIRE`
--
ALTER TABLE `COMMENTAIRE`
  ADD CONSTRAINT `FK_COMMENTAIRE_evenement` FOREIGN KEY (`date_lancement_evenement`) REFERENCES `EVENEMENT` (`date_lancement_evenement`);

--
-- Contraintes pour la table `Envoyer`
--
ALTER TABLE `Envoyer`
  ADD CONSTRAINT `FK_Envoyer_etudiant` FOREIGN KEY (`id_etudiant`) REFERENCES `ETUDIANT` (`id_etudiant`),
  ADD CONSTRAINT `FK_Envoyer_message` FOREIGN KEY (`id_message`) REFERENCES `MESSAGE` (`id_message`);

--
-- Contraintes pour la table `ETUDIANT`
--
ALTER TABLE `ETUDIANT`
  ADD CONSTRAINT `FK_ETUDIANT_club` FOREIGN KEY (`club_id_club`) REFERENCES `CLUB` (`id_club`);

--
-- Contraintes pour la table `EVENEMENT`
--
ALTER TABLE `EVENEMENT`
  ADD CONSTRAINT `FK_EVENEMENT_club` FOREIGN KEY (`id_club`) REFERENCES `CLUB` (`id_club`);

--
-- Contraintes pour la table `Participer`
--
ALTER TABLE `Participer`
  ADD CONSTRAINT `FK_Participer_etudiant` FOREIGN KEY (`id_etudiant`) REFERENCES `ETUDIANT` (`id_etudiant`),
  ADD CONSTRAINT `FK_Participer_evenement` FOREIGN KEY (`date_lancement_evenement`) REFERENCES `EVENEMENT` (`date_lancement_evenement`);

--
-- Contraintes pour la table `Recevoir`
--
ALTER TABLE `Recevoir`
  ADD CONSTRAINT `FK_Recevoir_etudiant` FOREIGN KEY (`id_etudiant`) REFERENCES `ETUDIANT` (`id_etudiant`),
  ADD CONSTRAINT `FK_Recevoir_message` FOREIGN KEY (`id_message`) REFERENCES `MESSAGE` (`id_message`);

--
-- Contraintes pour la table `Soumettre`
--
ALTER TABLE `Soumettre`
  ADD CONSTRAINT `FK_Soumettre_commentaire` FOREIGN KEY (`id_commentaire`) REFERENCES `COMMENTAIRE` (`id_commentaire`),
  ADD CONSTRAINT `FK_Soumettre_etudiant` FOREIGN KEY (`id_etudiant`) REFERENCES `ETUDIANT` (`id_etudiant`);

--
-- Contraintes pour la table `S_inscrire`
--
ALTER TABLE `S_inscrire`
  ADD CONSTRAINT `FK_Sinscrire_club` FOREIGN KEY (`id_club`) REFERENCES `CLUB` (`id_club`),
  ADD CONSTRAINT `FK_Sinscrire_etudiant` FOREIGN KEY (`id_etudiant`) REFERENCES `ETUDIANT` (`id_etudiant`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
