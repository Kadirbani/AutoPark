<?php
require_once('cnx.php');
$stmt = $conn->query("SELECT * FROM voiture ORDER BY id DESC");
$voitures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue - Bani AutoPark</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php $page = 'home'; include_once('nav.php'); ?>

<div class="hero-banner">
    <h1>Notre <span>Catalogue</span></h1>
    <p><?= count($voitures) ?> véhicule(s) disponible(s)</p>
</div>

<div class="container">
    <?php foreach ($voitures as $v): ?>
        <div class="card">
            <?php if (!empty($v['image'])): ?>
                <img src="uploads/<?= htmlspecialchars($v['image']) ?>" class="card-img" alt="<?= htmlspecialchars($v['marque']) ?>">
            <?php else: ?>
                <div class="card-img-placeholder">🚗</div>
            <?php endif; ?>

            <div class="card-body">
                <span class="card-badge"><?= htmlspecialchars($v['carburant']) ?></span>
                <h2><?= htmlspecialchars($v['marque']) ?> <?= htmlspecialchars($v['modele']) ?></h2>

                <p>📅 <strong>Année :</strong> <?= htmlspecialchars($v['annee']) ?></p>
                <p>🎨 <strong>Couleur :</strong> <?= htmlspecialchars($v['couleur']) ?></p>
                <p>⚙️ <strong>Kilométrage :</strong> <?= number_format($v['kilometrage']) ?> km</p>

                <div class="card-price"><?= number_format($v['prix'], 0, ',', ' ') ?> DT</div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
