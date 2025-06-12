<?php
require_once '../includes/config.php';

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = $_GET['id'];

// Busca o ponto turístico
$stmt = $conn->prepare("SELECT * FROM t_pontos_turisticos WHERE id = ?");
$stmt->execute([$id]);
$ponto = $stmt->fetch();

if (!$ponto) {
    header("Location: listar.php");
    exit;
}

// Busca cidades e categorias para os selects
$cidades = $conn->query("SELECT * FROM t_cidades")->fetchAll();
$categorias = $conn->query("SELECT * FROM t_categorias")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'],
        'descricao' => $_POST['descricao'],
        'cidade_id' => $_POST['cidade_id'],
        'categoria_id' => $_POST['categoria_id'],
        'endereco' => $_POST['endereco'] ?? null,
        'horario' => $_POST['horario'] ?? null,
        'latitude' => $_POST['latitude'] ?? null,
        'longitude' => $_POST['longitude'] ?? null,
        'id' => $id
    ];

    $sql = "UPDATE t_pontos_turisticos SET
            nome = ?, descricao = ?, cidade_id = ?, categoria_id = ?,
            endereco = ?, horario = ?, latitude = ?, longitude = ?
            WHERE id = ?";
    
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
    <title>Editar Ponto Turístico</title>
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
        <h1 class="mb-4">Editar Ponto Turístico</h1>
        
        <form method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($ponto['nome']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?= htmlspecialchars($ponto['descricao']) ?></textarea>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cidade_id" class="form-label">Cidade</label>
                    <select class="form-select" id="cidade_id" name="cidade_id" required>
                        <option value="">Selecione uma cidade</option>
                        <?php foreach ($cidades as $cidade): ?>
                        <option value="<?= $cidade['id'] ?>" <?= $cidade['id'] == $ponto['cidade_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cidade['nome']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="categoria_id" class="form-label">Categoria</label>
                    <select class="form-select" id="categoria_id" name="categoria_id" required>
                        <option value="">Selecione uma categoria</option>
                        <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id'] ?>" <?= $categoria['id'] == $ponto['categoria_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categoria['nome']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <input type="text" class="form-control" id="endereco" name="endereco" value="<?= htmlspecialchars($ponto['endereco']) ?>">
            </div>
            
            <div class="mb-3">
                <label for="horario" class="form-label">Horário de Funcionamento</label>
                <input type="text" class="form-control" id="horario" name="horario" value="<?= htmlspecialchars($ponto['horario']) ?>">
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="text" class="form-control" id="latitude" name="latitude" value="<?= htmlspecialchars($ponto['latitude']) ?>">
                </div>
                <div class="col-md-6">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input type="text" class="form-control" id="longitude" name="longitude" value="<?= htmlspecialchars($ponto['longitude']) ?>">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Atualizar</button>
          <a href="listar.php" class="btn btn-secondary ms-2">Voltar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>