<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>AVE BASKET</title>
  <style>
    :root {
      --primary-color: #721072;
      --hover-color: #007BFF;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: url('kobe-terrain.jpg') no-repeat center center fixed;
  background-size: cover;
  position: relative;
      color: white;
    }
   

    .header {
      padding: 20px 40px;
    }

    .logo-container {
      width: 100%;
      max-width: 500px;
      overflow: hidden;
      margin-left: 1cm;
    }

    .logo-text {
      font-weight: bold;
      font-size: 22px;
      white-space: nowrap;
      color: white;
     
    }

    

    .logo-line {
      width: 100%;
      height: 2px;
      background-color: var(--primary-color);
      margin-top: 6px;
    }

    nav {
      display: flex;
      justify-content: flex-end;
      margin-right: 4cm;
      margin-top: -1.5cm;
    }

    nav ul {
      display: flex;
      list-style: none;
      padding: 0;
      margin: 0;
    }

    nav ul li {
      margin-left: 30px;
    }

    nav ul li a {
      text-decoration: none;
      color: white;
      font-weight: 500;
      transition: color 0.3s ease;
      cursor: pointer;
    }

    nav ul li a:hover {
      color: var(--hover-color);
      
    }

    .kobe {
     
        
      margin-top: 6cm;
  margin-left: 9cm;
  font-size: 20px;
  text-shadow: 1px 1px 4px black;
  background: rgba(0, 0, 0, 0.10);
  padding: 20px;
  border-radius: 10px;
  max-width: 500px;
    }

    .interesse {
      margin-left: 9cm;
      margin-top: 20px;
    }

    .interesse button {
      height: 40px;
      width: 150px;
      text-transform: uppercase;
      font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
      font-size: 16px;
      background-color: #f0f0f0;
      border-radius: 5px;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
       background-color: var(--primary-color);
  color: white;
  box-shadow: 0 2px 6px rgba(0,0,0,0.5);
    }

    .interesse button:hover {
      background-color: var(--hover-color);
      color: white;
      transform: scale(1.05);
    }

    @media (max-width: 768px) {
      .kobe,
      .interesse {
         margin-left: 1cm;
    margin-right: 1cm;
    text-align: center;
      }

      nav {
        justify-content: center;
        margin-right: 0;
      }
    }
    .globe {
  margin-right: 10px;
}

  </style>
</head>

<body>
  <div class="header">
    <div class="logo-container">
      <div class="logo-text">
      <span class="globe">🌐</span> ESMIA UNIVERSITY
      </div>
      <div class="logo-line"></div>
    </div>
  </div>

  <nav>
    <ul>
      <li><a href="#">Accueil</a></li>
      <li><a href="#clubs">Clubs</a></li>
      <li><a href="#">Événements</a></li>
      <li><a href="#">Contact</a></li>
      <li><a href="#">Connexion</a></li>
    </ul>
  </nav>

  <div>
    <h3 class="kobe">"If you are going to be a leader, you are not going to please everybody."<br>- KOBE BRYANT</h3>
  </div>

  <div class="interesse">
   <a href="basket_page2.php"> <button>Intéressé ?</button></a>
  </div>
</body>

</html>
