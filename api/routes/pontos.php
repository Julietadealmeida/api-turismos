<?php
// Conexão com o banco de dados
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

// Extrai o ID da URI (somente se for número)
$parts = explode('/', trim($uri, '/'));
$last = end($parts);
$resourceId = is_numeric($last) ? $last : null;

try {
    switch ($method) {
        // Buscar todos ou um ponto específico
        case 'GET':
            if (!empty($resourceId)) {
                // Buscar por ID
                $stmt = $db->prepare("SELECT * FROM t_pontos_turisticos WHERE id = ?");
                $stmt->execute([$resourceId]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    echo json_encode($result);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Ponto não encontrado']);
                }
            } else {
                // Listar todos
                $stmt = $db->query("SELECT * FROM t_pontos_turisticos");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        // Cadastrar novo ponto turístico
        case 'POST':
            $required = ['nome', 'cidade_id', 'categoria_id'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    http_response_code(400);
                    echo json_encode(['error' => "Campo obrigatório faltando: $field"]);
                    exit;
                }
            }

            $stmt = $db->prepare("INSERT INTO t_pontos_turisticos (nome, cidade_id, categoria_id) VALUES (?, ?, ?)");
            $stmt->execute([
                $data['nome'],
                $data['cidade_id'],
                $data['categoria_id']
            ]);
            echo json_encode(['success' => 'Ponto cadastrado com sucesso']);
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
