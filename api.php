<?php
require_once 'Database.php'; 
require_once 'BookController.php';

// --- CONFIGURAÇÃO E HEADERS ---
// Define que a resposta será JSON
header('Content-Type: application/json');
// Permite requisições de qualquer origem (CORS - útil para desenvolvimento)
header('Access-Control-Allow-Origin: *');
// Permite todos os métodos RESTful necessários
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$method = $_SERVER['REQUEST_METHOD'];
$db = new Database();
$controller = new BookController($db);
$response = ['success' => false, 'data' => null, 'error' => ''];

// Tenta obter o ID da URL (para GET único, PUT e DELETE)
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Tenta ler o corpo da requisição (para POST e PUT)
$inputData = [];
if (in_array($method, ['POST', 'PUT'])) {
    $input = file_get_contents('php://input');
    // CRUCIAL: Decodifica o JSON do corpo da requisição
    $inputData = json_decode($input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'error' => 'Invalid JSON payload.']);
        exit;
    }
}

// --- ROTEAMENTO POR MÉTODO HTTP ---

try {
    switch ($method) {
        case 'GET':
            if ($id) {
                // GET /api.php?id=X (Leitura de um único recurso)
                $response['data'] = $controller->getBookById($id);
            } else {
                // GET /api.php (Leitura de todos os recursos)
                $response['data'] = $controller->getAllBooks();
            }
            break;

        case 'POST':
            // POST /api.php (Criação de novo recurso)
            $response['data'] = $controller->createBook($inputData);
            http_response_code(201); // 201 Created: Padrão para POST bem-sucedido
            break;

        case 'PUT':
            if (!$id) {
                 throw new Exception("Book ID is required for PUT request.", 400);
            }
            // PUT /api.php?id=X (Atualização completa ou parcial do recurso)
            $response['data'] = $controller->updateBook($id, $inputData);
            break;
            
        case 'DELETE':
            if (!$id) {
                 throw new Exception("Book ID is required for DELETE request.", 400);
            }
            // DELETE /api.php?id=X (Exclusão do recurso)
            $controller->deleteBook($id);
            $response['data'] = ['message' => "Book with ID {$id} deleted successfully."];
            http_response_code(204); // 204 No Content: Padrão para DELETE bem-sucedido
            break;

        case 'OPTIONS':
            // Resposta para requisições pre-flight do CORS
            http_response_code(200);
            exit;

        default:
            http_response_code(405); // 405 Method Not Allowed
            throw new Exception("Method not allowed.", 405);
    }
    
    $response['success'] = true;

} catch (Exception $e) {
    // Captura exceções e usa o código HTTP definido na exceção ou 500
    $code = $e->getCode() ?: 500;
    http_response_code($code);
    $response['success'] = false;
    $response['error'] = $e->getMessage();
}

// Em caso de DELETE (204 No Content), a resposta deve ser vazia.
if (http_response_code() !== 204) {
    echo json_encode($response);
}
