<?php
require_once '../includes/config.php';

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = $_GET['id'];

// Verifica se a categoria existe
$stmt = $db->prepare("SELECT id FROM t_categorias WHERE id = ?");
$stmt->execute([$id]);

if ($stmt->fetch()) {
    // Verifica se há pontos turísticos associados
    $stmt = $db->prepare("SELECT id FROM t_pontos_turisticos WHERE categoria_id = ?");
    $stmt->execute([$id]);
    
    if ($stmt->fetch()) {
        header("Location: listar.php?error=1");
    } else {
        // Exclui a categoria
        $stmt = $db->prepare("DELETE FROM t_categorias WHERE id = ?");
        $stmt->execute([$id]);
        
        header("Location: listar.php?success=3");
    }
} else {
    header("Location: listar.php");
}
exit;
?>