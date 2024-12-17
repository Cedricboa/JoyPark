<?php
// /index.php

include './includes/config.php';
include './includes/header.php';

// Récupérer les données nécessaires
$visiteurs= $db->users->find();
$billets = $db->tickets->find();
$evenements = $db->events->find();
?>

<main>
    <h1>Joypark</h1>

    <!-- Section Utilisateurs -->
    <section>
        <h2>Liste visiteurs</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Crée le</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($visiteurs as $visiteurs): ?>
                    <tr>
                        <td><?php echo $visiteurs->_id; ?></td>
                        <td><?php echo $visiteurs->name; ?></td>
                        <td><?php echo $visiteurs->email; ?></td>
                        <td><?php echo $visiteurs->role ?? 'visiteurs'; ?></td>
                        <td>
                            <?php
                            $date = $visiteurs->created_at instanceof MongoDB\BSON\UTCDateTime 
                                ? $visiteurs->created_at->toDateTime()->format('d/m/Y H:i') 
                                : 'N/A';
                            echo $date;
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Section Billets -->
    <section>
        <h2>Liste des Billets</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Visiteur</th>
                    <th>Type de Billet</th>
                    <th>Prix</th>
                    <th>Date d'Achat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($billets as $billet): ?>
                    <tr>
                        <td><?php echo $billet->_id; ?></td>
                        <td><?php echo $billet->visitor_id; ?></td>
                        <td><?php echo $billet->ticket_type; ?></td>
                        <td><?php echo $billet->price; ?> €</td>
                        <td>
                            <?php
                            $date = $billet->purchase_date instanceof MongoDB\BSON\UTCDateTime 
                                ? $billet->purchase_date->toDateTime()->format('d/m/Y H:i') 
                                : $billet->purchase_date;
                            echo $date;
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Section Événements -->
    <section>
        <h2>Liste des Événements</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Lieu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($evenements as $evenement): ?>
                    <tr>
                        <td><?php echo $evenement->_id; ?></td>
                        <td><?php echo $evenement->name; ?></td>
                        <td><?php echo $evenement->description; ?></td>
                        <td>
                            <?php
                            $date = $evenement->date instanceof MongoDB\BSON\UTCDateTime 
                                ? $evenement->date->toDateTime()->format('d/m/Y') 
                                : $evenement->date;
                            echo $date;
                            ?>
                        </td>
                        <td><?php echo $evenement->location; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>

<?php include './includes/footer.php'; ?>
