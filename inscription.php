
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription - Clubs ESMIA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 0;
    }
    .container {
      background: rgba(255,255,255,0.09);
      padding: 40px 32px;
      border-radius: 16px;
      box-shadow: var(--shadow);
      max-width: 500px;
      width: 100%;
      margin: 0 auto;
      color: var(--text);
    }
    .container h1 {
      font-size: 2rem;
      color: var(--accent);
      margin-bottom: 5px;
      text-align: center;
    }
    .container h2 {
      font-size: 1rem;
      color: var(--accent-light);
      margin-bottom: 30px;
      font-weight: normal;
      text-align: center;
    }
    .form-group {
      margin-bottom: 20px;
      text-align: left;
    }
    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: var(--accent);
      font-weight: 600;
    }
    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background-color: #f0f0f0;
      color: #000;
      font-size: 0.95rem;
      box-sizing: border-box;
    }
    .form-group input:focus {
      outline: none;
      border: 1.5px solid var(--accent);
      background-color: #fff;
    }
    .submit-btn {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 10px;
      background: var(--accent);
      color: #fff;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }
    .submit-btn:hover {
      background: var(--accent-light);
      color: var(--main-bg);
    }
    @media (max-width: 900px) {
      .header-container, footer {
        flex-direction: column;
        gap: 1.5rem;
        padding: 1rem;
      }
      .main-content {
        padding: 20px 5px;
      }
      .container {
        padding: 20px 8px;
      }
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
    @media (max-width: 700px) {
      .header-container {
        flex-direction: column;
        gap: 1rem;
      }
      .main-content {
        padding: 1rem 0.5rem;
      }
      .container {
        padding: 1rem 0.5rem;
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
    <div class="container">
      <h1>Formulaire</h1>
      <h2>Inscription</h2>
      <form method="post" action="inscription.php">
        <div class="form-group">
          <label for="nom">Nom :</label>
          <input type="text" id="nom" name="nom" required>
        </div>
        <div class="form-group">
          <label for="prenom">Prénom :</label>
          <input type="text" id="prenom" name="prenom" required>
        </div>
        <div class="form-group">
          <label for="email">Email :</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="nie">NIE :</label>
          <input type="text" id="nie" name="nie" required>
        </div>
        <div class="form-group">
          <label for="password">Mot de passe :</label>
          <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
          <label for="confirm_password">Confirmer le mot de passe :</label>
          <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <div class="form-group">
          <label for="filiere">Filière :</label>
          <input type="text" id="filiere" name="filiere">
        </div>
        <div class="form-group">
          <label for="niveau">Niveau :</label>
          <input type="text" id="niveau" name="niveau">
        </div>
        <div class="form-group">
          <label for="classe">Classe :</label>
          <input type="text" id="classe" name="classe">
        </div>
        <button type="submit" class="submit-btn">S'inscrire</button>
      </form>
    </div>
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