<?php
$host = "localhost";
$dbname = "bdturismo";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Linha modificada para maior compatibilidade:
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8");
} catch(PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>