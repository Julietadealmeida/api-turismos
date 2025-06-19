<?php
require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'],
        'estado' => $_POST['estado'],
        'pais' => $_POST['pais']
    ];

    $sql = "INSERT INTO t_cidades (nome, estado, pais) VALUES (?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    if ($stmt->execute(array_values($dados))) {
        header("Location: listar.php?success=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cidade</title>
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
        <h1 class="mb-4">Cadastrar Cidade</h1>
        
        <form method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="estado" class="form-label">Estado</label>
                    <input type="text" class="form-control" id="estado" name="estado" required>
                </div>
                <div class="col-md-6">
                    <label for="pais" class="form-label">País</label>
                    <input type="text" class="form-control" id="pais" name="pais" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <a href="../index.php" class="btn btn-secondary ms-2">Voltar para Página Inicial</a>
        </form>
        
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>