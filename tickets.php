<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->messi;

// Récupération des tickets
$tickets = $db->tickets->find();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets - JoyPark</title>
    <link rel="stylesheet" href="tickets.css">
    <style>
        .alert {
            margin: 15px auto;
            max-width: 800px;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 1em;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: rgb(26, 198, 29);
            border: 1px solid #f5c6cb;
        }

        .add-to-cart-btn {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .add-to-cart-btn:hover {
            background-color: #0056b3;
        }

        .ticket-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="tickets-page">
    <header class="hero-header">
        <h1>Tickets - JoyPark</h1>
        <a href="panier.php">Voir le panier</a>
    </header>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message']) ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <main>
        <div class="tickets-grid">
            <?php foreach ($tickets as $ticket): ?>
                <div class="ticket-card">
                    <?php
                    // Tableau de correspondance des images en fonction du type de billet
                    $images = [
                        'Demi-journée' => 'https://www.thorpepark.com/media/5roaqxpf/saw-the-ride.jpg',
                        'Journée' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvBTkkmuOIlvRT0CAPsQyGJeB5jZlN0fgtMQ&s',
                        'Pass Annuel' => 'https://media.istockphoto.com/id/1315591922/vector/cartoon-vector-illustration-isolated-object-amusement-park-ticket.jpg?s=612x612&w=0&k=20&c=v8_piwvIUCwormA4yHS_9cTsSeh3UaW15u3GFl98ISM='
                    ];

                    // Déterminer l'image en fonction du type de billet
                    $image = isset($images[$ticket['ticket_type']]) ? $images[$ticket['ticket_type']] : 'https://via.placeholder.com/150';
                    ?>
                    <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($ticket['ticket_type']) ?>" class="ticket-img">
                    <p><strong>Type :</strong> <?= htmlspecialchars($ticket['ticket_type']) ?></p>
                    <p><strong>Prix :</strong> <?= htmlspecialchars($ticket['price']) ?> €</p>
                    <p><strong>Quantité restante :</strong> <span id="stock-<?= (string)$ticket['_id'] ?>"><?= htmlspecialchars($ticket['remaining_quantity']) ?></span></p>
                    <a href="javascript:void(0);" 
                       class="add-to-cart-btn" 
                       data-id="<?= (string)$ticket['_id'] ?>">Ajouter au panier</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(".add-to-cart-btn").on("click", function() {
            const ticketId = $(this).data("id");
            const quantity = prompt("Entrez la quantité à ajouter:");

            if (quantity !== null && !isNaN(quantity)) {
                $.post("add_to_cart.php", { ticket_id: ticketId, quantity: quantity }, function(response) {
                    if (response.success) {
                        $("#stock-" + ticketId).text(response.new_quantity);
                        alert("Billet ajouté au panier !");
                    } else {
                        alert("Erreur : " + response.message);
                    }
                }, "json").fail(function() {
                    alert("Une erreur s'est produite lors de l'ajout au panier.");
                });
            }
        });
    </script>
</body>
</html>
