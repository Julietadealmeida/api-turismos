<?php
require_once '../includes/config.php';

// Verifica se há um termo de pesquisa
$termo = $_GET['search'] ?? '';

// Consulta SQL base
$sql = "SELECT * FROM t_cidades";

// Adiciona filtro de pesquisa se houver termo
if (!empty($termo)) {
    $termo_like = '%' . $termo . '%';
    $sql .= " WHERE nome LIKE :termo OR estado LIKE :termo OR pais LIKE :termo";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':termo', $termo_like);
    $stmt->execute();
    $cidades = $stmt->fetchAll();
} else {
    $cidades = $db->query($sql)->fetchAll();
}

$mensagem = '';
if (isset($_GET['success'])) {
    $mensagem = match($_GET['success']) {
        '1' => '<div class="alert alert-success">Cidade cadastrada com sucesso!</div>',
        '2' => '<div class="alert alert-success">Cidade atualizada com sucesso!</div>',
        '3' => '<div class="alert alert-success">Cidade excluída com sucesso!</div>',
        default => ''
    };
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cidades</title>
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
        <h1 class="mb-4">Cidades</h1>
        
        <?= $mensagem ?>
        
        <!-- Barra de Pesquisa Melhorada -->
        <div class="search-container">
            <form method="GET" class="search-form">
                <input type="text" 
                       name="search" 
                       class="form-control search-input" 
                       placeholder="Pesquisar por nome, estado ou país..." 
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                       aria-label="Pesquisar cidades">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Buscar
                </button>
                <?php if (!empty($_GET['search'])): ?>
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
                        <th>Estado</th>
                        <th>País</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($cidades) > 0): ?>
                        <?php foreach ($cidades as $cidade): ?>
                        <tr>
                            <td><?= $cidade['id'] ?></td>
                            <td><?= htmlspecialchars($cidade['nome']) ?></td>
                            <td><?= htmlspecialchars($cidade['estado']) ?></td>
                            <td><?= htmlspecialchars($cidade['pais']) ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="editar.php?id=<?= $cidade['id'] ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <a href="excluir.php?id=<?= $cidade['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta cidade?')">
                                        <i class="bi bi-trash"></i> Excluir
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-results">
                                Nenhuma cidade encontrada <?= !empty($termo) ? 'para "' . htmlspecialchars($_GET['search']) . '"' : '' ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-between mt-3">
                <a href="cadastrar.php" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Cadastrar Nova Cidade
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