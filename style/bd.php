<?php

$port = 3306; 
$host = "localhost";
$dbname = "jasminerecordsbdd";
$user = "jsrecords";
$pass = "jsrecords2026";

$conn = new PDO("mysql:host=$host; port=$port; dbname=$dbname", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>