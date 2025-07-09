<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nie = $_POST['nie'] ?? '';
    $email = $_POST['email'] ?? '';

    // Vérification simple : est-ce que l'étudiant existe ?
    $sql = "SELECT * FROM ETUDIANT WHERE nie_etudiant = ? AND email_etudiant = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nie, $email]);
    $etudiant = $stmt->fetch();

    if ($etudiant) {
        $_SESSION['nie'] = $nie; // Connexion réussie

        // Vérifie si l'étudiant est aussi admin
        if (estAdmin($pdo, $nie)) {
            header("Location: admin/tableau_admin.php");
        } else {
            header("Location: utilisateurs/tableau_utilisateur.php");
        }
        exit();
    } else {
        $message = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Clubs Universitaires</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Connexion</h2>
    <?php if ($message): ?>
        <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="nie">NIE :</label>
        <input type="text" id="nie" name="nie" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
