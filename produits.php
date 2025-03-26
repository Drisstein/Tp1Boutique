<?php
include "config.php";

$produits = $pdo->query("SELECT * FROM produits")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Nos Produits</h2>
        <div class="row">
            <?php foreach ($produits as $produit): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($produit['nom']) ?></h5>
                            <p class="card-text">
                                Prix : <strong><?= number_format($produit['prix'], 2) ?> FCFA</strong><br>
                                Stock : <strong><?= $produit['stock'] ?> unités</strong>
                            </p>
                            <a href="ajouterCommande.php?id=<?= $produit['id_produit'] ?>" class="btn btn-primary">
                                Commander
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>