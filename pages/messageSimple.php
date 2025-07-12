<?php
session_start();
// Connexion à la base de données
$host = "localhost";
$user = "root";
$pass = "Doja1390";
$dbname = "p_transversal";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=p_transversal', 'root', 'Doja1390');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifie si l'étudiant est connecté
    if (!isset($_SESSION['id_etudiant'])) {
        header("Location: login.php");
        exit();
    }

    $id = $_SESSION['id_etudiant'];

    // 🔍 Récupération des messages de l'étudiant
    $stmt = $pdo->prepare("SELECT * FROM MESSAGE WHERE id_etudiant = ? ORDER BY id_message DESC");
    $stmt->execute([$id]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ✅ Marquer tous les messages comme lus
    $update = $pdo->prepare("UPDATE MESSAGE SET vu = 1 WHERE id_etudiant = ? AND vu = 0");
    $update->execute([$id]);

} catch (PDOException $e) {
    echo "<p style='color:red;'>Erreur de base de données : " . htmlspecialchars($e->getMessage()) . "</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vos messages</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .message { border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; border-radius: 5px; }
        .objet { font-weight: bold; font-size: 16px; color: #333; }
        .contenu { margin-top: 5px; }
    </style>
</head>
<body>

<h2>📨 Vos messages</h2>

<?php if (count($messages) === 0): ?>
    <p>Aucun message reçu.</p>
<?php else: ?>
    <?php foreach ($messages as $msg): ?>
        <div class="message">
            <div class="objet"><?= htmlspecialchars($msg['objet_message']) ?></div>
            <div class="contenu"><?= nl2br(htmlspecialchars($msg['contenu_message'])) ?></div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</h2>
</body>
</html>
