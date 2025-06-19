<?php
require_once '../includes/config.php';

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = $_GET['id'];

// Verifica se o ponto existe
$stmt = $conn->prepare("SELECT id FROM t_pontos_turisticos WHERE id = ?");
$stmt->execute([$id]);

if ($stmt->fetch()) {
    // Exclui o ponto
    $stmt = $conn->prepare("DELETE FROM t_pontos_turisticos WHERE id = ?");
    $stmt->execute([$id]);
    
    header("Location: listar.php?success=3");
} else {
    header("Location: listar.php");
}

exit;

?>