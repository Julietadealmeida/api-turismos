<?php
require_once '../includes/config.php';

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = $_GET['id'];

// Busca a cidade
$stmt = $conn->prepare("SELECT * FROM t_cidades WHERE id = ?");
$stmt->execute([$id]);
$cidade = $stmt->fetch();

if (!$cidade) {
    header("Location: listar.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'],
        'estado' => $_POST['estado'],
        'pais' => $_POST['pais'],
        'id' => $id
    ];

    $sql = "UPDATE t_cidades SET nome = ?, estado = ?, pais = ? WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array_values($dados))) {
        header("Location: listar.php?success=2");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cidade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h1 class="mb-4">Editar Cidade</h1>
        
        <form method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($cidade['nome']) ?>" required>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="estado" class="form-label">Estado</label>
                    <input type="text" class="form-control" id="estado" name="estado" value="<?= htmlspecialchars($cidade['estado']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="pais" class="form-label">País</label>
                    <input type="text" class="form-control" id="pais" name="pais" value="<?= htmlspecialchars($cidade['pais']) ?>" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="listar.php" class="btn btn-secondary ms-2">Voltar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>