<?php
include "config.php";

$pdo = new PDO("mysql:host=localhost;dbname=boutique", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_client = $_POST['id_client'];
    $date_commande = date("Y-m-d");

    // Vérifier si des produits ont été sélectionnés
    if (!empty($_POST['produits']) && is_array($_POST['produits'])) {
        // Insérer la commande
        $sql = "INSERT INTO commandes (id_client, date_commande) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_client, $date_commande]);

        // Récupérer l'ID de la commande insérée
        $id_commande = $pdo->lastInsertId();

        // Insérer les produits commandés
        foreach ($_POST['produits'] as $produit) {
            $id_produit = $produit['id_produit'];
            $quantite = $produit['quantite'];

            // Vérifier si la quantité demandée est disponible en stock
            $stock_check = $pdo->prepare("SELECT stock FROM produits WHERE id_produit = ?");
            $stock_check->execute([$id_produit]);
            $stock_disponible = $stock_check->fetchColumn();

            if ($quantite > $stock_disponible) {
                echo "<p class='text-danger'>❌ Stock insuffisant pour le produit ID $id_produit.</p>";
                continue; // On passe au produit suivant
            }

            // Insérer dans détails_commande
            $sql = "INSERT INTO details_commandes (id_commande, id_produit, quantite) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_commande, $id_produit, $quantite]);

            // Mettre à jour le stock
            $update_stock = $pdo->prepare("UPDATE produits SET stock = stock - ? WHERE id_produit = ?");
            $update_stock->execute([$quantite, $id_produit]);
        }

        echo "<p class='text-success'>✅ Commande passée avec succès !</p>";
    } else {
        echo "<p class='text-warning'>❌ Aucun produit sélectionné.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passer une Commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        h2 {
            font-size: 2em;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        label {
            font-weight: 500;
            color: #555;
        }

        .form-control,
        .btn {
            border-radius: 8px;
        }

        .form-group div {
            padding: 10px 0;
            display: flex;
            align-items: center;
        }

        .form-group input[type="checkbox"] {
            margin-right: 10px;
        }

        .form-group input[type="number"] {
            margin-left: 10px;
            width: 80px;
        }

        .btn-success {
            background-color: #4CAF50;
            border: none;
        }

        .btn-success:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Passer une Commande</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Client</label>
                <select name="id_client" class="form-control" required>
                    <?php
                    $clients = $pdo->query("SELECT id_client, nom FROM clients")->fetchAll();
                    foreach ($clients as $client) {
                        echo "<option value='{$client['id_client']}'>{$client['nom']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Produits</label>
                <div class="form-group">
                    <?php
                    $produits = $pdo->query("SELECT id_produit, nom, stock FROM produits")->fetchAll();
                    foreach ($produits as $produit) {
                        echo "<div>
                                <input type='checkbox' name='produits[{$produit['id_produit']}][id]' value='{$produit['id_produit']}'> 
                                {$produit['nom']} (Stock: {$produit['stock']})
                                <input type='number' name='produits[{$produit['id_produit']}][quantite]' min='1' max='{$produit['stock']}' placeholder='Quantité'>
                              </div>";
                    }
                    ?>
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100">Passer la commande</button>
        </form>
    </div>
</body>

</html>