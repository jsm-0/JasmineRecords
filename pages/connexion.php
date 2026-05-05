<?php
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        try {
            $stmt = $conn->prepare("SELECT * FROM client WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['mot_de_passe'])) {
                $success = "Connexion réussie ! Bienvenue " . htmlspecialchars($user['prenom'] ?? '');
                // session_start(); $_SESSION['client_id'] = $user['id_client'];
            } else {
                $error = "Identifiants incorrects ou base de données non configurée.";
            }
        } catch (PDOException $e) {
            $error = "Erreur de base de données (la table utilisateurs n'existe pas encore). Mode demo : Erreur ignorée.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<div class="content">
    <h1 class="page-title">Connexion</h1>

    <div class="form-container">
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="index.php?page=connexion" method="POST">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required placeholder="votre@email.com">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required placeholder="Votre mot de passe">
            </div>

            <button type="submit" class="btn-submit">Se connecter</button>
        </form>

        <div class="signup-link">
            <p>Pas encore de compte ? <a href="index.php?page=inscription">Créer un compte</a></p>
        </div>
    </div>
</div>