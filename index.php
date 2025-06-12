<?php
require_once './includes/config.php';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração - Turismo API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Turismo API</a>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-center mb-5">Painel de Administração</h1>
        
        <div class="row g-4">
            <!-- Pontos Turísticos -->
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="feature-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <h3>Pontos Turísticos</h3>
                    <div class="d-grid gap-2 mt-3">
                        <a href="pontos/listar.php" class="btn btn-outline-primary">Listar</a>
                        <a href="pontos/cadastrar.php" class="btn btn-outline-success">Cadastrar</a>
                    </div>
                </div>
            </div>
            
            <!-- Cidades -->
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="feature-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h3>Cidades</h3>
                    <div class="d-grid gap-2 mt-3">
                        <a href="cidades/listar.php" class="btn btn-outline-primary">Listar</a>
                        <a href="cidades/cadastrar.php" class="btn btn-outline-success">Cadastrar</a>
                    </div>
                </div>
            </div>
            
            <!-- Categorias -->
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="feature-icon">
                        <i class="bi bi-tags"></i>
                    </div>
                    <h3>Categorias</h3>
                    <div class="d-grid gap-2 mt-3">
                        <a href="categorias/listar.php" class="btn btn-outline-primary">Listar</a>
                        <a href="categorias/cadastrar.php" class="btn btn-outline-success">Cadastrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</body>
</html>