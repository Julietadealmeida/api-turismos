<?php
require_once '../includes/config.php';

// Verifica se há um termo de pesquisa
$termo = $_GET['search'] ?? '';

// Consulta SQL base
$sql = "
    SELECT p.*, c.nome as cidade, cat.nome as categoria 
    FROM t_pontos_turisticos p
    LEFT JOIN t_cidades c ON p.cidade_id = c.id
    LEFT JOIN t_categorias cat ON p.categoria_id = cat.id
";

// Adiciona filtro de pesquisa se houver termo
if (!empty($termo)) {
    $termo = '%' . $termo . '%';
    $sql .= " WHERE p.nome LIKE :termo OR c.nome LIKE :termo OR cat.nome LIKE :termo";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':termo', $termo);
    $stmt->execute();
    $pontos = $stmt->fetchAll();
} else {
    $pontos = $db->query($sql)->fetchAll();
}

$mensagem = '';
if (isset($_GET['success'])) {
    $mensagem = match($_GET['success']) {
        '1' => '<div class="alert alert-success">Ponto turístico cadastrado com sucesso!</div>',
        '2' => '<div class="alert alert-success">Ponto turístico atualizado com sucesso!</div>',
        '3' => '<div class="alert alert-success">Ponto turístico excluído com sucesso!</div>',
        default => ''
    };
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pontos Turísticos</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .search-container {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .search-form {
            display: flex;
            gap: 10px;
        }
        .search-input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .no-results {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-style: italic;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .btn-clear {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Turismo API</a>
            <div class="navbar-nav">
                <a class="nav-link" href="cadastrar.php">Cadastrar Novo</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="mb-4">Pontos Turísticos</h1>
        
        <?= $mensagem ?>
        
        <!-- Barra de Pesquisa -->
        <div class="search-container">
            <form method="GET" class="search-form">
                <input type="text" 
                       name="search" 
                       class="form-control search-input" 
                       placeholder="Pesquisar por nome, cidade ou categoria..." 
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <?php if (!empty($_GET['search'])): ?>
                    <a href="listar.php" class="btn btn-outline-secondary">Limpar</a>
                <?php endif; ?>
            </form>
        </div>
        
         <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Cidade</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($pontos) > 0): ?>
                        <?php foreach ($pontos as $ponto): ?>
                        <tr>
                            <td><?= $ponto['id'] ?></td>
                            <td><?= htmlspecialchars($ponto['nome']) ?></td>
                            <td><?= htmlspecialchars($ponto['cidade']) ?></td>
                            <td><?= htmlspecialchars($ponto['categoria']) ?></td>
                            <td>
                                <a href="detalhes.php?id=<?= $ponto['id'] ?>" class="btn btn-sm btn-info">Ver</a>
                                <a href="editar.php?id=<?= $ponto['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="excluir.php?id=<?= $ponto['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-results">
                                Nenhum ponto turístico encontrado <?= !empty($termo) ? 'para "' . htmlspecialchars($_GET['search']) . '"' : '' ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-between mt-3">
                <a href="cadastrar.php" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Cadastrar Novo Ponto
                </a>
                <a href="../index.php" class="btn btn-secondary">
                    <i class="bi bi-house"></i> Voltar para Página Inicial
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>