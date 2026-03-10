<?php

$port = 3308; 
$host = "localhost";
$dbname = "jasminerecordsbdd";
$user = "jsrecords";
$pass = "Jajajolie1!";

$conn = new PDO("mysql:host=$host; port=$port; dbname=$dbname", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Connexion réussie";
?>