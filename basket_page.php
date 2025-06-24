<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>AVE BASKET</title>
    <style>
        body {
            background-image: url(ab672c50cf19693a88e2f74b72fc72c6.jpg);
            background-repeat: no-repeat;
            background-size: cover;
        }

        .header {
            padding: 20px 40px;
            position: relative;
        }

        .logo-container {
            width: 9cm;
            /* Longueur du trait et de la zone d’animation */
            overflow: hidden;
            margin-left: 2cm;
            /* Aligner avec le titre "Bienvenue" */
        }

        .logo-text {
            font-weight: bold;
            margin-left: 1cm;
            font-size: 18px;
            white-space: nowrap;
            animation: slide-logo 6s linear infinite;
            color: white;
        }

        .logo-line {
            width: 10cm;
            height: 2px;
            background-color: #721072;
            margin-top: 6px;
        }
        .kobe{
            color: white;
            margin-left: 9cm;
            margin-top: 6cm;
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
    <div>
        <h3 class="kobe">"If you are going to be a leader, you are not going to please everybody." <br> KOBE BRYANT </br></h3>
    </div>
    <div>
        <button type="button" onclick="window.location.href='basket_page2.php'">Interesse?</button>
    </div>



</body>

</html>