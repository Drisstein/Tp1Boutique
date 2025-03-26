<?php
include "config.php";

$pdo = new PDO("mysql:host=localhost;dbname=boutique", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $telephone = trim($_POST['telephone']);
    $adresse = trim($_POST['adresse']);

    if (!$email) {
        echo "<p>❌ Email invalide.</p>";
    } else {
        // Vérifier si l'email existe déjà
        $checkEmail = $pdo->prepare("SELECT COUNT(*) FROM clients WHERE email = ?");
        $checkEmail->execute([$email]);
        $emailExists = $checkEmail->fetchColumn();

        if ($emailExists) {
            echo "<p>❌ Cet email est déjà utilisé !</p>";
        } else {
            // Insérer le client
            $sql = "INSERT INTO clients (nom, email, telephone, adresse) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom, $email, $telephone, $adresse]);

            echo "<p>✅ Client ajouté avec succès ! Redirection en cours...</p>";
            header("refresh:2;url=ajouterCommande.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Ajouter un Client</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Téléphone</label>
                <input type="text" name="telephone" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Adresse</label>
                <textarea name="adresse" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Ajouter</button>
            <a href="index.php" class="btn btn-secondary">Retour</a>
        </form>
    </div>
</body>

</html>