<?php
include "config.php";

$sql = "SELECT * FROM clients";
$stmt = $pdo->query($sql);

echo "<h2>Liste des Clients</h2>";

echo "<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 20px;
    }
    h2 {
        font-size: 1.8em;
        color: #333;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    th {
        background-color: #4CAF50;
        color: white;
        font-weight: normal;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
    td {
        color: #555;
    }
</style>";

echo "<table>";
echo "<tr><th>ID</th><th>Nom</th><th>Email</th><th>Téléphone</th><th>Adresse</th></tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
        <td>{$row['id_client']}</td>
        <td>{$row['nom']}</td>
        <td>{$row['email']}</td>
        <td>{$row['telephone']}</td>
        <td>{$row['adresse']}</td>
    </tr>";
}

echo "</table>";
?>