<?php
session_start();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!isset($_SESSION['client_id'])) {
    header('Location: ../index.php?page=connexion&error=login_required');
    exit;
}

if ($id > 0) {
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    if (!isset($_SESSION['panier'][$id])) {
        $_SESSION['panier'][$id] = 1;
    } else {
        $_SESSION['panier'][$id]++;
    }
}

// redirection vers le panier
header('Location: ../index.php?page=panier');
exit;
