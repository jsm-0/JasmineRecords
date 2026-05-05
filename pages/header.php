<nav class="header">
    <div class="logo">
        <a href="index.php"><img src="assets/logo.png" alt="Jasmine Records Logo" width="234" height="29"></a>
    </div>
    <ul>
        <li><a href="index.php?page=acceuil">Accueil</a></li>
        <li><a href="index.php?page=catalogue">Catalogue</a></li>
        <li><a href="index.php?page=apropos">À Propos</a></li>
        <?php if (isset($_SESSION['client_id'])): ?>
            <li><a href="index.php?page=panier">Panier</a></li>
            <li><a href="pages/deconnexion.php">Déconnexion (<?= htmlspecialchars($_SESSION['client_prenom'] ?? '') ?>)</a></li>
        <?php else: ?>
            <li><a href="index.php?page=panier">Panier</a></li>
            <li><a href="index.php?page=connexion">Connexion</a></li>
        <?php endif; ?>
    </ul>
</nav>