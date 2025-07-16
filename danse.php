<?php
session_start();

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["nie"])) {
    $nie = trim(htmlspecialchars($_POST["nie"]));
    $id_club_danse = 2;

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=p_transversal;charset=utf8mb4', 'root', 'Doja1390', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Chercher l'étudiant par NIE
        $stmt = $pdo->prepare("SELECT id_etudiant FROM ETUDIANT WHERE nie_etudiant = ?");
        $stmt->execute([$nie]);
        $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($etudiant) {
            $id_etudiant = $etudiant['id_etudiant'];

            // Inscription dans S_inscrire (évite doublon avec INSERT IGNORE)
            $inscrire = $pdo->prepare("
                INSERT IGNORE INTO S_inscrire (id_club, id_etudiant, date_inscription_etudiant) 
                VALUES (?, ?, CURDATE())
            ");
            $inscrire->execute([$id_club_danse, $id_etudiant]);

            // Insertion aussi dans CLUB_ETUDIANT (selon ta base)
            $insertClubEtudiant = $pdo->prepare("
                INSERT IGNORE INTO CLUB_ETUDIANT (id_club, id_etudiant) 
                VALUES (?, ?)
            ");
            $insertClubEtudiant->execute([$id_club_danse, $id_etudiant]);

            // Mémoriser l'étudiant en session
            $_SESSION['id_etudiant'] = $id_etudiant;

            // Redirection vers profil.php
            header("Location: profil.php");
            exit();

        } else {
            $error_message = "NIE non trouvé dans la base.";
        }
    } catch (PDOException $e) {
        $error_message = "Erreur de base de données : " . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="/view/css/danse.css">
    <title>Club de Danse - ESMIA</title>

    <link rel="stylesheet" href="danse.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <div class="logo-image"><img src="./img/globe.webp" alt="ESMIA University"></div>
                <div class="logo-text">ESMIA UNIVERSITY</div>
            </div>
            <nav>
                <ul>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href="accueil.php">Accueil</a></li>
                    <li><a href="accueil.php#clubs">Clubs</a></li>
                    <li><a href="nous.php">Qui sommes nous?</a></li>
                    <li><a href="evenement.php">Événements</a></li>
                    <li><a href="apropos.php">À propos</a></li>
                    <li><a href="login.php" class="btn">Connexion</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section class="hero">
        <h1>Club de Danse</h1>
        <p>
            Rejoins le club de danse de l'ESMIA !<br>
            Découvre et pratique différents styles lors d'ateliers et de spectacles.<br>
            Inscris-toi et exprime ta passion sur scène !
        </p>
    </section>
    <section>
        <div class="main-content">
            <div class="left">
                <h2>Envie de Danser ?</h2>
                <p>Inscrivez-vous ici</p>
                <form method="post">
                    <label for="nie" class="styled-label">NIE</label>
                    <input type="text" id="nie" name="nie" class="styled-input" placeholder="Votre NIE" required>
                    <button type="submit">S'inscrire</button>
                </form>
                <?php if (!empty($error_message)): ?>
                    <div class="error-message"><?= $error_message ?></div>
                <?php endif; ?>
            </div>
            <div class="right">
                <div class="dance-card">
                    <p>Danse urbaine</p>
                    <img src="./img/danse.webp" alt="Danse urbaine">
                </div>
                <div class="dance-card">
                    <p>Zumba</p>
                    <img src="./img/danse.webp" alt="Zumba">
                </div>
                <div class="dance-card">
                    <p>Classique</p>
                    <img src="./img/danse.webp" alt="Danse classique">
                </div>
            </div>
        </div>
    </section>
    <footer>
        <ul>
            <p>Notre Équipe :</p>
            <li>@ 2025 ESMIA University</li>
            <li><a href="https://github.com/nexus-tech5">Nexus Tech</a></li>
            <li>GROUPE 3 L1sio1</li>
        </ul>
        <ul>
            <p>Coordonnées :</p>
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Instagram</a></li>
            <li><a href="#">GitHub</a></li>
            <li>Esmia University</li>
        </ul>
        <ul>
            <p>Les Responsables :</p>
            <li>Président : Fanamby</li>
            <li>Secrétaire : Willia Tang</li>
            <li>Trésorier : Ryan</li>
            <li>Conseiller : Joyce</li>
        </ul>
    </footer>
</body>
</html>