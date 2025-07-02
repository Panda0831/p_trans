
<?php
session_start();

$error = '';

try {
    $base = new PDO('mysql:host=localhost;dbname=p_transversal', 'root', 'Doja1390');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!empty($_POST["nie"]) && !empty($_POST["password"])) {
            $nie = htmlspecialchars(trim($_POST["nie"]));
            $password = trim($_POST["password"]);

            $query = $base->prepare("SELECT * FROM ETUDIANT WHERE nie_etudiant = ?");
            $query->execute([$nie]);
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['id_etudiant'] = $user['id_etudiant'];
                $_SESSION['nom_etudiant'] = $user['nom_etudiant'];
                header("Location: profil.php");
                exit();
            } else {
                $error = "❌ Identifiant ou mot de passe incorrect.";
            }
        } else {
            $error = "⚠️ Veuillez remplir tous les champs.";
        }
    }
} catch (PDOException $e) {
    $error = "Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Connexion - ESMIA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
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
      display: flex;
      flex-direction: column;
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
    .main-content {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 3rem 1rem 2rem 1rem;
    }
    .form-container {
      background: rgba(255,255,255,0.09);
      padding: 2.5rem 2rem 2rem 2rem;
      border-radius: 1.5rem;
      box-shadow: var(--shadow);
      max-width: 400px;
      width: 100%;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      align-items: stretch;
    }
    .form-container h1 {
      color: var(--accent);
      margin-bottom: 1.5rem;
      text-align: center;
      font-size: 2rem;
      font-weight: 700;
    }
    .input-group {
      margin-bottom: 1.5rem;
      text-align: left;
    }
    .input-group label {
      display: block;
      margin-bottom: 8px;
      color: var(--accent);
      font-weight: 600;
    }
    .input-group input {
      width: 100%;
      padding: 10px 15px;
      border: 1px solid #bfc6e6;
      border-radius: 8px;
      background-color: #f0f0f0;
      color: #222;
      font-size: 1rem;
      box-sizing: border-box;
      transition: border 0.2s;
    }
    .input-group input:focus {
      outline: none;
      border: 1.5px solid var(--accent);
      background-color: #fff;
    }
    .btn-group {
      display: flex;
      gap: 18px;
      margin-top: 18px;
    }
    .btn-group button,
    .btn-group a {
      flex: 1;
      padding: 12px;
      border-radius: 8px;
      background: var(--accent);
      color: #fff;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      text-align: center;
      text-decoration: none;
      line-height: 1.3;
      border: none;
      transition: background 0.3s;
      display: inline-block;
    }
    .btn-group button:hover,
    .btn-group a:hover {
      background: var(--accent-light);
      color: var(--main-bg);
    }
    .error-message {
      color: #e74c3c;
      margin-top: 10px;
      text-align: center;
      font-weight: bold;
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
      .form-container {
        padding: 1.5rem 0.5rem;
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
  <div class="main-content">
    <form class="form-container" action="" method="post" novalidate>
      <h1>Connexion</h1>
      <div class="input-group">
        <label for="nie">Identifiant :</label>
        <input type="text" id="nie" name="nie" placeholder="Entrez votre NIE" required value="<?= isset($_POST['nie']) ? htmlspecialchars($_POST['nie']) : '' ?>">
      </div>
      <div class="input-group">
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
      </div>
      <div class="btn-group">
        <a href="inscription.php">S'inscrire</a>
        <button type="submit">Se connecter</button>
      </div>
      <?php if ($error): ?>
        <div class="error-message"><?= $error ?></div>
      <?php endif; ?>
    </form>
  </div>
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