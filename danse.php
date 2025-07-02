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
    <title>Club de Danse - ESMIA</title>
    <style>
        :root {
            --main-bg: #181c2f;
            --accent: #6c63ff;
            --accent-light: #a7a3ff;
            --white: #fff;
            --gray: #e5e7ef;
            --text: #232946;
            --shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
        }
        body {
            background: linear-gradient(120deg, var(--main-bg) 60%, var(--accent-light) 100%);
            font-family: 'Segoe UI', 'Arial', sans-serif;
            color: var(--white);
            margin: 0;
            min-height: 100vh;
        }
        header {
            background: rgba(24,28,47,0.95);
            box-shadow: var(--shadow);
            padding: 0.5rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .logo-image img {
            height: 48px;
            border-radius: 12px;
            box-shadow: 0 2px 8px #0002;
            background: var(--white);
            padding: 4px;
        }
        .logo-text {
            font-weight: 700;
            font-size: 1.6rem;
            letter-spacing: 2px;
            color: var(--accent);
            text-shadow: 0 2px 8px #0002;
        }
        nav ul {
            display: flex;
            gap: 2rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        nav ul li a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: background 0.2s, color 0.2s;
        }
        nav ul li a.btn {
            background: var(--accent);
            color: var(--white);
            font-weight: bold;
            box-shadow: 0 2px 8px #6c63ff44;
        }
        nav ul li a:hover, nav ul li a.btn:hover {
            background: var(--accent-light);
            color: var(--main-bg);
        }
        .hero {
            background: linear-gradient(100deg, var(--accent) 60%, var(--main-bg) 100%);
            padding: 3rem 2rem 2rem 2rem;
            text-align: center;
            border-radius: 0 0 2rem 2rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }
        .hero h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: var(--white);
            letter-spacing: 1px;
            text-shadow: 0 2px 8px #0003;
        }
        .hero p {
            font-size: 1.1rem;
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto 1rem auto;
            line-height: 1.7;
        }
        .main-content {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 2rem;
            background: rgba(255,255,255,0.07);
            border-radius: 1.5rem;
            box-shadow: var(--shadow);
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: space-between;
        }
        .left {
            flex: 1 1 320px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 2vw;
        }
        .left h2 {
            font-size: 2rem;
            color: var(--accent);
            margin-bottom: 1vw;
            font-family: 'Caveat', cursive, Arial, sans-serif;
        }
        .left p {
            font-size: 1.1rem;
            margin-bottom: 1vw;
            color: var(--white);
            line-height: 1.5;
        }
        .styled-label {
            font-size: 1rem;
            margin-bottom: 0.5vw;
            color: var(--accent);
        }
        .styled-input {
            font-size: 1rem;
            padding: 0.5vw 1vw;
            border-radius: 1vw;
            border: 1px solid #bfc6e6;
            margin-bottom: 1vw;
            background:rgba(225, 226, 230, 0.04);
            color: #222;
        }
        .left button {
            width: 180px;
            height: 40px;
            font-size: 1.1rem;
            border-radius: 1vw;
            background: linear-gradient(90deg, #bfc6e6 0%, var(--accent) 100%);
            border: none;
            color: #fff;
            font-weight: bold;
            box-shadow: 0 1px 4px #bfc6e655;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, transform 0.2s;
        }
        .left button:hover {
            background: var(--accent-light);
            color: var(--main-bg);
            transform: scale(1.03);
        }
        .right {
            flex: 2 1 480px;
            display: flex;
            gap: 2vw;
            justify-content: center;
            align-items: flex-end;
        }
        .dance-card {
            background: var(--white);
            color: var(--text);
            border-radius: 1vw;
            box-shadow: var(--shadow);
            padding: 1vw;
            width: 15vw;
            min-width: 180px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        .dance-card p {
            position: absolute;
            top: 1vw;
            left: 1vw;
            background: var(--accent);
            color: var(--white);
            font-size: 1vw;
            font-weight: bold;
            padding: 0.3vw 0.8vw;
            border-radius: 0.7vw;
            box-shadow: none;
        }
        .dance-card img {
            width: 100%;
            height: 10vw;
            object-fit: cover;
            border-radius: 0.7vw;
            margin-top: 2vw;
            box-shadow: 0 1px 6px rgba(55, 65, 110, 0.13);
        }
        .error-message {
            color: #e74c3c;
            margin-top: 1rem;
            font-weight: bold;
            text-align: center;
        }
        footer {
            background: var(--main-bg);
            color: var(--gray);
            padding: 2.5rem 2rem 2rem 2rem;
            margin-top: 3rem;
            border-radius: 2rem 2rem 0 0;
            box-shadow: 0 -2px 16px #0002;
            display: flex;
            flex-wrap: wrap;
            gap: 3rem;
            justify-content: center;
            font-size: 1rem;
        }
        footer ul {
            list-style: none;
            padding: 0;
            margin: 0;
            min-width: 180px;
        }
        footer p {
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 0.5rem;
        }
        footer li, footer a {
            color: var(--gray);
            text-decoration: none;
            margin-bottom: 0.3rem;
            display: block;
            opacity: 0.95;
            transition: color 0.2s;
        }
        footer a:hover {
            color: var(--accent-light);
            text-decoration: underline;
        }
        @media (max-width: 900px) {
            .header-container, .main-content {
                padding: 0 1rem;
            }
            .dance-card {
                min-width: 160px;
                max-width: 160px;
            }
            .main-content {
                flex-direction: column;
                gap: 1.5rem;
            }
        }
        @media (max-width: 700px) {
            .header-container {
                flex-direction: column;
                gap: 1rem;
            }
            .main-content {
                padding: 1rem 0.5rem;
            }
            .dance-card {
                min-width: 90vw;
                max-width: 90vw;
            }
            footer {
                flex-direction: column;
                gap: 1.5rem;
                border-radius: 1.2rem 1.2rem 0 0;
            }
        }
    </style>
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
                    <li><a href="nous.html">Qui sommes nous?</a></li>
                    <li><a href="evenement.php">Événements</a></li>
                    <li><a href="apropos.html">À propos</a></li>
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
                    <img src="./images.jpeg" alt="Danse urbaine">
                </div>
                <div class="dance-card">
                    <p>Zumba</p>
                    <img src="zumba.png" alt="Zumba">
                </div>
                <div class="dance-card">
                    <p>Classique</p>
                    <img src="danse_classique.jpg" alt="Danse classique">
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