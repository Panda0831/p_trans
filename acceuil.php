<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Clubs ESMIA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    :root {
      --primary-color: #090057e0;
      --secondary-color: #050b53;
      --text-color: #333;
      --light-bg: #f9f9f9;
    }
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Arial', sans-serif;
      line-height: 1.6;
      color: var(--text-color);
      background-color: var(--light-bg);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    header {
      background-color: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 15px 0;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .header-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    .logo {
      display: flex;
      align-items: center;
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
    nav ul {
      display: flex;
      list-style: none;
    }
    nav ul li {
      margin-left: 30px;
    }
    nav ul li a {
      text-decoration: none;
      color: var(--text-color);
      font-weight: 500;
      transition: color 0.3s;
    }
    nav ul li a:hover {
      color: var(--primary-color);
    }
    .main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 60px 20px 40px 20px;
      min-height: 60vh;
      text-align: center;
    }
    h1 {
      font-size: 3rem;
      font-weight: bold;
      margin-bottom: 10px;
      color: var(--primary-color);
    }
    h2 {
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 20px;
      color: var(--secondary-color);
    }
    p.paragraph {
      margin: 30px 0 20px 0;
      font-size: 1.1rem;
      text-transform: uppercase;
      font-weight: bold;
      letter-spacing: 1px;
      color: #444;
    }
    p.intro {
      font-size: 1.2rem;
      margin-bottom: 30px;
      color: #a09d0d;
    }
    .boutton {
      margin-top: 20px;
      padding: 12px 32px;
      background: linear-gradient(to right, #110338, #1b1364, #2a28c4);
      border: none;
      border-radius: 25px;
      color: rgb(206, 15, 231);
      font-weight: bold;
      font-size: 1.1rem;
      cursor: pointer;
      transition: background 0.3s, color 0.3s;
      display: inline-block;
      text-decoration: none;
      text-align: center;
    }
    .boutton:hover {
      background: linear-gradient(to right, #0d0a3c, #151a5a, #222a91);
      color: #fff;
    }
    footer {
      background-color: var(--primary-color);
      color: white;
      font-size: large;
      padding: 2cm 0.5cm;
      margin-top: 50px;
      display: flex;
      justify-content: center;
      gap: 5cm;
      align-items: center;
      flex-wrap: wrap;
      text-align: center;
    }
    footer ul {
      list-style: none;
      padding: 0;
      margin: 0;
      min-width: 150px;
    }
    footer ul p {
      margin-bottom: 10px;
      font-weight: bold;
      font-size: 1.1rem;
      opacity: 0.9;
    }
    footer li {
      opacity: 0.9;
      font-size: 0.9rem;
      margin-bottom: 6px;
    }
    @media (max-width: 900px) {
      .header-container, footer {
        flex-direction: column;
        gap: 1.5rem;
        padding: 1rem;
      }
      .main-content {
        padding: 30px 5px 20px 5px;
      }
      h1 { font-size: 2rem; }
      h2 { font-size: 1.2rem; }
      footer {
        gap: 1rem;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="header-container" role="banner">
      <div class="logo">
        <div class="logo-image"><img src="globe.png" alt="ESMIA University logo" /></div>
        <div class="logo-text"><a href="acceuil.php">ESMIA UNIVERSITY</a></div>
      </div>
      <nav role="navigation" aria-label="Menu principal">
        <ul>
          <li><a href="acceuil.php">Accueil</a></li>
          <li><a href="sosisy.php#clubs">Nos clubs</a></li>
          <li><a href="#">Événements</a></li>
          <li><a href="profil.php">Profil</a></li>
          <li><a href="login.php" class="boutton">Se connecter</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="main-content">
    <h1>Bienvenue</h1>
    <h2>sur notre site des AVE et nos <br /> clubs universitaires de l’ESMIA</h2>
    <p class="paragraph">
      Choisissez votre club et inscrivez-vous au plus tôt pour ne manquer aucun événement ni activité
    </p>
    <p class="intro">" VISONS PLUS HAUT ET ALLONS PLUS LOIN "</p>
    <a href="login.php" class="boutton">Se connecter</a>
  </main>

  <footer role="contentinfo">
    <ul>
      <p>Notre Équipe :</p>
      <li>@ 2025 ESMIA University</li>
      <li>Nexus Tech</li>
      <li>GROUPE 3 L1sio1</li>
    </ul>
    <ul>
      <p>Coordonnées :</p>
      <li>Facebook</li>
      <li>Instagram</li>
      <li>GitHub</li>
      <li>ESMIA University</li>
    </ul>
    <ul>
      <p>Les Responsables :</p>
      <li>AVE Président : Fanamby</li>
      <li>Secrétaire : Willia Tang</li>
      <li>Trésorier : Ryan</li>
      <li>Conseiller : Joyce</li>
    </ul>
  </footer>
</body>
</html>
