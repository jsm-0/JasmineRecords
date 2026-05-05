<?php
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if ($password !== $password_confirm) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (!empty($email) && !empty($password)) {
        try {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO client (email, nom, prenom, adresse, mot_de_passe) VALUES (:email, :nom, :prenom, :adresse, :mot_de_passe)");
            $stmt->execute([
                'email' => $email,
                'nom' => $nom,
                'prenom' => $prenom,
                'adresse' => $adresse,
                'mot_de_passe' => $hashed
            ]);
            $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        } catch (PDOException $e) {
            $error = "Erreur SQL : L'email est peut-être déjà pris ou la table client pose problème.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<div class="content">
    <h1 class="page-title">Inscription</h1>
    
    <div class="form-container">
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="index.php?page=inscription" method="POST">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required placeholder="votre@email.com">
            </div>
            
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required placeholder="Votre nom">
            </div>

            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required placeholder="Votre prénom">
            </div>

            <div class="form-group">
                <label for="adresse">Adresse :</label>
                <input type="text" id="adresse" name="adresse" required placeholder="Votre adresse complète">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required placeholder="Créer un mot de passe">
            </div>
            
            <div class="form-group">
                <label for="password_confirm">Confirmation du mot de passe :</label>
                <input type="password" id="password_confirm" name="password_confirm" required placeholder="Confirmer le mot de passe">
            </div>

            <button type="submit" class="btn-submit">Créer un compte</button>
        </form>

        <div class="signup-link">
            <p>Vous avez un compte ? <a href="index.php?page=connexion">Se connecter</a></p>
        </div>
    </div>
</div>