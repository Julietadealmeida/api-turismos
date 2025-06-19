<?php
$host = "localhost";
$dbname = "bdturismo";
$username = "root";
$password = "";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES utf8");

    return $db; // retorna a conexão para uso externo
} catch(PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>
