<?php
require_once __DIR__ . '/routes/cidades.php';
require_once __DIR__ . '/routes/categorias.php';
require_once __DIR__ . '/routes/pontos.php';
// ... outros includes de rotas

echo json_encode(['status' => 'API Turismo funcionando']);




header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Dados da requisição
$request = [
    'method' => $_SERVER['REQUEST_METHOD'],
    'uri' => parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
    'query' => $_GET,
    'input' => json_decode(file_get_contents('php://input'), true)
];

// Extrai o endpoint (ex: 'pontos' de '/api/pontos')
$endpoint = explode('/', trim(str_replace('/api', '', $request['uri']), '/'))[0];

if (empty($endpoint)) {
    http_response_code(400);
    echo json_encode(['error' => 'Endpoint não especificado']);
    exit;
}

// Arquivo de rota correspondente
$routeFile = __DIR__ . '/routes/' . $endpoint . '.php';

if (file_exists($routeFile)) {
    // Injeta a conexão e os dados da requisição
    $db = $conn;
    require $routeFile;
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint não encontrado']);
}
?>