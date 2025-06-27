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
    <link rel="stylesheet" href="back.css">
    <link rel="stylesheet" href="./fontawesome/css/all.css">
    <style>
        footer {
            background-color: blue;
            color: #222;
            font-size: large;
            padding: 2cm;
            justify-content: center;
            gap: 5cm;
            align-items: center;
            margin-top: 50px;
            display: flex;
        }
        footer li { 
            opacity: 0.9;
            font-size: 0.9rem;
        }
        * {
            font-family: 'Segoe UI', 'Trebuchet MS', Arial, sans-serif;
            color: #222;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: linear-gradient(120deg,rgb(102, 115, 163) 0%,rgb(240, 237, 237) 100%);
            min-height: 100vh;
        }
        section {
            width: 90vw;
            margin: 3vw auto;
            background: rgba(168, 155, 155, 0);
            border-radius: 1vw;
            box-shadow: 0 4px 16px 0 rgba(31, 38, 135, 0.10);
            padding: 3vw 4vw 4vw 4vw;
        }
        .d1 {
            display: flex;
            align-items: center;
            gap: 1vw;
            margin-bottom: 1vw;
        }
        .d1 i {
            font-size: 2vw;
            color: #3a5fcf;
            filter: none;
        }
        .d1 h1 {
            font-size: 1.7vw;
            letter-spacing: 0.1vw;
            font-weight: bold;
            color:rgb(179, 185, 203);
            text-shadow: none;
        }
        hr {
            border: none;
            border-top: 2px solid #bfc6e6;
            width: 60%;
            border-radius: 1vw;
        }
        .main-content {
            display: flex;
            flex-wrap: wrap;
            gap: 2vw;
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
            font-size: 2.2vw;
            color: #3a5fcf;
            margin-bottom: 1vw;
            font-family: 'Caveat', cursive, Arial, sans-serif;
        }
        .left p {
            font-size: 1.2vw;
            margin-bottom: 1vw;
            color: floralwhite;
            line-height: 1.5;
        }
        .styled-label {
            font-size: 1vw;
            margin-bottom: 0.5vw;
            color: #3a5fcf;
        }
        .styled-input {
            font-size: 1vw;
            padding: 0.5vw 1vw;
            border-radius: 1vw;
            border: 1px solid #bfc6e6;
            margin-bottom: 1vw;
            background:rgba(225, 226, 230, 0.04);
            color: #222;
        }
        .left button {
            width: 12vw;
            height: 2.8vw;
            font-size: 1.1vw;
            border-radius: 1vw;
            background: linear-gradient(90deg, #bfc6e6 0%,rgb(43, 62, 117) 100%);
            border: none;
            color: #fff;
            font-weight: bold;
            box-shadow: 0 1px 4px #bfc6e655;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, transform 0.2s;
        }
        .left button:hover {
            background: #3a5fcf;
            color: #fff;
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
            background: rgba(186, 200, 240, 0.18);
            border-radius: 1vw;
            box-shadow: 0 2px 8px 0 rgba(58,95,207,0.08);
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
            background:rgb(30, 43, 95);
            color:rgb(247, 247, 247);
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
            box-shadow: 0 1px 6pxrgba(55, 65, 110, 0.53);
        }
        @media (max-width: 900px) {
            .main-content {
                flex-direction: column;
                align-items: center;
            }
            .left, .right {
                width: 100%;
                padding: 0;
            }
            .dance-card {
                width: 80vw;  .logo-image img {
      height: 50px;
      margin-right: 15px;
    }
    
    .logo-text {
      font-weight: bold;
      font-size: 1.5rem;
      color: var(--primary-color);
    }
                min-width: unset;
                margin-bottom: 2vw;
            }
            .left h2, .left p, .left button {
                font-size: 4vw;
            }
        }
        .error-message {
            color: red;
            margin-top: 1rem;
            font-weight: bold;
            text-align: center;
        }
        footer {
      background-color: var(--primary-color);
      color: white;
      font-size: large;
      padding: 2cm 1rem;
      margin-top: 50px;
      width: 100vw;
      max-width: 100%;
      box-sizing: border-box;
      display: flex;
      justify-content: center;
      gap: 5cm;
      align-items: flex-start;
      flex-wrap: wrap;
    }

    footer ul {
      flex: 1 1 220px;
      min-width: 200px;
      margin: 0 1rem;
    }

    footer li {
      opacity: 0.9;
      font-size: 0.9rem;
    }

    @media (max-width: 900px) {
      footer {
      flex-direction: column;
      gap: 1.5rem;
      align-items: stretch;
      padding: 2rem 0.5rem;
      }
      footer ul {
      margin: 0.5rem 0;
      }
    }
      .logo-image img {
      height: 50px;
      margin-right: 15px;
    }
    
    .logo-text {
      font-weight: bold;
      font-size: 1.5rem;
      color: var(--primary-color);
    }
    </style>
</head>
<body?>
    <div class="d1">
        <i class="fa fa-globe"></i>
        <div class="logo-image"><img src="globe.png" alt="ESMIA University"></div>
        <h1>ESMIA UNIVERSITY</h1>
    </div>
    <hr>
    <section>
        <div class="main-content">
            <div class="left">
                <h2>Envie de Danser ?</h2>
                <p class="white-text">Inscrivez-vous ici</p>
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
                <div>
                    <p style="color: #fff;">Lorem ipsum dolor sit amet consectetur adipisicing elit...</p>
                </div>
            </div>
        </div>
    </section>
<footer>
    <ul style="list-style: none;">
        <p>Notre Equipe:</p><br>
        <li>@ 2025 ESMIA University</li>
        <li>Nexus Tech</li>
        <li>GROUPE 3 L1sio1</li>
    </ul>
    <ul style="list-style: none; text-decoration: none;">
        <p>Coordonnées:</p><br>
        <li style="color: inherit; text-decoration: none;"> facebook</li>
        <li style="color: inherit; text-decoration: none;">Instagram</li>
        <li style="color: inherit; text-decoration: none;">Git Hub</li>
        <li style="color: inherit; text-decoration: none;">Esmia University</li>
    </ul>
    <ul style="list-style: none;">
        <p>Les Résponsables :</p><br>
        <li>AVE President : Fanamby</li>
        <li> Secretaire : Willia Tang</li>
        <li>Trésorier : Ryan</li>
        <li>Conseiller : Joyce</li>
    </ul>
    </footer>

</body>
</html>
