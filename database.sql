DROP TABLE IF EXISTS Recevoir;
DROP TABLE IF EXISTS Envoyer;
DROP TABLE IF EXISTS Participer;
DROP TABLE IF EXISTS Soumettre;
DROP TABLE IF EXISTS `S'inscrire`;
DROP TABLE IF EXISTS COMMENTAIRE;
DROP TABLE IF EXISTS MESSAGE;
DROP TABLE IF EXISTS EVENEMENT;
DROP TABLE IF EXISTS ETUDIANT;
DROP TABLE IF EXISTS CLUB;

CREATE TABLE CLUB (
    id_club INT AUTO_INCREMENT PRIMARY KEY,
    nom_club TEXT,
    description_club TEXT,
    domaine_club TEXT,
    date_reunion_hebdo_club DATE,
    etudiant_id_etudiant VARCHAR(10)
);

CREATE TABLE ETUDIANT (
    id_etudiant VARCHAR(10) PRIMARY KEY,
    nom_etudiant VARCHAR(20),
    prenom_etudiant VARCHAR(20),
    filiere_etudiant VARCHAR(10),
    niveau_etudiant VARCHAR(20),
    classe_etudiant VARCHAR(20),
    club_id_club INT
);

CREATE TABLE EVENEMENT (
    id_evenement INT AUTO_INCREMENT PRIMARY KEY,
    nom_evenement TEXT,
    date_evenement DATE,
    heure_evenement TIME,
    lieu_evenement VARCHAR(100),
    date_fin_inscription DATE,
    id_club INT,
    date_lancement_evenement DATE UNIQUE
);

CREATE TABLE MESSAGE (
    id_message INT AUTO_INCREMENT PRIMARY KEY,
    contenu_message TEXT,
    objet_message VARCHAR(100)
);

CREATE TABLE COMMENTAIRE (
    id_commentaire BIGINT AUTO_INCREMENT PRIMARY KEY,
    contenu_commentaire TEXT,
    date_lancement_evenement DATE
);

CREATE TABLE `S'inscrire` (
    id_club INT NOT NULL,
    id_etudiant VARCHAR(10) NOT NULL,
    date_inscription_etudiant DATE,
    PRIMARY KEY (id_club, id_etudiant)
);

CREATE TABLE Soumettre (
    id_etudiant VARCHAR(10) NOT NULL,
    id_commentaire BIGINT NOT NULL,
    date_soumission_commentaire DATE,
    heure_soumission_commentaire TIME,
    PRIMARY KEY (id_etudiant, id_commentaire)
);

CREATE TABLE Envoyer (
    id_message INT NOT NULL,
    id_etudiant VARCHAR(10) NOT NULL,
    date_envoie_message DATE,
    heure_envoie_message TIME,
    PRIMARY KEY (id_message, id_etudiant)
);

CREATE TABLE Recevoir (
    id_message INT NOT NULL,
    id_etudiant VARCHAR(10) NOT NULL,
    date_reception_message DATE,
    heure_reception_message TIME,
    PRIMARY KEY (id_message, id_etudiant)
);

CREATE TABLE Participer (
    id_etudiant VARCHAR(10) NOT NULL,
    date_lancement_evenement DATE NOT NULL,
    PRIMARY KEY (id_etudiant, date_lancement_evenement)
);

-- Contraintes étrangères
ALTER TABLE CLUB ADD CONSTRAINT FK_CLUB_etudiant FOREIGN KEY (etudiant_id_etudiant) REFERENCES ETUDIANT (id_etudiant);
ALTER TABLE ETUDIANT ADD CONSTRAINT FK_ETUDIANT_club FOREIGN KEY (club_id_club) REFERENCES CLUB (id_club);
ALTER TABLE EVENEMENT ADD CONSTRAINT FK_EVENEMENT_club FOREIGN KEY (id_club) REFERENCES CLUB (id_club);
ALTER TABLE COMMENTAIRE ADD CONSTRAINT FK_COMMENTAIRE_evenement FOREIGN KEY (date_lancement_evenement) REFERENCES EVENEMENT (date_lancement_evenement);
ALTER TABLE `S'inscrire` ADD CONSTRAINT FK_Sinscrire_club FOREIGN KEY (id_club) REFERENCES CLUB (id_club);
ALTER TABLE `S'inscrire` ADD CONSTRAINT FK_Sinscrire_etudiant FOREIGN KEY (id_etudiant) REFERENCES ETUDIANT (id_etudiant);
ALTER TABLE Soumettre ADD CONSTRAINT FK_Soumettre_etudiant FOREIGN KEY (id_etudiant) REFERENCES ETUDIANT (id_etudiant);
ALTER TABLE Soumettre ADD CONSTRAINT FK_Soumettre_commentaire FOREIGN KEY (id_commentaire) REFERENCES COMMENTAIRE (id_commentaire);
ALTER TABLE Envoyer ADD CONSTRAINT FK_Envoyer_message FOREIGN KEY (id_message) REFERENCES MESSAGE (id_message);
ALTER TABLE Envoyer ADD CONSTRAINT FK_Envoyer_etudiant FOREIGN KEY (id_etudiant) REFERENCES ETUDIANT (id_etudiant);
ALTER TABLE Recevoir ADD CONSTRAINT FK_Recevoir_message FOREIGN KEY (id_message) REFERENCES MESSAGE (id_message);
ALTER TABLE Recevoir ADD CONSTRAINT FK_Recevoir_etudiant FOREIGN KEY (id_etudiant) REFERENCES ETUDIANT (id_etudiant);
ALTER TABLE Participer ADD CONSTRAINT FK_Participer_etudiant FOREIGN KEY (id_etudiant) REFERENCES ETUDIANT (id_etudiant);
ALTER TABLE Participer ADD CONSTRAINT FK_Participer_evenement FOREIGN KEY (date_lancement_evenement) REFERENCES EVENEMENT (date_lancement_evenement);

