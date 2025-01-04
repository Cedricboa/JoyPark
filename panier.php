<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->messi;

$sessionId = session_id();

// Récupérer les billets achetés pour cette session et en statut 'cart'
$billetsAchetes = $db->{"billet acheté"}->find([
    'session_id' => $sessionId,
    'status' => 'cart'
]);

$billets = iterator_to_array($billetsAchetes); // Convert cursor to array

if (empty($billets)) {
    $_SESSION['message'] = "Votre panier est vide.";
    header("Location: tickets.php");
    exit();
}

// Enregistrement des informations client et finalisation de l'achat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['client_name']) && isset($_POST['client_email'])) {
    $clientName = htmlspecialchars($_POST['client_name']);
    $clientEmail = htmlspecialchars($_POST['client_email']);
    $totalAmount = 0;

    foreach ($billets as $billet) {
        $totalAmount += $billet['price'] * $billet['quantity'];
        
        // Mettre à jour billet acheté avec client info et changer le statut
        $db->{"billet acheté"}->updateOne(
            ['_id' => $billet['_id']],
            ['$set' => [
                'client_name' => $clientName,
                'client_email' => $clientEmail,
                'status' => 'purchased'
            ]]
        );
    }

    // Message de succès
    $_SESSION['message'] = "Votre commande a été enregistrée avec succès. Total : $totalAmount €.";
    header("Location: tickets.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - JoyPark</title>
    <link rel="stylesheet" href="tickets.css">
    <style>
        /* Styles pour le panier */
        .cart-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 15px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .cart-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item p {
            margin: 5px 0;
        }

        .checkout-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        .checkout-btn:hover {
            background-color: #218838;
        }

        .alert {
            margin: 15px auto;
            max-width: 800px;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 1em;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Styles du formulaire client */
        .client-info {
            margin-top: 20px;
        }

        .client-info label {
            display: block;
            margin: 10px 0 5px;
        }

        .client-info input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .submit-btn {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #1abc9c;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        .submit-btn:hover {
            background-color: #16a085;
        }
    </style>
</head>
<body>
    <header>
        <h1>Votre Panier</h1>
    </header>

    <main>
        <section>
            <div class="cart-container">
                <!-- Message -->
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message']) ?></div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <?php if (empty($billets)): ?>
                    <p>Votre panier est vide.</p>
                <?php else: ?>
                    <form method="POST">
                        <?php
                        $total = 0;
                        foreach ($billets as $billet):
                            $total += $billet['price'] * $billet['quantity'];
                        ?>
                            <div class="cart-item">
                                <p><strong>Type de billet :</strong> <?= htmlspecialchars($billet['ticket_type']) ?></p>
                                <p><strong>Prix unitaire :</strong> <?= htmlspecialchars($billet['price']) ?> €</p>
                                <p><strong>Quantité :</strong> <?= htmlspecialchars($billet['quantity']) ?></p>
                                <p><strong>Total :</strong> <?= htmlspecialchars($billet['price'] * $billet['quantity']) ?> €</p>
                            </div>
                        <?php endforeach; ?>
                        <p><strong>Montant total :</strong> <?= htmlspecialchars($total) ?> €</p>

                        <!-- Formulaire d'informations client -->
                        <div class="client-info">
                            <h3>Informations Client</h3>
                            <label for="client_name">Nom :</label>
                            <input type="text" id="client_name" name="client_name" required>
                            <label for="client_email">Email :</label>
                            <input type="email" id="client_email" name="client_email" required>
                            <button type="submit" class="submit-btn">Finaliser l'achat</button>
                        </div>
                    </form>
                <?php endif; ?>
                <br>
                <a href="tickets.php">Retour aux tickets</a>
            </div>
        </section>
    </main>
</body>
</html>
