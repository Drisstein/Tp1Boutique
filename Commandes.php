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
    <style>
        /* Style pour une présentation douce */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #495057;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .table th {
            background-color: #007bff;
            color: white;
        }

        .table td {
            background-color: #f9f9f9;
        }

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f1f1f1;
        }

        /* Styles pour les statuts */
        .statut-en-cours {
            background-color: #ffbb33;
            color: white;
            padding: 5px;
            border-radius: 4px;
        }

        .statut-livree {
            background-color: #28a745;
            color: white;
            padding: 5px;
            border-radius: 4px;
        }

        .statut-annulee {
            background-color: #dc3545;
            color: white;
            padding: 5px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Liste des Commandes</h1>
        <table class="table table-striped">
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
                        <td><?= date("d/m/Y", strtotime($commande['date_commande'])) ?></td>
                        <td><?= number_format($commande['total'], 0, ',', ' ') ?> FCFA</td>
                        <td>
                            <?php
                            // Affichage du statut avec des styles différents
                            if ($commande['statut'] == 'En cours') {
                                echo "<span class='statut-en-cours'>{$commande['statut']}</span>";
                            } elseif ($commande['statut'] == 'Livrée') {
                                echo "<span class='statut-livree'>{$commande['statut']}</span>";
                            } elseif ($commande['statut'] == 'Annulée') {
                                echo "<span class='statut-annulee'>{$commande['statut']}</span>";
                            } else {
                                echo $commande['statut'];
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-primary">Retour</a>
    </div>
</body>

</html>