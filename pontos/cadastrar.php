<?php
$db = require_once '../includes/config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'],
        'descricao' => $_POST['descricao'],
        'cidade_id' => $_POST['cidade_id'],
        'categoria_id' => $_POST['categoria_id'],
        'endereco' => $_POST['endereco'] ?? null,
        'horario' => $_POST['horario'] ?? null,
        'latitude' => $_POST['latitude'] ?? null,
        'longitude' => $_POST['longitude'] ?? null
    ];

    $sql = "INSERT INTO t_pontos_turisticos 
            (nome, descricao, cidade_id, categoria_id, endereco, horario, latitude, longitude) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    if ($stmt->execute(array_values($dados))) {
        header("Location: listar.php?success=1");
        exit;
    }
}

// Busca cidades e categorias para os selects
$cidades = $db->query("SELECT * FROM t_cidades")->fetchAll();
$categorias = $db->query("SELECT * FROM t_categorias")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Ponto Turístico</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 20px;
        }
        .form-title {
            color: #0d6efd;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        .btn-submit {
            padding: 10px 25px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .nav-link {
            font-weight: 500;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .coordinate-input {
            font-family: monospace;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Turismo API</a>
            <div class="navbar-nav">
                <a class="nav-link" href="listar.php">Voltar para Lista</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="mb-4">Cadastrar Ponto Turístico</h1>
        
        <form method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cidade_id" class="form-label">Cidade</label>
                    <select class="form-select" id="cidade_id" name="cidade_id" required>
                        <option value="">Selecione uma cidade</option>
                        <?php foreach ($cidades as $cidade): ?>
                        <option value="<?= $cidade['id'] ?>"><?= htmlspecialchars($cidade['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="categoria_id" class="form-label">Categoria</label>
                    <select class="form-select" id="categoria_id" name="categoria_id" required>
                        <option value="">Selecione uma categoria</option>
                        <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <input type="text" class="form-control" id="endereco" name="endereco">
            </div>
            
            <div class="mb-3">
                <label for="horario" class="form-label">Horário de Funcionamento</label>
                <input type="text" class="form-control" id="horario" name="horario" placeholder="Ex: 08:00-18:00">
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="text" class="form-control" id="latitude" name="latitude">
                </div>
                <div class="col-md-6">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input type="text" class="form-control" id="longitude" name="longitude">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <a href="../index.php" class="btn btn-secondary ms-2">Voltar para Página Inicial</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
