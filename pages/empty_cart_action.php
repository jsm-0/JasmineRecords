<?php
session_start();
require_once '../style/bd.php';

if (!isset($_SESSION['client_id']) || empty($_SESSION['panier'])) {
    header('Location: ../index.php?page=panier');
    exit;
}

$client_id = $_SESSION['client_id'];
$panier = $_SESSION['panier'];

try {
    $conn->beginTransaction();

    // 1. Calculate total and get prices
    $ids = array_keys($panier);
    $in_query = implode(',', array_fill(0, count($ids), '?'));
    
    $stmt = $conn->prepare("SELECT id_album, prix FROM album WHERE id_album IN ($in_query)");
    $stmt->execute($ids);
    $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total = 0;
    $album_prices = [];
    foreach ($albums as $album) {
        $id_album = $album['id_album'];
        $prix = $album['prix'];
        $quantite = $panier[$id_album];
        $total += $prix * $quantite;
        $album_prices[$id_album] = $prix;
    }

    // 2. Insert into commande
    $date_commande = date('Y-m-d H:i:s');
    $stmt_cmd = $conn->prepare("INSERT INTO commande (client_id, date_commande, total) VALUES (:client_id, :date_commande, :total)");
    $stmt_cmd->execute([
        ':client_id' => $client_id,
        ':date_commande' => $date_commande,
        ':total' => $total
    ]);
    
    $commande_id = $conn->lastInsertId();

    // 3. Insert into ligne_commande
    $stmt_ligne = $conn->prepare("INSERT INTO ligne_commande (commande_id, album_id, quantite, prix_unitaire) VALUES (:commande_id, :album_id, :quantite, :prix_unitaire)");
    
    foreach ($panier as $id_album => $quantite) {
        if (isset($album_prices[$id_album])) {
            $stmt_ligne->execute([
                ':commande_id' => $commande_id,
                ':album_id' => $id_album,
                ':quantite' => $quantite,
                ':prix_unitaire' => $album_prices[$id_album]
            ]);
        }
    }

    // Commit transaction
    $conn->commit();

    // 4. Empty cart
    unset($_SESSION['panier']);
    header('Location: ../index.php?page=panier&success=checkout');
    exit;

} catch (PDOException $e) {
    $conn->rollBack();
    header('Location: ../index.php?page=panier&error=db');
    exit;
}
