<?php

require_once __DIR__ . '/Models/Usuario.php';
require_once __DIR__ . '/Models/Partida.php';
require_once __DIR__ . '/Models/Rol.php';

require_once __DIR__ . '/DataBases/UsuarioDAO.php';
require_once __DIR__ . '/DataBases/PartidaDAO.php';
require_once __DIR__ . '/DataBases/RolDAO.php';

require_once __DIR__ . '/Controller/UsuarioController.php';
require_once __DIR__ . '/Controller/PartidaController.php';

require_once __DIR__ . '/config/mail.php';


$datos = json_decode(file_get_contents('php://input'), true);

// verificamos que luego no haya problemas
if (!isset($datos['username']) || !isset($datos['password'])) {
    http_response_code(401);
    echo json_encode(['error' => 'no has introducido alguna credencial  debes enviar username y password en el body ']);
} else {
    $username = $datos['username'];
    $password = $datos['password'];

    // verificamos credenciales
    try {
        $usuarioAutenticado = UsuarioDAO::verificarUsuarioLogin($username, $password);
        
        if (!$usuarioAutenticado) {
            http_response_code(401);
            echo json_encode(['error' => 'Credenciales incorrectas']);
        } else {
            
            $metodo = $_SERVER['REQUEST_METHOD'];
            $ruta = $_SERVER['REQUEST_URI'];

            $parametros = explode("/", $ruta);
            unset($parametros[0]);
            //Rutas ADMIN
            if (!empty($parametros[1]) && $parametros[1] === 'admin') {
        if ($usuarioAutenticado->getRolNombre() !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Acceso denegado. solo los administradores pueden acceder a este recurso']);
        }else{
            $controlador = new UsuarioController($usuarioAutenticado);
            
            //GET /admin/users
            if ($metodo === 'GET' && count($parametros) === 2 && $parametros[2] === 'users') {
                $controlador->getAllUsers();
            }
            // GET /admin/users/id
            elseif($metodo === 'GET' && count($parametros) === 3 && $parametros[2] === 'users' && is_numeric($parametros[3])){
                $controlador->getUserById($parametros[3]);
            }
            //POST /admin/users
            elseif($metodo === 'POST' && count($parametros) === 2 && $parametros[2] === 'users'){
                $controlador->createUser();
            }
            //PUT /admin/users/id
            elseif($metodo === 'PUT' && count($parametros) === 3 && $parametros[2] === 'users' && is_numeric($parametros[3])){
                $controlador->updateUser($parametros[3]);
            }
            //DELETE /admin/users/id
            elseif($metodo === 'DELETE' && count($parametros) === 3 && $parametros[2] === 'users'  && is_numeric($parametros[3])){
                $controlador->delete($parametros[3]);
            }
            else{
                http_response_code(404);
                echo json_encode(['error' => 'Endpoint no soportado en /admin']);
            }
        }
    }
    //Rutas USER
    elseif(!empty($parametros[1]) && $parametros[1] === 'user'){
        $controlador = new UsuarioController($usuarioAutenticado);

        //GET /user/me
        if ($metodo === 'GET' && count($parametros) === 2 && $parametros[2] === 'me') {
            $controlador->getMe();
        }
        //GET /user/statistics
        elseif($metodo === 'GET' && count($parametros) === 2 && $parametros[2] === 'statistics'){
            $controlador->getStatistics();
        }
        // POST /user/password/recover
        elseif($metodo === 'POST' && count($parametros) === 3 && $parametros[2] === 'password' && $parametros[3] === 'recover'){
            $controlador->recoverPassword();
        }
        else{
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint no soportado en /user']);
        }
    }
    //Rutas GAMER
    elseif(!empty($parametros[1]) && $parametros[1] === 'gamer'){
        $controlador = new PartidaController($usuarioAutenticado);

        //POST /gamer/games
        if($metodo === 'POST' && count($parametros) === 2 && $parametros[2] === 'games'){
            $controlador->createGame();
        }
        //GET /gamer/games
        elseif($metodo === 'GET' && count($parametros) === 2 && $parametros[2] === 'games'){
            $controlador->getGames();
        }
        //GET /gamer/games/gameId
        elseif($metodo === 'GET' && count($parametros) === 3 && $parametros[2] === 'games' && is_numeric($parametros[3])){
            $controlador->getGameState($parametros[3]);
        }
        //POST /gamer/games/gameId/tiles/tilePosition
        elseif($metodo === 'POST' && count($parametros) === 5 && $parametros[2] === 'games' && is_numeric($parametros[3]) && $parametros[4] === 'tiles' && is_numeric($parametros[5])){
            $controlador->openTile($parametros[3],$parametros[5]);
        }
        // POST /gamer/games/gameId/surrender
        elseif($metodo === 'POST' && count($parametros) === 4 && $parametros[2] === 'games' && is_numeric($parametros[3]) && $parametros[4] === 'surrender'){
            $controlador->surrender($parametros[3]);
        }
        else{
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint no soportado en /gamer']);
        }
    }
    else{
        http_response_code(404);
        echo json_encode(['error' => 'ruta no encontrada']);
    }
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al verificar las credenciales: ' . $e->getMessage()]);
    }
}
