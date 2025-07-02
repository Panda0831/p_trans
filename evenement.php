<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Événements - Clubs ESMIA</title>
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
  /* Footer */
  footer {
    background-color: var(--primary-color);
    color: white;
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
        <li><a href="profil.php">profil</a></li>
          <li><a href="accueil.php">Accueil</a></li>
          <li><a href="#clubs">Clubs</a></li>
          <li><a href="nous.html">Qui sommes nous?</a></li>
          <li><a href="apropos.html">A propos</a></li>
         <li> <a href="login.php" class="btn">Connexion</a></li>
        </ul>
      </nav>
    </div>
  </header>

  
  <main style="flex:1; display:flex; align-items:center; justify-content:center;">
    <section style="width: 100%; max-width: 1100px; display: flex; flex-wrap: wrap; gap: 2rem; justify-content: center;">
      <!-- Card 1 -->
      <div style="background: white; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); width: 320px; overflow: hidden; display: flex; flex-direction: column;">
        <img src="./img/event1.jpg" alt="Hackathon ESMIA" style="width:100%; height:180px; object-fit:cover;">
        <div style="padding: 1.2rem;">
          <h3 style="color: var(--primary-color); margin-bottom: 0.5rem;">Hackathon ESMIA 2024</h3>
          <p style="margin-bottom: 0.7rem;">Participez à notre hackathon annuel et montrez vos talents en programmation et innovation !</p>
          <p style="font-size: 0.95rem; color: #666;">Date : 15 Juin 2024</p>
        </div>
      </div>
      <!-- Card 2 -->
      <div style="background: white; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); width: 320px; overflow: hidden; display: flex; flex-direction: column;">
        <img src="./img/event2.jpg" alt="Conférence IA" style="width:100%; height:180px; object-fit:cover;">
        <div style="padding: 1.2rem;">
          <h3 style="color: var(--primary-color); margin-bottom: 0.5rem;">Conférence sur l'Intelligence Artificielle</h3>
          <p style="margin-bottom: 0.7rem;">Découvrez les dernières avancées en IA avec des experts du domaine. Ouvert à tous les étudiants.</p>
          <p style="font-size: 0.95rem; color: #666;">Date : 22 Juin 2024</p>
        </div>
      </div>
      <!-- Card 3 -->
      <div style="background: white; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); width: 320px; overflow: hidden; display: flex; flex-direction: column;">
        <img src="./img/event3.jpg" alt="Journée Sportive" style="width:100%; height:180px; object-fit:cover;">
        <div style="padding: 1.2rem;">
          <h3 style="color: var(--primary-color); margin-bottom: 0.5rem;">Journée Sportive des Clubs</h3>
          <p style="margin-bottom: 0.7rem;">Rejoignez-nous pour une journée de sport, de fun et de cohésion entre les clubs de l'ESMIA.</p>
          <p style="font-size: 0.95rem; color: #666;">Date : 29 Juin 2024</p>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <ul style="list-style: none;">
        <p>Notre Equipe:</p><br>
        <li>@ 2025 ESMIA University</li>
        <li><a href ="https://github.com/nexus-tech5" style="color:white;">Nexus Tech</a></li>
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