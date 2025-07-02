<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body {
        font-family: sans-serif;
        background-image: url('89781.jpg');
        background-size: cover;
        background-position: center;
        color: #fff;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        text-align: center;
    }
    hr {
        border: 0;
        height: 1px;
        background: linear-gradient(495deg, #5f1f7a, #d02dc5);
        margin: 20px 0;
        width: 15%;
        box-shadow: 0 0 10px rgba(30, 11, 11, 0.5);
        position: absolute;
        top: 15px;
        left: 0;
    }
    h7 {
        position: absolute;
        top: 10px;
        left: 50px;
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: rgb(131, 149, 187);
    }
    h1 {
        font-size: 2rem;
        color: #a3baff;
        margin-bottom: 5px;
        text-align: center;
        position: relative;
        top: -40vh;
        left: -75vh;
        text-decoration: underline;
    }
    section {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 100px;
    }
    .club-img {
        width: 180px;
        height: 120px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    .submit-btn {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 10px;
      background: linear-gradient(135deg, violet, #8a2be2);
      color: #fff;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    section button {
        width: 70%;
        padding: 10px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, violet, #8a2be2);
        color: #fff;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s ease;
        margin-top: 10px;
    }
    section button:hover {
        background: linear-gradient(135deg, #8a2be2, violet);
        color: #ffe7ff;
    }
    h2 {
        font-size: 1.5rem;
        color:rgb(185, 130, 212);
        margin-bottom: 10px;
        
    }

</style>

<body>
<hr>
<h7>ESMIA UNIVERSITY</h7>
<div>
    <h1>Choisissez vos club</h1>
</div>
<section>
    <div id="club1">
        <h2>Club de basket</h2>
        <img src="basket.jpeg" alt="Club de basket" class="club-img">
        <p>Rejoignez-nous pour apprendre et s'ammuser a mettre des paiers</p>
        <button onclick="window.location.href='basket_page.php'">S'inscrire</button>
    </div>
    <div id="club2">
        <h2>Club de musique</h2>
        <img src=" musique.jpeg" alt="Club de musique" class="club-img">
        <p>Participez à nos sessions de jam et développez vos compétences musicales.</p>
        <button onclick="alert('Inscription au Club de Musique réussie !')">S'inscrire</button>
    </div>
    <div id="club3">
        <h2>Club de programmation</h2>
        <img src="prog.jpeg" alt="Club de programmation" class="club-img">
        <p>Rejoignez-nous pour apprendre et partager vos connaissances en programmation.</p>
        <button onclick="alert('Inscription au Club de Programmation réussie !')">S'inscrire</button>
    </div>
    <div id="club4">
        <h2>Club de foot</h2>
        <img src="foot.jpeg" alt="Club de foot" class="club-img">
        <p>Venez vous défouler et pratiquer votre sport préféré avec nous.</p>
        <button onclick="alert('Inscription au Club de Foot réussie !')">S'inscrire</button>
    </div>
    <div id="club5">
        <h2>Club de danse</h2>
        <img src="danse.jpeg" alt="Club de danse" class="club-img">
        <p>Exprimez-vous à travers la danse et rejoignez notre groupe de danse.</p>
        <button onclick="window.location.href='danse.php'">S'inscrire</button>
    </div>
</section>
</body>
</html>
<