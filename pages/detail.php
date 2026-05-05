<div class="content">
    <?php
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($id <= 0) {
        echo '<div class="alert alert-error">Album invalide.</div>';
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM album WHERE id_album = :id LIMIT 1");
            $stmt->execute(['id' => $id]);
            $album = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($album) {
                $imagePath = !empty($album['cover']) ? htmlspecialchars($album['cover']) : 'assets/default.png';
                $titre = isset($album['nom']) ? htmlspecialchars($album['nom']) : 'Titre inconnu';
                $artiste = isset($album['artiste']) ? htmlspecialchars($album['artiste']) : 'Artiste inconnu';
                $annee = isset($album['annee']) ? htmlspecialchars($album['annee']) : 'Année inconnue';
                $prix = isset($album['prix']) ? number_format($album['prix'], 2) . ' €' : 'NC';
                
                // Parsing de la tracklist (ex: 'Track 1','Track 2' => Tableau)
                $tracklist_str = $album['tracklist'] ?? '';
                // On retire les guillemets simples s'ils existent et on coupe à la virgule
                $tracklist_clean = str_replace("'", "", $tracklist_str);
                $tracks = array_filter(array_map('trim', explode(',', $tracklist_clean)));

                ?>
                <div class="detail-container">
                    <div class="detail-cover">
                        <img src="<?php echo $imagePath; ?>" alt="Cover de <?php echo $titre; ?>">
                    </div>
                    <div class="detail-info">
                        <h1 class="detail-title"><?php echo $titre; ?></h1>
                        <h2 class="detail-artist"><?php echo $artiste; ?></h2>
                        <div class="detail-meta">
                            Sortie en : <strong><?php echo $annee; ?></strong>
                        </div>
                        <div class="detail-price">
                            <?php echo $prix; ?>
                        </div>
                        <div class="detail-actions">
                            <?php if (!isset($_SESSION['client_id'])): ?>
                                <button type="button" onclick="alert('Veuillez vous connecter ou créer un compte pour ajouter au panier.'); window.location.href='index.php?page=connexion';">Ajouter au panier</button>
                            <?php else: ?>
                                <form action="pages/add_to_cart_action.php" method="GET" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <button type="submit">Ajouter au panier</button>
                                </form>
                            <?php endif; ?>
                        </div>
                        
                        <div class="tracklist-container">
                            <h3>Tracklist</h3>
                            <?php if (count($tracks) > 0): ?>
                                <ul class="tracklist">
                                    <?php 
                                    $num = 1;
                                    foreach ($tracks as $track) {
                                        echo '<li><span class="track-num">' . str_pad($num, 2, '0', STR_PAD_LEFT) . '.</span> ' . htmlspecialchars($track) . '</li>';
                                        $num++;
                                    }
                                    ?>
                                </ul>
                            <?php else: ?>
                                <p style="color: #ccc;">Aucune piste renseignée.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo '<div class="alert alert-error">L\'album demandé n\'existe pas.</div>';
            }
        } catch (PDOException $e) {
            echo '<div class="alert alert-error">Erreur de base de données. Veuillez réessayer.</div>';
        }
    }
    ?>
    <div style="text-align: center; margin-top: 20px;">
        <button onclick="window.history.back()">Retour au catalogue</button>
    </div>
</div>
