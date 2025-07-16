
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clubs ESMIA - Inscription</title>
 <link rel="stylesheet" href="acceuill.css">
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <div class="logo-image"><img src="./img/globe.png" alt="ESMIA University"></div>
        <div class="logo-text">ESMIA UNIVERSITY</div>
      </div>
      <nav>
        <ul>
          <li><a href="accueil.php">Accueil</a></li>
          <li><a href="#clubs">Clubs</a></li>
          <li><a href="evenement.php">Événements</a></li>
          <li><a href="nous.php">Qui sommes nous?</a></li>
          <li><a href="apropos.php">À propos</a></li>
          <li>
            <?php if (isset($_SESSION['id_etudiant'])): ?>
               <a href="deconnexion.php" class="btn">Se deconnecter</a>
            <?php else: ?>
              <a href="login.php" class="btn">Se connecter</a>
            <?php endif; ?>
            
          </li>
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
          <div class="club-image" style="background-image: url('./img/basket.webp');"></div>
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
            <a href="/clubs/danse.php" class="btn">Voir plus</a>
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
        setTimeout(updateNav,100);
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
