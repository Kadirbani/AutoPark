<?php
require_once('cnx.php');

/* ══════════════════════════════
   SUPPRESSION (GET)
══════════════════════════════ */
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    // Récupérer le nom de l'image pour la supprimer du serveur
    $stmt = $conn->prepare("SELECT image FROM voiture WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && !empty($row['image'])) {
        $imgPath = "uploads/" . $row['image'];
        if (file_exists($imgPath)) {
            unlink($imgPath);
        }
    }

    $stmt = $conn->prepare("DELETE FROM voiture WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: liste.php');
    exit;
}

/* ══════════════════════════════
   RÉCUPÉRATION DES DONNÉES POST
══════════════════════════════ */
$id          = $_POST['id']          ?? '';
$marque      = trim($_POST['marque']      ?? '');
$modele      = trim($_POST['modele']      ?? '');
$annee       = trim($_POST['annee']       ?? '');
$couleur     = trim($_POST['couleur']     ?? '');
$carburant   = trim($_POST['carburant']   ?? '');
$kilometrage = trim($_POST['kilometrage'] ?? '');
$prix        = trim($_POST['prix']        ?? '');
$description = trim($_POST['description'] ?? '');
$old_image   = $_POST['old_image'] ?? '';
$action      = $_POST['action']    ?? '';

/* ══════════════════════════════
   GESTION IMAGE
══════════════════════════════ */
$imageName = $old_image; // conserver l'ancienne par défaut

if (!empty($_FILES['image']['name'])) {
    // Supprimer l'ancienne image si elle existe
    if (!empty($old_image) && file_exists("uploads/" . $old_image)) {
        unlink("uploads/" . $old_image);
    }

    $ext       = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageName = time() . '_' . uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $imageName);
}

/* ══════════════════════════════
   VALIDATION
══════════════════════════════ */
$errors = [];

if (empty($marque) || empty($modele) || empty($annee) || empty($prix)) {
    $errors[] = "Les champs Marque, Modèle, Année et Prix sont obligatoires.";
}

if (!empty($annee) && (!is_numeric($annee) || $annee < 1990 || $annee > 2025)) {
    $errors[] = "L'année doit être comprise entre 1990 et 2025.";
}

if (!empty($prix) && (!is_numeric($prix) || $prix < 0)) {
    $errors[] = "Le prix doit être un nombre positif.";
}

if (!empty($kilometrage) && (!is_numeric($kilometrage) || $kilometrage < 0)) {
    $errors[] = "Le kilométrage doit être un nombre positif.";
}

/* ══════════════════════════════
   AFFICHAGE DES ERREURS
══════════════════════════════ */
if (!empty($errors)) {
    foreach ($errors as $err) {
        echo '<div class="alert alert-error">' . htmlspecialchars($err) .
             ' &mdash; <a href="javascript:history.back()">Retour au formulaire</a></div>';
    }
    exit;
}

/* ══════════════════════════════
   INSERT
══════════════════════════════ */
if ($action === 'insert') {
    $stmt = $conn->prepare(
        "INSERT INTO voiture (marque, modele, annee, couleur, carburant, kilometrage, prix, description, image)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->execute([$marque, $modele, $annee, $couleur, $carburant, $kilometrage, $prix, $description, $imageName]);
}

/* ══════════════════════════════
   UPDATE
══════════════════════════════ */
if ($action === 'update') {
    $stmt = $conn->prepare(
        "UPDATE voiture
         SET marque=?, modele=?, annee=?, couleur=?, carburant=?, kilometrage=?, prix=?, description=?, image=?
         WHERE id=?"
    );
    $stmt->execute([$marque, $modele, $annee, $couleur, $carburant, $kilometrage, $prix, $description, $imageName, $id]);
}

header('Location: liste.php');
exit;
