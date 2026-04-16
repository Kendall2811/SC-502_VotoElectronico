<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Si es una petición OPTIONS, podemos salir inmediatamente.
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once 'config/Database.php';

// Controllers y Models
include_once 'models/Usuario.php';
include_once 'controllers/UsuarioController.php';

include_once 'models/Eleccion.php';
include_once 'controllers/EleccionController.php';

include_once 'models/Candidato.php';
include_once 'controllers/CandidatoController.php';

include_once 'models/Voto.php';
include_once 'controllers/VotoController.php';

$controllerName = isset($_GET['controller']) ? $_GET['controller'] : '';
$actionName = isset($_GET['action']) ? $_GET['action'] : '';

$database = new Database();
$db = $database->getConnection();

if (!$controllerName || !$actionName) {
    echo json_encode(["message" => "Endpoint no válido"]);
    exit();
}

switch($controllerName) {
    case 'Usuario':
        $usuarioController = new UsuarioController($db);
        if ($actionName == 'login') {
            $usuarioController->login();
        } else if ($actionName == 'registrar') {
            $usuarioController->registrar();
        }
        break;
    case 'Eleccion':
        $eleccionController = new EleccionController($db);
        if ($actionName == 'crear') {
            $eleccionController->crear();
        } else if ($actionName == 'leer') {
            $eleccionController->leer();
        }
        break;
    case 'Candidato':
        $candidatoController = new CandidatoController($db);
        if ($actionName == 'registrar') {
            $candidatoController->registrar();
        } else if ($actionName == 'leerPorEleccion') {
            $candidatoController->leerPorEleccion();
        }
        break;
    case 'Voto':
        $votoController = new VotoController($db);
        if ($actionName == 'emitir') {
            $votoController->emitir();
        } else if ($actionName == 'resultados') {
            $votoController->resultados();
        }
        break;
    default:
        echo json_encode(["message" => "Controlador no encontrado"]);
        break;
}
?>
