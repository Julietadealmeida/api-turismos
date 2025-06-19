<?php
require_once '../includes/config.php';

// Search functionality
$search = $_GET['search'] ?? '';
$query = "SELECT * FROM t_categorias";
$params = [];

if (!empty($search)) {
    $query .= " WHERE nome LIKE :search";
    $params[':search'] = '%' . $search . '%';
}

$stmt = $db->prepare($query);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$categorias = $stmt->fetchAll();

$mensagem = '';
if (isset($_GET['success'])) {
    $mensagem = match($_GET['success']) {
        '1' => '<div class="alert alert-success">Categoria cadastrada com sucesso!</div>',
        '2' => '<div class="alert alert-success">Categoria atualizada com sucesso!</div>',
        '3' => '<div class="alert alert-success">Categoria excluída com sucesso!</div>',
        default => ''
    };
}

if (isset($_GET['error'])) {
    $mensagem = '<div class="alert alert-danger">Não é possível excluir a categoria pois existem pontos turísticos vinculados a ela.</div>';
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorias</title>
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
                <a class="nav-link" href="cadastrar.php">Cadastrar Nova</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="mb-4">Categorias</h1>
        
        <?= $mensagem ?>
        <!-- Barra de Pesquisa Melhorada -->
        <div class="search-container">
            <form method="GET" class="search-form">
                <input type="text" 
                       name="search" 
                       class="form-control search-input" 
                       placeholder="Pesquisar por nome..." 
                       value="<?= htmlspecialchars($search) ?>"
                       aria-label="Pesquisar categorias">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Buscar
                </button>
                <?php if (!empty($search)): ?>
                    <a href="listar.php" class="btn btn-outline-secondary btn-clear">
                        <i class="bi bi-x-circle"></i> Limpar
                    </a>
                <?php endif; ?>
            </form>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categorias)): ?>
                        <tr>
                            <td colspan="3" class="no-results">Nenhuma categoria encontrada</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <td><?= $categoria['id'] ?></td>
                            <td><?= htmlspecialchars($categoria['nome']) ?></td>
                            <td>
                                <a href="editar.php?id=<?= $categoria['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="excluir.php?id=<?= $categoria['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-between mt-3">
                <a href="cadastrar.php" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Cadastrar Nova Categoria
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