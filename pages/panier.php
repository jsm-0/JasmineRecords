<div class="content">
    <h1 class="page-title">Votre Panier</h1>

    <?php
    if (isset($_GET['success']) && $_GET['success'] === 'checkout') {
        echo '<div class="alert alert-success" style="margin-bottom:20px;">Commande validée avec succès ! Merci de votre achat.</div>';
    }

    if (!isset($_SESSION['client_id'])) {
        echo '<div class="alert alert-warning cart-empty">Vous devez être connecté pour voir ou modifier votre panier. <br><br><a href="index.php?page=connexion" class="cart-alert-link">Se connecter</a></div>';
    } else {
        $panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : [];

        if (empty($panier)) {
            echo '<div class="alert alert-info cart-empty">Votre panier est vide. <br><br><br><a href="index.php?page=catalogue" class="btn-filter">Découvrir notre catalogue</a></div>';
        } else {
            // Get all album IDs in cart
            $ids = array_keys($panier);
            $in_query = implode(',', array_fill(0, count($ids), '?'));
            $total_price = 0;

            try {
                $stmt = $conn->prepare("SELECT * FROM album WHERE id_album IN ($in_query)");
                $stmt->execute($ids);
                $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo '<div class="cart-items-container">';
                foreach ($albums as $album) {
                    $id = $album['id_album'];
                    $qty = $panier[$id];
                    $prix = $album['prix'];
                    $sous_total = $prix * $qty;
                    $total_price += $sous_total;

                    $imagePath = !empty($album['cover']) ? htmlspecialchars($album['cover']) : 'assets/default.png';
                    $titre = htmlspecialchars($album['nom'] ?? 'Titre inconnu');
                    $artiste = htmlspecialchars($album['artiste'] ?? 'Artiste inconnu');

                    echo '<div class="cart-item gallery-item">';
                    echo '<img src="' . $imagePath . '" alt="Cover de ' . $titre . '">';
                    echo '<div class="album-info">';
                    echo '<div class="album-title">' . $titre . '</div>';
                    echo '<div class="album-artist">' . $artiste . '</div>';
                    echo '</div>';
                    echo '<div class="cart-item-qty">Qté: ' . $qty . '</div>';
                    echo '<div class="cart-item-price">' . number_format($sous_total, 2) . ' €</div>';
                    echo '</div>';
                }
                echo '</div>';

                echo '<div class="cart-total-container">';
                echo '<h2 class="cart-total-title">Total : <span class="cart-total-amount">' . number_format($total_price, 2) . ' €</span></h2>';
                echo '<form action="pages/empty_cart_action.php" method="POST">';
                echo '<button type="submit" onclick="return confirm(\'Valider la commande pour ' . number_format($total_price, 2) . ' € ?\');">Procéder au paiement</button>';
                echo '</form>';
                echo '</div>';

            } catch (PDOException $e) {
                echo '<div class="alert alert-error">Erreur lors de la récupération du panier.</div>';
            }
        }
    }
    ?>
</div>