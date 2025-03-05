<?php


$host = "localhost";
$dbname = "plastic_shop";
$user = "root";
$pass = "";


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("database Error" . $e->getMessage());
}
