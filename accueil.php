<?php // Nouveau style moderne pour la page d'accueil des clubs ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clubs ESMIA - Inscription</title>
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
      padding: 4rem 2rem 3rem 2rem;
      text-align: center;
      border-radius: 0 0 2rem 2rem;
      box-shadow: var(--shadow);
      margin-bottom: 2rem;
    }
    .hero h1 {
      font-size: 2.8rem;
      font-weight: 800;
      margin-bottom: 1rem;
      color: var(--white);
      letter-spacing: 1px;
      text-shadow: 0 2px 8px #0003;
    }
    .hero p {
      font-size: 1.2rem;
      color: var(--gray);
      max-width: 700px;
      margin: 0 auto 1rem auto;
      line-height: 1.7;
    }

    .clubs-container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 2rem;
    }
    .section-title {
      text-align: center;
      font-size: 2rem;
      font-weight: 700;
      color: var(--accent);
      margin-bottom: 2.5rem;
      letter-spacing: 1px;
      text-shadow: 0 2px 8px #0002;
    }
    .carousel-container {
      display: flex;
      align-items: center;
      gap: 1rem;
      position: relative;
    }
    .carousel-nav {
      background: var(--accent);
      color: var(--white);
      border: none;
      border-radius: 50%;
      width: 44px;
      height: 44px;
      font-size: 1.5rem;
      cursor: pointer;
      box-shadow: 0 2px 8px #6c63ff44;
      transition: background 0.2s, color 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .carousel-nav:disabled {
      background: #444a;
      color: #ccc;
      cursor: not-allowed;
    }
    .club-cards {
      display: flex;
      gap: 2rem;
      overflow-x: auto;
      scroll-behavior: smooth;
      padding-bottom: 1rem;
      scrollbar-width: thin;
      scrollbar-color: var(--accent) var(--main-bg);
    }
    .club-card {
      background: var(--white);
      color: var(--text);
      border-radius: 1.2rem;
      min-width: 320px;
      max-width: 320px;
      box-shadow: var(--shadow);
      display: flex;
      flex-direction: column;
      transition: transform 0.2s, box-shadow 0.2s;
      border: 2px solid transparent;
      position: relative;
    }
    .club-card:hover {
      transform: translateY(-8px) scale(1.03);
      box-shadow: 0 8px 32px 0 rgba(108,99,255,0.18);
      border-color: var(--accent);
    }
    .club-image {
      height: 180px;
      background-size: cover;
      background-position: center;
      border-radius: 1.2rem 1.2rem 0 0;
      border-bottom: 2px solid var(--gray);
    }
    .club-info {
      padding: 1.5rem;
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .club-info h3 {
      color: var(--accent);
      font-size: 1.3rem;
      margin-bottom: 0.5rem;
      font-weight: 700;
      letter-spacing: 1px;
    }
    .club-info p {
      color: #444;
      font-size: 1rem;
      margin-bottom: 1.2rem;
      flex: 1;
    }
    .btn {
      background: var(--accent);
      color: var(--white);
      padding: 0.6rem 1.2rem;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: background 0.2s, color 0.2s;
      border: none;
      cursor: pointer;
      box-shadow: 0 2px 8px #6c63ff33;
      display: inline-block;
      text-align: center;
    }
    .btn:hover {
      background: var(--accent-light);
      color: var(--main-bg);
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
      .header-container, .clubs-container {
        padding: 0 1rem;
      }
      .club-card {
        min-width: 260px;
        max-width: 260px;
      }
      .carousel-container {
        gap: 0.5rem;
      }
    }
    @media (max-width: 700px) {
      .header-container {
        flex-direction: column;
        gap: 1rem;
      }
      .clubs-container {
        padding: 0 0.5rem;
      }
      .carousel-nav {
        width: 36px;
        height: 36px;
        font-size: 1.1rem;
      }
      .club-card {
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
          <li><a href="#clubs">Clubs</a></li>
          <li><a href="nous.html">Qui sommes nous?</a></li>
          <li><a href="evenement.php">Événements</a></li>
          <li><a href="apropos.html">À propos</a></li>
          <li><a href="login.php" class="btn">Connexion</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <section class="hero">
    <h1>Découvre les clubs ESMIA</h1>
    <p>
      Rejoins une communauté dynamique et passionnée !<br>
      Développe tes talents, partage tes passions, et vis des expériences inoubliables au sein de nos clubs universitaires.
    </p>
    <p>
      Sport, culture, technologie, entraide... Il y a un club pour chacun.<br>
      Inscris-toi et fais vibrer ta vie étudiante !
    </p>
  </section>
  <section id="clubs" class="clubs-container">
    <h2 class="section-title">Nos clubs disponibles</h2>
    <div class="carousel-container">
      <button class="carousel-nav prev">&lt;</button>
      <div class="club-cards">
        <div class="club-card">
          <div class="club-image" style="background-image: url('./img/event.webp');"></div>
          <div class="club-info">
            <h3>Club Événements</h3>
            <p>Anime la vie du campus en organisant des événements festifs, culturels et solidaires.</p>
            <a href="#" class="btn">Voir plus</a>
          </div>
        </div>
        <div class="club-card">
          <div class="club-image" style="background-image: url('img/basket.webp');"></div>
          <div class="club-info">
            <h3>Club Basket</h3>
            <p>Entraînements, matchs et tournois pour tous les passionnés de basketball.</p>
            <a href="basket_page.php" class="btn">Voir plus</a>
          </div>
        </div>
        <div class="club-card">
          <div class="club-image" style="background-image: url('./img/foot.webp');"></div>
          <div class="club-info">
            <h3>Club Football</h3>
            <p>Participe à des matchs, tournois et séances d'entraînement dans une ambiance conviviale.</p>
            <a href="#" class="btn">Voir plus</a>
          </div>
        </div>
        <div class="club-card">
          <div class="club-image" style="background-image: url('./img/danse.webp');"></div>
          <div class="club-info">
            <h3>Club Danse</h3>
            <p>Découvre et pratique différents styles de danse lors d'ateliers et de spectacles.</p>
            <a href="danse.php" class="btn">Voir plus</a>
          </div>
        </div>
        <div class="club-card">
          <div class="club-image" style="background-image: url('./img/theatre.webp');"></div>
          <div class="club-info">
            <h3>Club Théâtre</h3>
            <p>Improvisation, mise en scène et représentations théâtrales pour révéler ton talent d'acteur.</p>
            <a href="#" class="btn">Voir plus</a>
          </div>
        </div>
        <div class="club-card">
          <div class="club-image" style="background-image: url('./img/club_musique.webp');"></div>
          <div class="club-info">
            <h3>Club Musique</h3>
            <p>Joue, chante, compose et partage ta passion lors de répétitions et de concerts.</p>
            <a href="#" class="btn">Voir plus</a>
          </div>
        </div>
      </div>
      <button class="carousel-nav next">&gt;</button>
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
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const carousel = document.querySelector('.club-cards');
      const cards = document.querySelectorAll('.club-card');
      const prevBtn = document.querySelector('.prev');
      const nextBtn = document.querySelector('.next');
      let scrollAmount = 0;
      const cardWidth = cards[0].offsetWidth + 32; // width + gap

      function updateNav() {
        prevBtn.disabled = carousel.scrollLeft <= 0;
        nextBtn.disabled = carousel.scrollLeft + carousel.offsetWidth >= carousel.scrollWidth - 1;
      }

      prevBtn.addEventListener('click', function() {
        carousel.scrollBy({ left: -cardWidth, behavior: 'smooth' });
        setTimeout(updateNav, 100);
      });
      nextBtn.addEventListener('click', function() {
        carousel.scrollBy({ left: cardWidth, behavior: 'smooth' });
        setTimeout(updateNav, 400);
      });
      carousel.addEventListener('scroll', updateNav);
      window.addEventListener('resize', updateNav);
      updateNav();
    });
  </script>
</body>
</html>
