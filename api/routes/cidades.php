<?php
$db = require_once __DIR__ . '/../../includes/config.php';

// Requisição
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
                $stmt = $db->prepare("SELECT * FROM t_cidades WHERE id = ?");
                $stmt->execute([$resourceId]);
                $cidade = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($cidade) {
                    echo json_encode($cidade);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Cidade não encontrada']);
                }
            } else {
                $stmt = $db->query("SELECT * FROM t_cidades");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'POST':
            if (empty($data['nome']) || empty($data['estado'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Campos obrigatórios: nome e estado']);
                exit;
            }

            $stmt = $db->prepare("INSERT INTO t_cidades (nome, estado, pais) VALUES (?, ?, ?)");
            $stmt->execute([
                $data['nome'],
                $data['estado'],
                $data['pais'] ?? 'Angola'
            ]);

            echo json_encode(['success' => 'Cidade criada com sucesso', 'id' => $db->lastInsertId()]);
            break;

        case 'PUT':
            if (empty($resourceId)) {
                http_response_code(400);
                echo json_encode(['error' => 'ID da cidade não informado']);
                exit;
            }

            if (empty($data['nome']) || empty($data['estado'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Campos obrigatórios: nome e estado']);
                exit;
            }

            $stmt = $db->prepare("UPDATE t_cidades SET nome = ?, estado = ?, pais = ? WHERE id = ?");
            $stmt->execute([
                $data['nome'],
                $data['estado'],
                $data['pais'] ?? 'Angola',
                $resourceId
            ]);

            echo json_encode(['success' => 'Cidade atualizada com sucesso']);
            break;

        case 'DELETE':
            if (empty($resourceId)) {
                http_response_code(400);
                echo json_encode(['error' => 'ID da cidade não informado']);
                exit;
            }

            // Verifica se tem pontos turísticos
            $verifica = $db->prepare("SELECT COUNT(*) FROM t_pontos_turisticos WHERE cidade_id = ?");
            $verifica->execute([$resourceId]);

            if ($verifica->fetchColumn() > 0) {
                http_response_code(400);
                echo json_encode(['error' => 'Não é possível excluir: existem pontos turísticos vinculados']);
                exit;
            }

            $stmt = $db->prepare("DELETE FROM t_cidades WHERE id = ?");
            $stmt->execute([$resourceId]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => 'Cidade excluída com sucesso']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Cidade não encontrada']);
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
