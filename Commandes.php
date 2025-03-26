<?php
$pdo = new PDO("mysql:host=localhost;dbname=boutique", "root", "");

$query = $pdo->query("
    SELECT c.id_commande, c.date_commande, c.total, c.statut, cl.nom AS client
    FROM commandes c
    JOIN clients cl ON c.id_client = cl.id_client
    ORDER BY c.id_commande DESC
");
$commandes = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Commandes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Liste des Commandes</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commandes as $commande): ?>
                    <tr>
                        <td><?= $commande['id_commande'] ?></td>
                        <td><?= $commande['client'] ?></td>
                        <td><?= $commande['date_commande'] ?></td>
                        <td><?= $commande['total'] ?> FCFA</td>
                        <td><?= $commande['statut'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-primary">Retour</a>
    </div>
</body>

</html>