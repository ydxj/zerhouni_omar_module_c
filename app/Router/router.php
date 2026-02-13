<?php 

require_once './zerhouni_omar_module_c/app/Controllers/AuthController.php';
require_once './zerhouni_omar_module_c/app/Controllers/AdminController.php';
require_once './zerhouni_omar_module_c/app/Controllers/GameController.php';
require_once './zerhouni_omar_module_c/app/Controllers/UserController.php';

$url = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$authController = new AuthController();
$adminController = new AdminController();
$gameController = new GameController();
$userController = new UserController();

switch ($url) {
    case '/api/test':
        echo json_encode(['status' => 'success', 'message' => 'API is working']);
        break;
    case '/api/auth/login':

        break;
    case '/api/auth/register':

        break;
    case '/api/v1/games':

        break;
    case '/api/v1/games/:slug':

        break;
    case '/games/:slug/:version/':

        break;
    case ' /api/v1/games/:slug':

        break;
    default:
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Endpoint not found']);
}


?>