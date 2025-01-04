<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aide - JoyPark</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="help-page">
    <!-- En-tête -->
    <header>
        <h1>Aide et Support</h1>
        <p>Trouvez ici toutes les informations nécessaires pour réserver et nous contacter.</p>
    </header>
    
    <!-- Contenu principal -->
    <main>
        <section>
            <!-- Section réservation -->
            <div class="help-section">
                <h2>Comment Réserver ?</h2>
                <p>Pour réserver vos billets pour JoyPark, suivez ces étapes simples :</p>
                <ol>
                    <li>Accédez à la page <a href="tickets.php">Billets</a>.</li>
                    <li>Sélectionnez le type de billet souhaité (journée, demi-journée, pass annuel, etc.).</li>
                    <li>Entrez vos informations personnelles et validez votre réservation.</li>
                    <li>Effectuez le paiement sécurisé en ligne.</li>
                    <li>Recevez votre billet directement par email.</li>
                </ol>
            </div>

            <!-- Section contact -->
            <div class="help-section">
                <h2>Contactez-nous</h2>
                <p>Vous avez des questions ou besoin d'assistance ? Contactez-nous via l'un des moyens suivants :</p>
                <ul>
                    <li><strong>Email :</strong> <a href="mailto:support@joypark.com">support@joypark.com</a></li>
                    <li><strong>Téléphone :</strong> +33 1 23 45 67 89</li>
                    <li><strong>Adresse :</strong> 123 Rue des Parcs, 75000 Paris, France</li>
                </ul>
                <p>Nos équipes sont disponibles du lundi au vendredi, de 9h00 à 18h00.</p>
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
