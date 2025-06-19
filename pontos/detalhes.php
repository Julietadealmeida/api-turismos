<?php
require_once '../includes/config.php';

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = $_GET['id'];

// Busca o ponto turístico com informações de cidade e categoria
$stmt = $db->prepare("
    SELECT p.*, c.nome as cidade, c.estado, c.pais, cat.nome as categoria 
    FROM t_pontos_turisticos p
    LEFT JOIN t_cidades c ON p.cidade_id = c.id
    LEFT JOIN t_categorias cat ON p.categoria_id = cat.id
    WHERE p.id = ?
");
$stmt->execute([$id]);
$ponto = $stmt->fetch();

if (!$ponto) {
    header("Location: listar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Ponto Turístico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Turismo API</a>
            <div class="navbar-nav">
                <a class="nav-link" href="listar.php">Voltar para Lista</a>
                <a class="nav-link" href="editar.php?id=<?= $ponto['id'] ?>">Editar</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="mb-4"><?= htmlspecialchars($ponto['nome']) ?></h1>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Descrição</h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($ponto['descricao'])) ?></p>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Localização</h5>
                        <p class="card-text">
                            <strong>Endereço:</strong> <?= htmlspecialchars($ponto['endereco']) ?><br>
                            <strong>Horário:</strong> <?= htmlspecialchars($ponto['horario']) ?><br>
                            <strong>Coordenadas:</strong> <?= htmlspecialchars($ponto['latitude']) ?>, <?= htmlspecialchars($ponto['longitude']) ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Informações</h5>
                        <p class="card-text">
                            <strong>Cidade:</strong> <?= htmlspecialchars($ponto['cidade']) ?><br>
                            <strong>Estado:</strong> <?= htmlspecialchars($ponto['estado']) ?><br>
                            <strong>País:</strong> <?= htmlspecialchars($ponto['pais']) ?><br>
                            <strong>Categoria:</strong> <?= htmlspecialchars($ponto['categoria']) ?>
                        </p>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ações</h5>
                        <a href="editar.php?id=<?= $ponto['id'] ?>" class="btn btn-warning w-100 mb-2">Editar</a>
                        <a href="excluir.php?id=<?= $ponto['id'] ?>" class="btn btn-danger w-100" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>