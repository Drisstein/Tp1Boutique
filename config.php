<!-- /*Ce fichier contient les informations de connexion à la base de données*/ -->
<?php
$host = "localhost";
$dbname = "boutique";
$username = "root";  // Remplace par ton utilisateur MySQL
$password = "";  // Ajout d'un mot de passe pour la sécurité

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>