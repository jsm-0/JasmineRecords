<div class="Intro">
    <h1>Tous vos albums préférés,<br>en quelques clics</h1>
    <div class="button-container">
        <button onclick="window.location.href='index.php?page=catalogue'">Catalogue</button>
        <button onclick="window.location.href='index.php?page=connexion'">Se connecter / Créer un compte</button>
    </div>
</div>

<section class="gallery-section">
    <h2>La sélection du mois</h2>
    <div class="gallery">
        <?php
        try {
            // Sélectionner 3 albums max pour l'accueil depuis la vraie table `album`
            $stmt = $conn->query("SELECT * FROM album LIMIT 3");
            $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($albums) > 0) {
                foreach ($albums as $album) {
                    $imagePath = !empty($album['cover']) ? htmlspecialchars($album['cover']) : 'assets/default.png';
                    $titre = isset($album['nom']) ? htmlspecialchars($album['nom']) : 'Titre inconnu';
                    $artiste = isset($album['artiste']) ? htmlspecialchars($album['artiste']) : 'Artiste inconnu';

                    echo '<a href="index.php?page=detail&id=' . urlencode($album['id_album']) . '" class="gallery-item" style="text-decoration:none;">';
                    echo '<img src="' . $imagePath . '" alt="Cover de ' . $titre . '">';
                    echo '<div class="album-info">';
                    echo '<div class="album-title">' . $titre . '</div>';
                    echo '<div class="album-artist">' . $artiste . '</div>';
                    echo '</div>';
                    echo '</a>';
                }
            } else {
                throw new PDOException("Empty table");
            }
        } catch (PDOException $e) {
            echo '<p class="alert-warning">Info : Base de données non connectée ou table manquante.</p>';
        }
        ?>
    </div>
</section>