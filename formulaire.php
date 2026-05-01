<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Voiture - AutoPark</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php
$page = 'form';
include_once('nav.php');
require_once('cnx.php');

$id      = $_GET['id'] ?? null;
$voiture = [];

if ($id) {
    $stmt   = $conn->prepare("SELECT * FROM voiture WHERE id = ?");
    $stmt->execute([$id]);
    $voiture = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="form-container">
    <h1><?= $id ? 'Modifier la <span>Voiture</span>' : 'Ajouter une <span>Voiture</span>' ?></h1>

    <form method="POST" action="traitement.php" enctype="multipart/form-data">
        <input type="hidden" name="id"     value="<?= $voiture['id'] ?? '' ?>">
        <input type="hidden" name="old_image" value="<?= $voiture['image'] ?? '' ?>">

        <div class="form-row">
            <div class="form-group">
                <label>Marque</label>
                <input type="text" name="marque"
                       value="<?= htmlspecialchars($voiture['marque'] ?? '') ?>" required
                       placeholder="Ex: Renault">
            </div>
            <div class="form-group">
                <label>Modèle</label>
                <input type="text" name="modele"
                       value="<?= htmlspecialchars($voiture['modele'] ?? '') ?>" required
                       placeholder="Ex: Clio">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Année</label>
                <input type="number" name="annee" min="1990" max="2025"
                       value="<?= htmlspecialchars($voiture['annee'] ?? '') ?>" required
                       placeholder="2022">
            </div>
            <div class="form-group">
                <label>Couleur</label>
                <input type="text" name="couleur"
                       value="<?= htmlspecialchars($voiture['couleur'] ?? '') ?>"
                       placeholder="Ex: Blanc">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Carburant</label>
                <select name="carburant">
                    <?php
                    $carburants = ['Essence', 'Diesel', 'Électrique', 'Hybride', 'GPL'];
                    foreach ($carburants as $c):
                        $sel = (($voiture['carburant'] ?? '') === $c) ? 'selected' : '';
                    ?>
                        <option value="<?= $c ?>" <?= $sel ?>><?= $c ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Kilométrage (km)</label>
                <input type="number" name="kilometrage" min="0"
                       value="<?= htmlspecialchars($voiture['kilometrage'] ?? '') ?>"
                       placeholder="Ex: 45000">
            </div>
        </div>

        <div class="form-group">
            <label>Prix (DT)</label>
            <input type="number" name="prix" min="0" step="0.01"
                   value="<?= htmlspecialchars($voiture['prix'] ?? '') ?>" required
                   placeholder="Ex: 25000">
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" placeholder="Description optionnelle..."><?= htmlspecialchars($voiture['description'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label>Photo</label>
            <input type="file" name="image" accept="image/*">
            <?php if (!empty($voiture['image'])): ?>
                <small style="color:var(--muted);margin-top:4px;">Image actuelle : <?= htmlspecialchars($voiture['image']) ?></small>
            <?php endif; ?>
        </div>

        <button type="submit" name="action"
                value="<?= $id ? 'update' : 'insert' ?>"
                class="btn-submit">
            <?= $id ? '✔ Enregistrer les modifications' : '+ Ajouter la voiture' ?>
        </button>
    </form>
</div>

</body>
</html>
