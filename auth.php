<?php

function isLoggedIn() {
    // regarde si l'user est connecte
    return isset($_SESSION['nie_etudiant']) && !empty($_SESSION['nie_etudiant']);
}

function requireLogin() {
    // redirige vers la page de connexion si l'user n'est pas connecte
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}
?>