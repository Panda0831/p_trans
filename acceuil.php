<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Clubs ESMIA</title>
  <style>
    *{
      margin: auto;
      padding: auto;
      top: 0px;
      bottom: auto

    }
    body {
      margin: 0;
      padding: 0;
      font-family: 'Arial', sans-serif;
      background-image: url('89781.jpg');
      color:rgb(197, 212, 215);
    }

    .header {
      padding: 20px 40px;
      position: relative;
    }

    .logo-container {
      width: 9cm; /* Longueur du trait et de la zone d’animation */
      overflow: hidden;
      margin-left: 2cm; /* Aligner avec le titre "Bienvenue" */
    }

    .logo-text {
      font-weight: bold;
      margin-left: 1cm;
      font-size: 18px;
      white-space: nowrap;
      animation: slide-logo 6s linear infinite;
    }

    .logo-line {
      width: 10cm;
      height: 2px;
      background-color: #721072;
      margin-top: 6px;
    }


    

    .content {
      padding: 60px 40px;
    }

    h1 {
      font-size: 90px;
      font-weight: bold;
      margin: 0;
      padding-left: 2cm;
    }

    h2 {
      font-size: 32px;
      font-weight: 600;
      margin-top: 10px;
      padding-left: 2cm;
    }

    .paragraph {
      margin-left: 1cm;
      margin-top: 2cm;
      font-size: 14px;
      text-transform: uppercase;
      font-weight: bold;
      letter-spacing: 1px;
    }

    .intro {
      font-size: 18px;
      margin-top: 60px;
      margin-left: 1cm;
      color: #a09d0d;
    }

    .boutton {
      margin-top: 1cm;
      margin-left: 1cm;
      padding: 12px 24px;
      background: linear-gradient(to right, #110338, #1b1364, #2a28c4);
      border: none;
      border-radius: 25px;
      color: rgb(206, 15, 231);
      font-weight: bold;
      cursor: pointer;
    }

    .boutton:hover {
      background-color: #1a1abf;
    }
  </style>
</head>
<body>
  <div class="header">
    <div class="logo-container">
      <div class="logo-text">ESMIA UNIVERSITY</div>
      <div class="logo-line"></div>
    </div>
  </div>

  <div class="content">
    <h1>Bienvenue</h1>
    <h2>sur notre site des AVE et nos <br> clubs universitaires de l’ESMIA</h2>

    <div class="paragraph">
      CHOISISSEZ VOTRE CLUB ET INSCRIVEZ-VOUS AU PLUS <br><br>
      VITE POUR NE MANQUER AUCUN ÉVÉNEMENT NI ACTIVITÉ
    </div>

    <div class="intro">" VISONS PLUS HAUT ET ALLONS PLUS LOIN "</div>

    <a href="#"><button class="boutton"> se connecter</button></a>
    
  </div>
</body>
</html>