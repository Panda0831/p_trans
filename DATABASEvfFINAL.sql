-- DATABASEvfFINAL.sql
-- Version finale propre, claire, évolutive avec bonnes pratiques SQL
-- PK_... = Primary Key, FK_... = Foreign Key, commentaires 'teto novaiko kely'

-- =========================
-- Table: ETUDIANT
-- =========================
CREATE TABLE ETUDIANT (
    nie_etudiant VARCHAR(20) PRIMARY KEY COMMENT 'PK_ETUDIANT', -- teto novaiko kely
    nom_etudiant VARCHAR(255),
    prenom_etudiant VARCHAR(255),
    filiere_etudiant VARCHAR(10),
    niveau_etudiant VARCHAR(20),
    classe_etudiant VARCHAR(20),
    email_etudiant VARCHAR(100)
);

-- =========================
-- Table: CLUB
-- =========================
CREATE TABLE CLUB (
    id_club INT AUTO_INCREMENT PRIMARY KEY COMMENT 'PK_CLUB', -- teto novaiko kely
    nom_club TEXT,
    description_club TEXT,
    domaine_club TEXT,
    date_reunion_hebdo_club DATE DEFAULT NULL
);

-- =========================
-- Table: Admin_Club
-- =========================
CREATE TABLE Admin_Club (
    id_club INT,
    nie_etudiant VARCHAR(20),
    PRIMARY KEY (id_club, nie_etudiant),
    CONSTRAINT FK_AdminClub_CLUB FOREIGN KEY (id_club) REFERENCES CLUB(id_club),
    CONSTRAINT FK_AdminClub_ETUDIANT FOREIGN KEY (nie_etudiant) REFERENCES ETUDIANT(nie_etudiant)
); -- teto novaiko kely

-- =========================
-- Table: S_inscrire (membres du club)
-- =========================
CREATE TABLE S_inscrire (
    id_club INT,
    nie_etudiant VARCHAR(20),
    date_inscription_etudiant DATE,
    PRIMARY KEY (id_club, nie_etudiant),
    CONSTRAINT FK_Sinscrire_CLUB FOREIGN KEY (id_club) REFERENCES CLUB(id_club),
    CONSTRAINT FK_Sinscrire_ETUDIANT FOREIGN KEY (nie_etudiant) REFERENCES ETUDIANT(nie_etudiant)
);

-- =========================
-- Table: EVENEMENT
-- =========================
CREATE TABLE EVENEMENT (
    id_evenement INT AUTO_INCREMENT PRIMARY KEY COMMENT 'PK_EVENEMENT', -- teto novaiko kely
    nom_evenement TEXT,
    date_evenement DATE,
    heure_evenement TIME,
    lieu_evenement VARCHAR(100),
    date_fin_inscription DATE,
    date_lancement_evenement DATE UNIQUE, -- pour liens avec COMMENTAIRE & Participer
    id_club INT,
    CONSTRAINT FK_EVENEMENT_CLUB FOREIGN KEY (id_club) REFERENCES CLUB(id_club)
);

-- =========================
-- Table: COMMENTAIRE
-- =========================
CREATE TABLE COMMENTAIRE (
    id_commentaire BIGINT AUTO_INCREMENT PRIMARY KEY COMMENT 'PK_COMMENTAIRE', -- teto novaiko kely
    contenu_commentaire TEXT,
    date_lancement_evenement DATE,
    CONSTRAINT FK_COMMENTAIRE_EVENEMENT FOREIGN KEY (date_lancement_evenement) REFERENCES EVENEMENT(date_lancement_evenement)
);

-- =========================
-- Table: MESSAGE
-- =========================
CREATE TABLE MESSAGE (
    id_message INT AUTO_INCREMENT PRIMARY KEY COMMENT 'PK_MESSAGE', -- teto novaiko kely
    contenu_message TEXT,
    objet_message VARCHAR(100)
);

-- =========================
-- Table: Envoyer (étudiant qui envoie un message)
-- =========================
CREATE TABLE Envoyer (
    id_message INT,
    nie_etudiant VARCHAR(20),
    date_envoie_message DATE,
    heure_envoie_message TIME,
    PRIMARY KEY (id_message, nie_etudiant),
    CONSTRAINT FK_Envoyer_MESSAGE FOREIGN KEY (id_message) REFERENCES MESSAGE(id_message),
    CONSTRAINT FK_Envoyer_ETUDIANT FOREIGN KEY (nie_etudiant) REFERENCES ETUDIANT(nie_etudiant)
);

-- =========================
-- Table: Recevoir (message reçu par un membre)
-- =========================
CREATE TABLE Recevoir (
    id_message INT,
    nie_etudiant VARCHAR(20),
    date_reception_message DATE,
    heure_reception_message TIME,
    PRIMARY KEY (id_message, nie_etudiant),
    CONSTRAINT FK_Recevoir_MESSAGE FOREIGN KEY (id_message) REFERENCES MESSAGE(id_message),
    CONSTRAINT FK_Recevoir_ETUDIANT FOREIGN KEY (nie_etudiant) REFERENCES ETUDIANT(nie_etudiant)
);

-- =========================
-- Table: Participer (participation à un événement)
-- =========================
CREATE TABLE Participer (
    nie_etudiant VARCHAR(20),
    date_lancement_evenement DATE,
    PRIMARY KEY (nie_etudiant, date_lancement_evenement),
    CONSTRAINT FK_Participer_ETUDIANT FOREIGN KEY (nie_etudiant) REFERENCES ETUDIANT(nie_etudiant),
    CONSTRAINT FK_Participer_EVENEMENT FOREIGN KEY (date_lancement_evenement) REFERENCES EVENEMENT(date_lancement_evenement)
); -- teto novaiko kely

-- =========================
-- Table: Soumettre (commentaire par un membre)
-- =========================
CREATE TABLE Soumettre (
    nie_etudiant VARCHAR(20),
    id_commentaire BIGINT,
    date_soumission_commentaire DATE,
    heure_soumission_commentaire TIME,
    PRIMARY KEY (nie_etudiant, id_commentaire),
    CONSTRAINT FK_Soumettre_ETUDIANT FOREIGN KEY (nie_etudiant) REFERENCES ETUDIANT(nie_etudiant),
    CONSTRAINT FK_Soumettre_COMMENTAIRE FOREIGN KEY (id_commentaire) REFERENCES COMMENTAIRE(id_commentaire)
);
