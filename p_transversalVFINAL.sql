-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 27 juin 2025 à 05:31
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
-- Base de données : `p_transversal`
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

--
-- Déchargement des données de la table `CLUB`
--

INSERT INTO `CLUB` (`id_club`, `nom_club`, `description_club`, `domaine_club`, `date_reunion_hebdo_club`, `etudiant_id_etudiant`) VALUES
(1, 'cub_foot', 'club_foot', 'sport', NULL, NULL),
(2, 'club_danse', 'danse', 'danse', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `CLUB_ETUDIANT`
--

CREATE TABLE `CLUB_ETUDIANT` (
  `id_club` int NOT NULL,
  `id_etudiant` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `CLUB_ETUDIANT`
--

INSERT INTO `CLUB_ETUDIANT` (`id_club`, `id_etudiant`) VALUES
(2, 'ETU002'),
(2, 'ETU003'),
(2, 'ETU004'),
(2, 'ETU005'),
(2, 'ETU006');

-- --------------------------------------------------------

--
-- Structure de la table `COMMENTAIRE`
--

CREATE TABLE `COMMENTAIRE` (
  `id_commentaire` bigint NOT NULL,
  `contenu_commentaire` text,
  `id_evenement` int DEFAULT NULL
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
  `id_etudiant` varchar(10) NOT NULL,
  `nom_etudiant` varchar(20) DEFAULT NULL,
  `nie_etudiant` varchar(20) DEFAULT NULL,
  `prenom_etudiant` varchar(20) DEFAULT NULL,
  `filiere_etudiant` varchar(10) DEFAULT NULL,
  `niveau_etudiant` varchar(20) DEFAULT NULL,
  `classe_etudiant` varchar(20) DEFAULT NULL,
  `club_id_club` int DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email_etudiant` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ETUDIANT`
--

INSERT INTO `ETUDIANT` (`id_etudiant`, `nom_etudiant`, `nie_etudiant`, `prenom_etudiant`, `filiere_etudiant`, `niveau_etudiant`, `classe_etudiant`, `club_id_club`, `password`, `email_etudiant`) VALUES
('ETU001', 'Rafanomezantsoa', 'SE20242015', 'fanamby manjaka', 'SIO', 'L1', 'L1SIO1', NULL, '$2y$10$Y6zq2lUQveopmJwdZIlyuOaiGLN/85dWTbz4zawyIAATIblrESL..', 'fanambymanjaka9@gmail.com'),
('ETU002', 'rakotovao', 'SE20242018', 'joyce', 'SIO', 'L1', 'L1SIO1', NULL, '$2y$10$Z.N2i6Ufin8Os2aIv8gCg.i9le29c/6RefC.IMkH.QgwFvBLMZ4/C', 'joyce@gmail.com'),
('ETU003', 'wiwi', 'SE2024201', 'aimelie', 'SIO', 'L1', 'L1SIO1', NULL, '$2y$10$jAPM8aBUTKB4nNDb754NR.YNqyCLliesDUAW0AlvrUuqF0B9IxJmO', 'williatang7@gmail.com'),
('ETU004', 'ratsimba', 'SE20242017', 'andy', 'SIO', 'L1', 'L1SIO1', NULL, '$2y$10$eNYcacUxmwcIG7l2Lgcf9Ol3qH8VvhObnwZlKM.Ah3ikhPXUXdW8m', 'ratsimba74@gmail.com'),
('ETU005', 'Rafanomezantsoa', 'SE20242000', 'aimelie', 'SIO', 'L1', 'L1SIO1', NULL, '$2y$10$Fz1Sm441GqoGmiYc7Ipire2XUOgzFGA0.9aK3rIfWrD6n9fTjFA1u', 'willia@gmail.com'),
('ETU006', 'RAKOTOVAO', 'SE20240148', 'Joyce', 'SIO', 'L1', 'L1SIO1', NULL, '$2y$10$iJBY/nTuzzzW.qbPccww4OQQViCg33VeltRFZWZSVln98M59iTqla', 'joyceritchy3@gmail.com');

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
  `id_evenement` int NOT NULL
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
-- Déchargement des données de la table `S_inscrire`
--

INSERT INTO `S_inscrire` (`id_club`, `id_etudiant`, `date_inscription_etudiant`) VALUES
(2, 'ETU001', '2025-06-25'),
(2, 'ETU002', '2025-06-25'),
(2, 'ETU003', '2025-06-27'),
(2, 'ETU004', '2025-06-25'),
(2, 'ETU005', '2025-06-25'),
(2, 'ETU006', '2025-06-27');

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
-- Index pour la table `CLUB_ETUDIANT`
--
ALTER TABLE `CLUB_ETUDIANT`
  ADD PRIMARY KEY (`id_club`,`id_etudiant`),
  ADD KEY `id_etudiant` (`id_etudiant`);

--
-- Index pour la table `COMMENTAIRE`
--
ALTER TABLE `COMMENTAIRE`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `FK_COMMENTAIRE_evenement` (`id_evenement`);

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
  ADD PRIMARY KEY (`id_etudiant`),
  ADD KEY `FK_Participer_evenement` (`id_evenement`);

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
  MODIFY `id_club` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Contraintes pour la table `CLUB_ETUDIANT`
--
ALTER TABLE `CLUB_ETUDIANT`
  ADD CONSTRAINT `CLUB_ETUDIANT_ibfk_1` FOREIGN KEY (`id_club`) REFERENCES `CLUB` (`id_club`),
  ADD CONSTRAINT `CLUB_ETUDIANT_ibfk_2` FOREIGN KEY (`id_etudiant`) REFERENCES `ETUDIANT` (`id_etudiant`);

--
-- Contraintes pour la table `COMMENTAIRE`
--
ALTER TABLE `COMMENTAIRE`
  ADD CONSTRAINT `FK_COMMENTAIRE_evenement` FOREIGN KEY (`id_evenement`) REFERENCES `EVENEMENT` (`id_evenement`);

--
-- Contraintes pour la table `Envoyer`
--
ALTER TABLE `Envoyer`
  ADD CONSTRAINT `FK_Envoyer_message` FOREIGN KEY (`id_message`) REFERENCES `MESSAGE` (`id_message`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `FK_Participer_evenement` FOREIGN KEY (`id_evenement`) REFERENCES `EVENEMENT` (`id_evenement`);

--
-- Contraintes pour la table `Recevoir`
--
ALTER TABLE `Recevoir`
  ADD CONSTRAINT `FK_Recevoir_message` FOREIGN KEY (`id_message`) REFERENCES `MESSAGE` (`id_message`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Soumettre`
--
ALTER TABLE `Soumettre`
  ADD CONSTRAINT `FK_Soumettre_commentaire` FOREIGN KEY (`id_commentaire`) REFERENCES `COMMENTAIRE` (`id_commentaire`);

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
