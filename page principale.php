<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->messi;

// Récupération des données
$attractions = $db->attractions->find();
$events = $db->events->find();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JoyPark - Là où la magie commence</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header avec le logo -->
    <header>
        <div class="logo">
            <img src="logo-png.png" alt="JoyPark Logo">
        </div>
        <h1>Bienvenue à JoyPark</h1>
        <p>Là où la magie commence ✨</p>
    </header>

    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="attractions.php">Attractions</a></li>
            <li><a href="visitors.php">Visiteurs</a></li>
            <li><a href="tickets.php">Billets</a></li>
            <li><a href="events.php">Événements</a></li>
        </ul>
    </nav>

    <!-- Contenu principal -->
    <main>
        <section>
            <h2>Nos Attractions</h2>
            <ul>
                <?php foreach ($attractions as $attraction): ?>
                    <li><strong><?= $attraction['name'] ?></strong> - <?= $attraction['type'] ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section>
            <h2>Événements à venir</h2>
            <ul>
                <?php foreach ($events as $event): ?>
                    <li><strong><?= $event['name'] ?></strong> - <?= $event['date'] ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; <?= date("Y") ?> JoyPark - Là où la magie commence.</p>
    </footer>
</body>
</html>
