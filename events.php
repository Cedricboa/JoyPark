<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->messi;

// Récupérer tous les événements
$events = $db->evenements->find();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements - JoyPark</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="events-page">
    <!-- En-tête -->
    <header>
        <h1>Événements</h1>
        <p>Découvrez les événements à venir chez JoyPark ✨</p>
    </header>

    <!-- Contenu principal -->
    <main>
        <section>
            <div class="grid">
                <?php foreach ($events as $event): ?>
                    <div class="card">
                        <!-- Affichage de l'image -->
                        <img src="<?= htmlspecialchars($event['image_url'] ?? 'placeholder.jpg') ?>" 
                             alt="<?= htmlspecialchars($event['name'] ?? 'Image indisponible') ?>" 
                             class="card-img">
                        <!-- Contenu de la carte -->
                        <div class="card-content">
                            <h2><?= htmlspecialchars($event['name'] ?? 'Nom non renseigné') ?></h2>
                            <p><strong>Date :</strong> 
                                <?= isset($event['date']) 
                                    ? htmlspecialchars(date("d-m-Y", strtotime($event['date']))) 
                                    : 'Non spécifiée' ?>
                            </p>
                            <p><strong>Description :</strong> 
                                <?= htmlspecialchars($event['description'] ?? 'Pas de description.') ?>
                            </p>
                            <p><strong>Lieu :</strong> 
                                <?= htmlspecialchars($event['location'] ?? 'Lieu inconnu') ?>
                            </p>
                            <p><strong>Prix :</strong> 
                                <?= htmlspecialchars($event['price'] ?? 'Gratuit') ?> €
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
<!-- Bouton Retour à l'accueil -->
<div style="text-align: center; margin: 20px;">
        <a href="index.php" class="back-button">Retour à l'accueil</a>
    </div>
    <!-- Pied de page -->
    <footer>
        <p>&copy; <?= date("Y") ?> JoyPark - Là où la magie commence.</p>
    </footer>
</body>
</html>
