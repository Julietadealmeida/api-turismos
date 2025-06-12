<?php
require_once '../includes/config.php';

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = $_GET['id'];

// Verifica se a cidade existe
$stmt = $conn->prepare("SELECT id FROM t_cidades WHERE id = ?");
$stmt->execute([$id]);

if ($stmt->fetch()) {
    // Verifica se há pontos turísticos associados
    $stmt = $conn->prepare("SELECT id FROM t_pontos_turisticos WHERE cidade_id = ?");
    $stmt->execute([$id]);
    
    if ($stmt->fetch()) {
        header("Location: listar.php?error=1");
    } else {
        // Exclui a cidade
        $stmt = $conn->prepare("DELETE FROM t_cidades WHERE id = ?");
        $stmt->execute([$id]);
        
        header("Location: listar.php?success=3");
    }
} else {
    header("Location: listar.php");
}
exit;
?>