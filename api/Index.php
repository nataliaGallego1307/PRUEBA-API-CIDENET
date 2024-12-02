<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../config/Config.php';
include_once '../models/Employee.php';
include_once '../models/EmployeeType.php';
include_once '../models/Area.php';
include_once '../controllers/EmployeeController.php';
include_once '../utils/Validator.php';
include_once '../utils/EmailGenerator.php';

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Instanciar controlador
$controller = new EmployeeController($db);

// Manejar diferentes tipos de peticiones
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        // Leer el cuerpo de la solicitud
        $data = json_decode(file_get_contents("php://input"));

        // Validar que los datos no estén vacíos
        if (empty((array)$data)) {
            http_response_code(400);
            echo json_encode(["error" => "No se recibieron datos."]);
            exit;
        }

        // Procesar el registro de empleados
        $result = $controller->create($data);

        // Configurar el código HTTP de respuesta
        http_response_code(isset($result['error']) ? 400 : 201);
        echo json_encode($result);
        break;

    case 'GET':
        // Obtener la ruta de la solicitud
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uriSegments = explode('/', $uri);

        // Procesar diferentes rutas
        if (end($uriSegments) === 'identification-types') {
            $result = $controller->getIdentificationTypes();
            echo json_encode($result);
        } elseif (end($uriSegments) === 'areas') {
            $result = $controller->getAreas();
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Ruta no encontrada."]);
        }
        break;

    default:
        // Respuesta para métodos no soportados
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido."]);
        break;
}
