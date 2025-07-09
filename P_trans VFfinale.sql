-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 08 juil. 2025 à 20:03
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
-- Base de données : `P_trans`
--

-- --------------------------------------------------------

--
-- Structure de la table `ADMIN_CLUB`
--

CREATE TABLE `ADMIN_CLUB` (
  `id_club` int NOT NULL,
  `nie_etudiant` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ADMIN_CLUB`
--

INSERT INTO `ADMIN_CLUB` (`id_club`, `nie_etudiant`) VALUES
(2, 'SE20242015');

-- --------------------------------------------------------

--
-- Structure de la table `CLUB`
--

CREATE TABLE `CLUB` (
  `id_club` int NOT NULL,
  `nom_club` varchar(100) NOT NULL,
  `description_club` text NOT NULL,
  `domaine_club` varchar(50) NOT NULL,
  `date_reunion_hebdo_club` date DEFAULT NULL,
  `responsable_nie_etudiant` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `CLUB`
--

INSERT INTO `CLUB` (`id_club`, `nom_club`, `description_club`, `domaine_club`, `date_reunion_hebdo_club`, `responsable_nie_etudiant`) VALUES
(1, 'club_foot', 'club_foot', 'sport', NULL, 'SE20242015'),
(2, 'club_danse', 'danse', 'danse', NULL, 'SE20240148');

-- --------------------------------------------------------

--
-- Structure de la table `COMMENTAIRE`
--

CREATE TABLE `COMMENTAIRE` (
  `id_commentaire` bigint NOT NULL,
  `contenu_commentaire` text NOT NULL,
  `id_evenement` int NOT NULL,
  `nie_etudiant_auteur` varchar(20) NOT NULL,
  `date_commentaire` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ENVOI_MESSAGE`
--

CREATE TABLE `ENVOI_MESSAGE` (
  `id_message` int NOT NULL,
  `nie_etudiant_expediteur` varchar(20) NOT NULL,
  `date_envoi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ETUDIANT`
--

CREATE TABLE `ETUDIANT` (
  `nie_etudiant` varchar(20) NOT NULL,
  `nom_etudiant` varchar(50) NOT NULL,
  `prenom_etudiant` varchar(20) NOT NULL,
  `filiere_etudiant` varchar(20) NOT NULL,
  `niveau_etudiant` varchar(20) NOT NULL,
  `classe_etudiant` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_etudiant` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ETUDIANT`
--

INSERT INTO `ETUDIANT` (`nie_etudiant`, `nom_etudiant`, `prenom_etudiant`, `filiere_etudiant`, `niveau_etudiant`, `classe_etudiant`, `password`, `email_etudiant`) VALUES
('SE20240134', 'ANdrianarison', 'Andry Nirina Jacky', 'info', 'L1', 'SIO1', '$2y$10$8slOZzGshQ8UYpAbqKu9HeVvlkZfHHaRuN1rN0DGPFihVE.fKJEiW', 'rakotonirainyavotraryan@gmail.com'),
('SE20240148', 'RAKOTOVAO', 'Joyce', 'SIO', 'L1', 'L1SIO1', '$2y$10$iJBY/nTuzzzW.qbPccww4OQQViCg33VeltRFZWZSVln98M59iTqla', 'joyceritchy3@gmail.com'),
('SE20242015', 'Rafanomezantsoa', 'Fanamby Manjaka', 'SIO', 'L1', 'L1SIO1', '$2y$10$Y6zq2lUQveopmJwdZIlyuOaiGLN/85dWTbz4zawyIAATIblrESL..', 'fanambymanjaka9@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `EVENEMENT`
--

CREATE TABLE `EVENEMENT` (
  `id_evenement` int NOT NULL,
  `nom_evenement` varchar(100) NOT NULL,
  `date_evenement` date NOT NULL,
  `heure_evenement` time NOT NULL,
  `lieu_evenement` varchar(100) NOT NULL,
  `date_fin_inscription` date DEFAULT NULL,
  `id_club` int NOT NULL,
  `date_lancement_evenement` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `INSCRIPTION_CLUB`
--

CREATE TABLE `INSCRIPTION_CLUB` (
  `id_club` int NOT NULL,
  `nie_etudiant` varchar(20) NOT NULL,
  `date_inscription` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `INSCRIPTION_CLUB`
--

INSERT INTO `INSCRIPTION_CLUB` (`id_club`, `nie_etudiant`, `date_inscription`) VALUES
(2, 'SE20240148', '2025-06-27'),
(2, 'SE20242015', '2025-06-25');

-- --------------------------------------------------------

--
-- Structure de la table `MESSAGE`
--

CREATE TABLE `MESSAGE` (
  `id_message` int NOT NULL,
  `contenu_message` text NOT NULL,
  `objet_message` varchar(100) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `PARTICIPATION_EVENEMENT`
--

CREATE TABLE `PARTICIPATION_EVENEMENT` (
  `nie_etudiant` varchar(20) NOT NULL,
  `id_evenement` int NOT NULL,
  `date_participation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `RECEPTION_MESSAGE`
--

CREATE TABLE `RECEPTION_MESSAGE` (
  `id_message` int NOT NULL,
  `nie_etudiant_destinataire` varchar(20) NOT NULL,
  `date_reception` datetime DEFAULT NULL,
  `lu` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ADMIN_CLUB`
--
ALTER TABLE `ADMIN_CLUB`
  ADD PRIMARY KEY (`id_club`,`nie_etudiant`),
  ADD KEY `FK_ADMIN_CLUB_ETUDIANT` (`nie_etudiant`);

--
-- Index pour la table `CLUB`
--
ALTER TABLE `CLUB`
  ADD PRIMARY KEY (`id_club`),
  ADD KEY `FK_CLUB_ETUDIANT` (`responsable_nie_etudiant`);

--
-- Index pour la table `COMMENTAIRE`
--
ALTER TABLE `COMMENTAIRE`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `FK_COMMENTAIRE_EVENEMENT` (`id_evenement`),
  ADD KEY `FK_COMMENTAIRE_ETUDIANT` (`nie_etudiant_auteur`);

--
-- Index pour la table `ENVOI_MESSAGE`
--
ALTER TABLE `ENVOI_MESSAGE`
  ADD PRIMARY KEY (`id_message`,`nie_etudiant_expediteur`),
  ADD KEY `FK_ENVOI_MESSAGE_ETUDIANT` (`nie_etudiant_expediteur`);

--
-- Index pour la table `ETUDIANT`
--
ALTER TABLE `ETUDIANT`
  ADD PRIMARY KEY (`nie_etudiant`),
  ADD UNIQUE KEY `UQ_ETUDIANT_EMAIL` (`email_etudiant`);

--
-- Index pour la table `EVENEMENT`
--
ALTER TABLE `EVENEMENT`
  ADD PRIMARY KEY (`id_evenement`),
  ADD KEY `FK_EVENEMENT_CLUB` (`id_club`);

--
-- Index pour la table `INSCRIPTION_CLUB`
--
ALTER TABLE `INSCRIPTION_CLUB`
  ADD PRIMARY KEY (`id_club`,`nie_etudiant`),
  ADD KEY `FK_INSCRIPTION_CLUB_ETUDIANT` (`nie_etudiant`);

--
-- Index pour la table `MESSAGE`
--
ALTER TABLE `MESSAGE`
  ADD PRIMARY KEY (`id_message`);

--
-- Index pour la table `PARTICIPATION_EVENEMENT`
--
ALTER TABLE `PARTICIPATION_EVENEMENT`
  ADD PRIMARY KEY (`nie_etudiant`,`id_evenement`),
  ADD KEY `FK_PARTICIPATION_EVENEMENT_EVENEMENT` (`id_evenement`);

--
-- Index pour la table `RECEPTION_MESSAGE`
--
ALTER TABLE `RECEPTION_MESSAGE`
  ADD PRIMARY KEY (`id_message`,`nie_etudiant_destinataire`),
  ADD KEY `FK_RECEPTION_MESSAGE_ETUDIANT` (`nie_etudiant_destinataire`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `CLUB`
--
ALTER TABLE `CLUB`
  MODIFY `id_club` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- Contraintes pour la table `ADMIN_CLUB`
--
ALTER TABLE `ADMIN_CLUB`
  ADD CONSTRAINT `FK_ADMIN_CLUB_CLUB` FOREIGN KEY (`id_club`) REFERENCES `CLUB` (`id_club`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ADMIN_CLUB_ETUDIANT` FOREIGN KEY (`nie_etudiant`) REFERENCES `ETUDIANT` (`nie_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `CLUB`
--
ALTER TABLE `CLUB`
  ADD CONSTRAINT `FK_CLUB_ETUDIANT` FOREIGN KEY (`responsable_nie_etudiant`) REFERENCES `ETUDIANT` (`nie_etudiant`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `COMMENTAIRE`
--
ALTER TABLE `COMMENTAIRE`
  ADD CONSTRAINT `FK_COMMENTAIRE_ETUDIANT` FOREIGN KEY (`nie_etudiant_auteur`) REFERENCES `ETUDIANT` (`nie_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_COMMENTAIRE_EVENEMENT` FOREIGN KEY (`id_evenement`) REFERENCES `EVENEMENT` (`id_evenement`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ENVOI_MESSAGE`
--
ALTER TABLE `ENVOI_MESSAGE`
  ADD CONSTRAINT `FK_ENVOI_MESSAGE_ETUDIANT` FOREIGN KEY (`nie_etudiant_expediteur`) REFERENCES `ETUDIANT` (`nie_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ENVOI_MESSAGE_MESSAGE` FOREIGN KEY (`id_message`) REFERENCES `MESSAGE` (`id_message`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `EVENEMENT`
--
ALTER TABLE `EVENEMENT`
  ADD CONSTRAINT `FK_EVENEMENT_CLUB` FOREIGN KEY (`id_club`) REFERENCES `CLUB` (`id_club`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `INSCRIPTION_CLUB`
--
ALTER TABLE `INSCRIPTION_CLUB`
  ADD CONSTRAINT `FK_INSCRIPTION_CLUB_CLUB` FOREIGN KEY (`id_club`) REFERENCES `CLUB` (`id_club`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_INSCRIPTION_CLUB_ETUDIANT` FOREIGN KEY (`nie_etudiant`) REFERENCES `ETUDIANT` (`nie_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `PARTICIPATION_EVENEMENT`
--
ALTER TABLE `PARTICIPATION_EVENEMENT`
  ADD CONSTRAINT `FK_PARTICIPATION_EVENEMENT_ETUDIANT` FOREIGN KEY (`nie_etudiant`) REFERENCES `ETUDIANT` (`nie_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PARTICIPATION_EVENEMENT_EVENEMENT` FOREIGN KEY (`id_evenement`) REFERENCES `EVENEMENT` (`id_evenement`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `RECEPTION_MESSAGE`
--
ALTER TABLE `RECEPTION_MESSAGE`
  ADD CONSTRAINT `FK_RECEPTION_MESSAGE_ETUDIANT` FOREIGN KEY (`nie_etudiant_destinataire`) REFERENCES `ETUDIANT` (`nie_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_RECEPTION_MESSAGE_MESSAGE` FOREIGN KEY (`id_message`) REFERENCES `MESSAGE` (`id_message`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
