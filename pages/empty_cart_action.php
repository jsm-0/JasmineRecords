<?php
session_start();
if (isset($_SESSION['panier'])) {
    unset($_SESSION['panier']);
}
header('Location: ../index.php?page=panier&success=checkout');
exit;
