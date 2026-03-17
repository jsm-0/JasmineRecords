<?php
    $page = isset($_GET['page']) ? $_GET['page'] : 'acceuil';
    $pages_valides = ['acceuil', 'catalogue', 'connexion', 'inscription', 'apropos'];
    
    if (!in_array($page, $pages_valides)) {
        $page = 'acceuil';
    }
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jasmine Records</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <?php include 'components/header.php'; ?>
    <nav></nav>

    <main>
        <?php include 'pages/' . $page . '.php'; ?>
    </main>

    <footer>
        <?php include 'components/footer.php'; ?>
    </footer>
</body>

</html>