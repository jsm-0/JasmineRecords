<div class="content">
    <h1 class="page-title">Notre Catalogue</h1>

    <!-- Filtres par genre -->
    <div class="filters">
        <?php $current_genre = isset($_GET['genre']) ? $_GET['genre'] : ''; ?>
        <a href="index.php?page=catalogue" class="btn-filter <?= $current_genre === '' ? 'active' : '' ?>">Tous</a>
        <a href="index.php?page=catalogue&genre=Pop"
            class="btn-filter <?= $current_genre === 'Pop' ? 'active' : '' ?>">Pop</a>
        <a href="index.php?page=catalogue&genre=R%26B"
            class="btn-filter <?= $current_genre === 'R&B' ? 'active' : '' ?>">R&B</a>
        <a href="index.php?page=catalogue&genre=Rap"
            class="btn-filter <?= $current_genre === 'Rap' ? 'active' : '' ?>">Rap</a>
    </div>

    <section class="gallery-section">
        <h2><?php echo $current_genre ? 'Albums : ' . htmlspecialchars($current_genre) : 'Tous les albums disponibles'; ?>
        </h2>
        <div class="gallery">
            <?php
            try {
                // Tentative de récupération des albums en joignant la table `genre` (l'id du genre est stocké dans l'album)
                $sql = "SELECT album.*, genre.nom AS nom_genre FROM album LEFT JOIN genre ON album.genre = genre.id_genre";
                $params = [];

                if ($current_genre) {
                    $sql .= " WHERE UPPER(genre.nom) = UPPER(:genre)";
                    $params[':genre'] = $current_genre;
                }

                $stmt = $conn->prepare($sql);
                $stmt->execute($params);
                $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($albums) > 0) {
                    foreach ($albums as $album) {
                        $imagePath = !empty($album['cover']) ? htmlspecialchars($album['cover']) : 'assets/default.png';
                        $titre = isset($album['nom']) ? htmlspecialchars($album['nom']) : 'Titre inconnu';
                        $artiste = isset($album['artiste']) ? htmlspecialchars($album['artiste']) : 'Artiste inconnu';
                        $prix = isset($album['prix']) ? number_format($album['prix'], 2) . ' €' : 'NC';

                        echo '<a href="index.php?page=detail&id=' . urlencode($album['id_album']) . '" class="gallery-item">';
                        echo '<img src="' . $imagePath . '" alt="Cover de ' . $titre . '">';
                        echo '<div class="album-info">';
                        echo '<div class="album-title">' . $titre . '</div>';
                        echo '<div class="album-artist">' . $artiste . '</div>';
                        if ($prix !== 'NC')
                            echo '<div class="album-price">' . $prix . '</div>';
                        echo '</div>';
                        echo '</a>';
                    }
                } else {
                    echo '<p class="no-results">Aucun album trouvé pour cette catégorie dans la base de données.</p>';
                }
            } catch (PDOException $e) {
                ?>
                <p class="alert-warning">
                    Info : Base de données non connectée ou table manquante.
                </p>
                <?php

                if ($current_genre) {
                    $fallbackAlbums = array_filter($fallbackAlbums, function ($a) use ($current_genre) {
                        return $a['genre'] === $current_genre;
                    });
                }
                if (count($fallbackAlbums) > 0) {
                    foreach ($fallbackAlbums as $album) {
                        echo '<a href="index.php?page=detail&id=' . urlencode($album['id']) . '" class="gallery-item">';
                        echo '<img src="' . htmlspecialchars($album['cover']) . '" alt="' . htmlspecialchars($album['titre']) . ' album cover">';
                        echo '<div class="album-info">';
                        echo '<div class="album-title">' . htmlspecialchars($album['titre']) . '</div>';
                        echo '<div class="album-artist">' . htmlspecialchars($album['artiste']) . '</div>';
                        echo '<div class="album-price">' . htmlspecialchars($album['prix']) . ' €</div>';
                        echo '</div>';
                        echo '</a>';
                    }
                } else {
                    echo '<p class="no-results">Aucun album trouvé pour cette catégorie.</p>';
                }
            }
            ?>
        </div>
    </section>
</div>