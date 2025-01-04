<?php
session_start();
require 'vendor/autoload.php';

header('Content-Type: application/json');

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->messi;

// Vérification de la méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
    exit();
}

// Vérification des données envoyées
if (!isset($_POST['ticket_id']) || !isset($_POST['quantity'])) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes.']);
    exit();
}

$sessionId = session_id();

try {
    $ticketObjectId = new MongoDB\BSON\ObjectId($_POST['ticket_id']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'ID de ticket invalide.']);
    exit();
}

$quantity = intval($_POST['quantity']);
if ($quantity <= 0) {
    echo json_encode(['success' => false, 'message' => 'Quantité invalide.']);
    exit();
}

// Récupérer le ticket
$ticket = $db->tickets->findOne(['_id' => $ticketObjectId]);

if (!$ticket) {
    echo json_encode(['success' => false, 'message' => 'Ticket non trouvé.']);
    exit();
}

if ($ticket['remaining_quantity'] < $quantity) {
    echo json_encode(['success' => false, 'message' => 'Quantité demandée indisponible.']);
    exit();
}

// Rechercher si le ticket est déjà dans le panier pour cette session et en statut 'cart'
$existingBillet = $db->{"billet acheté"}->findOne([
    'ticket_id' => $ticketObjectId,
    'session_id' => $sessionId,
    'status' => 'cart'
]);

if ($existingBillet) {
    // Mettre à jour la quantité dans billet acheté
    $newBilletQuantity = $existingBillet['quantity'] + $quantity;
    $db->{"billet acheté"}->updateOne(
        ['_id' => $existingBillet['_id']],
        ['$set' => ['quantity' => $newBilletQuantity, 'purchase_date' => new MongoDB\BSON\UTCDateTime()]]
    );
} else {
    // Ajouter à la collection billet acheté
    $db->{"billet acheté"}->insertOne([
        'ticket_id' => $ticketObjectId,
        'ticket_type' => $ticket['ticket_type'],
        'price' => $ticket['price'],
        'quantity' => $quantity,
        'purchase_date' => new MongoDB\BSON\UTCDateTime(),
        'session_id' => $sessionId,
        'status' => 'cart'
    ]);
}

// Mettre à jour la quantité restante
$newQuantity = $ticket['remaining_quantity'] - $quantity;
$db->tickets->updateOne(
    ['_id' => $ticketObjectId],
    ['$set' => ['remaining_quantity' => $newQuantity]]
);

// Répondre avec succès
echo json_encode(['success' => true, 'new_quantity' => $newQuantity]);
exit();
?>
