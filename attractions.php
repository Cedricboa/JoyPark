<?php
require 'vendor/autoload.php';

// Connexion à MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->messi;

// Récupérer toutes les attractions
$attractions = $db->attractions->find();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Attractions - JoyPark</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- En-tête -->
    <header>
        <h1>Nos Attractions</h1>
    </header>

    <!-- Contenu principal -->
    <main>
        <section>
            <div class="grid">
                <?php foreach ($attractions as $attraction): ?>
                    <div class="card">
                        <h2><?= htmlspecialchars($attraction['name'] ?? 'Nom inconnu') ?></h2>
                        <p><strong>Type :</strong> <?= htmlspecialchars($attraction['type'] ?? 'Type inconnu') ?></p>
                        <p><strong>Description :</strong> <?= htmlspecialchars($attraction['description'] ?? 'Pas de description.') ?></p>
                        <p><strong>Statut :</strong> <?= htmlspecialchars($attraction['status'] ?? 'Inconnu') ?></p>
                        <p><strong>Taille minimale :</strong> <?= $attraction['height_requirement'] ?? 'N/A' ?> cm</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <!-- Pied de page -->
    <footer>
        <p>&copy; <?= date("Y") ?> JoyPark - Là où la magie commence.</p>
    </footer>
</body>
</html>
