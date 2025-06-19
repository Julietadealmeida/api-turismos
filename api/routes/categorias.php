<?php
$db = require_once __DIR__ . '/../../includes/config.php';

// Captura os dados da requisição
$request = [
    'method' => $_SERVER['REQUEST_METHOD'],
    'uri'    => $_SERVER['REQUEST_URI'],
    'input'  => json_decode(file_get_contents('php://input'), true) ?? [],
];

$method = $request['method'];
$uri = $request['uri'];
$data = $request['input'];

// Extrai o ID da URI se for numérico
$parts = explode('/', trim($uri, '/'));
$last = end($parts);
$resourceId = is_numeric($last) ? $last : null;

try {
    switch ($method) {
        case 'GET':
            if (!empty($resourceId)) {
                $stmt = $db->prepare("SELECT * FROM t_categorias WHERE id = ?");
                $stmt->execute([$resourceId]);
                $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($categoria) {
                    echo json_encode($categoria);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Categoria não encontrada']);
                }
            } else {
                $stmt = $db->query("SELECT * FROM t_categorias");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'POST':
            if (empty($data['nome'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Nome da categoria é obrigatório']);
                exit;
            }

            $stmt = $db->prepare("INSERT INTO t_categorias (nome) VALUES (?)");
            $stmt->execute([$data['nome']]);

            echo json_encode(['success' => 'Categoria criada com sucesso', 'id' => $db->lastInsertId()]);
            break;

        case 'PUT':
            if (empty($resourceId)) {
                http_response_code(400);
                echo json_encode(['error' => 'ID da categoria não informado']);
                exit;
            }

            if (empty($data['nome'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Nome da categoria é obrigatório']);
                exit;
            }

            $stmt = $db->prepare("UPDATE t_categorias SET nome = ? WHERE id = ?");
            $stmt->execute([$data['nome'], $resourceId]);

            echo json_encode(['success' => 'Categoria atualizada com sucesso']);
            break;

        case 'DELETE':
            if (empty($resourceId)) {
                http_response_code(400);
                echo json_encode(['error' => 'ID da categoria não informado']);
                exit;
            }

            // Verifica se existem pontos turísticos vinculados
            $stmt = $db->prepare("SELECT COUNT(*) FROM t_pontos_turisticos WHERE categoria_id = ?");
            $stmt->execute([$resourceId]);

            if ($stmt->fetchColumn() > 0) {
                http_response_code(400);
                echo json_encode(['error' => 'Não é possível excluir: existem pontos turísticos vinculados']);
                exit;
            }

            $stmt = $db->prepare("DELETE FROM t_categorias WHERE id = ?");
            $stmt->execute([$resourceId]);

            if ($stmt->rowCount() === 0) {
                http_response_code(404);
                echo json_encode(['error' => 'Categoria não encontrada']);
            } else {
                echo json_encode(['success' => 'Categoria excluída com sucesso']);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
