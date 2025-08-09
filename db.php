<?php
session_start();
$host = "localhost";
$dbname = "dbfw4gssj5mgf6";
$username = "uac1gp3zeje8t";
$password = "hk8ilpc7us2e";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
