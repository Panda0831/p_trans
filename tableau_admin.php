<?php
session_start();

// Vérification de la connexion
if (!isset($_SESSION['nie_etudiant'])) {
    header('Location: login.php');
    exit();
}

// Connexion à la base de données
try {
    $db = new PDO('mysql:host=localhost;dbname=P_trans', 'root', 'Ryan');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Récupération des infos personnelles
    $stmt = $db->prepare("SELECT * FROM ETUDIANT WHERE nie_etudiant = ?");
    $stmt->execute([$_SESSION['nie_etudiant']]);
    $etudiant = $stmt->fetch(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // 2. Récupération des clubs administrés
    $stmt = $db->prepare("SELECT c.nom_club FROM CLUB c 
                         JOIN ADMIN_CLUB a ON c.id_club = a.id_club 
                         WHERE a.nie_etudiant = ?");
    $stmt->execute([$_SESSION['nie_etudiant']]);
    $clubs_admin = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // 3. Récupération des clubs où l'étudiant est inscrit
    $stmt = $db->prepare("SELECT c.nom_club FROM CLUB c 
                         JOIN INSCRIPTION_CLUB i ON c.id_club = i.id_club 
                         WHERE i.nie_etudiant = ?");
    $stmt->execute([$_SESSION['nie_etudiant']]);
    $clubs_inscrit = $stmt->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
    die("Erreur de base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .profile-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .profile-info p {
            margin: 5px 0;
        }
        .club-list {
            background: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            background: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .btn:hover {
            background: #555;
        }
        .admin-features {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <h1>Tableau de bord Administrateur</h1>
            <div class="profile-info">
                <h2><?= htmlspecialchars($etudiant['prenom_etudiant']) . ' ' . htmlspecialchars($etudiant['nom_etudiant']) ?></h2>
                <p><strong>NIE:</strong> <?= htmlspecialchars($etudiant['nie_etudiant']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($etudiant['email_etudiant']) ?></p>
                <p><strong>Filière:</strong> <?= htmlspecialchars($etudiant['filiere_etudiant']) ?></p>
                <p><strong>Niveau:</strong> <?= htmlspecialchars($etudiant['niveau_etudiant']) ?></p>
                <p><strong>Classe:</strong> <?= htmlspecialchars($etudiant['classe_etudiant']) ?></p>
            </div>
        </div>

        <div class="club-list">
            <h3>Mes clubs</h3>
            <p><strong>Inscrit dans:</strong> 
                <?= !empty($clubs_inscrit) ? htmlspecialchars(implode(', ', $clubs_inscrit)) : 'Aucun club' ?>
            </p>
            <p><strong>Administrateur de:</strong> 
                <?= !empty($clubs_admin) ? htmlspecialchars(implode(', ', $clubs_admin)) : 'Aucun club' ?>
            </p>
        </div>

        <div class="admin-features">
            <h3>Fonctionnalités Administrateur</h3>
            <a href="gestion_clubs.php" class="btn">Gérer les clubs</a>
            <a href="gestion_membres.php" class="btn">Gérer les membres</a>
            <a href="creer_evenement.php" class="btn">Créer un événement</a>
        </div>

        <a href="deconnexion.php" class="btn" style="background: #d9534f;">Déconnexion</a>
    </div>
</body>
</html>