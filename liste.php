<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Voitures</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php
$page = 'liste';
include_once('nav.php');
require_once('cnx.php');

$stmt = $conn->query("SELECT * FROM voiture ORDER BY id DESC");
$voitures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-admin">

    <div class="header">
        <h1>Gestion des Voitures</h1>
        <a href="formulaire.php" class="btn-add">+ Ajouter une voiture</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Marque / Modèle</th>
                <th>Année</th>
                <th>Couleur</th>
                <th>Carburant</th>
                <th>Kilométrage</th>
                <th>Prix (DT)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($voitures as $v): ?>
                <tr>
                    <td><?= $v['id'] ?></td>
                    <td>
                        <?php if (!empty($v['image'])): ?>
                            <img src="uploads/<?= htmlspecialchars($v['image']) ?>" alt="">
                        <?php else: ?>
                            🚗
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($v['marque']) ?> <?= htmlspecialchars($v['modele']) ?></td>
                    <td><?= htmlspecialchars($v['annee']) ?></td>
                    <td><?= htmlspecialchars($v['couleur']) ?></td>
                    <td><?= htmlspecialchars($v['carburant']) ?></td>
                    <td><?= number_format($v['kilometrage']) ?> km</td>
                    <td><?= number_format($v['prix'], 0, ',', ' ') ?></td>
                    <td>
                        <a href="formulaire.php?id=<?= $v['id'] ?>" class="btn-edit">Modifier</a>
                        <a href="traitement.php?delete=<?= $v['id'] ?>"
                           class="btn-delete"
                           onclick="return confirm('Supprimer cette voiture ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>
