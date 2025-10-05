<?php

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../DataBase/UsuarioDAO.php';

class UsuarioController
{

    private $usuarioAutenticado;

    public function __construct(Usuario $usuarioAutenticado)
    {
        $this->usuarioAutenticado = $usuarioAutenticado;
    }

    //Get /admin/users 
    //obtener todos los usuarios (solo disponible para los administradores)
    public function getAllUsers()
    {
       
        
        if ($this->usuarioAutenticado === null) {
            http_response_code(401);
            echo json_encode(['error' => 'Usuario no autenticado']);
            return;
        }

        if ($this->usuarioAutenticado->getRolNombre() !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Acceso Denegado, solo los administradores pueden ver esta información']);
            return;
        }

        try {
            $usuarios = UsuarioDAO::getAllUsers();
            if ($usuarios === null) {
                http_response_code(404);
                echo json_encode(['error' => 'usuarios no encontrado']);
                return;
            }

            $usuariosProtegidos = [];

            foreach ($usuarios as $usuario) {
                $usuariosProtegidos[] = [
                    'id' => $usuario->getId(),
                    'dni' => $usuario->getDni(),
                    'email' => $usuario->getEmail(),
                    'nombre' => $usuario->getNombre(),
                    'rol' => $usuario->getRolNombre()
                ];
            }

            http_response_code(200);
            echo json_encode($usuariosProtegidos);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al obtener la lista de usuarios']);
        }
    }


    //Get /admin/users/id
    //Obtener un usuario por Id (solo disponible para los administradores)
    
    public function getUserById($id){
        if ($this->usuarioAutenticado === null) {
            http_response_code(401);
            echo json_encode(['error' => 'Usuario no autenticado']);
            return;
        }

        if ($this->usuarioAutenticado->getRolNombre() !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Acceso Denegado, solo los administradores pueden ver esta información']);
            return;
        }

        try {
    
            $usuario = UsuarioDAO::getUserById($id);

            if ($usuario === null) {
                http_response_code(404);
                echo json_encode(['error' => 'usuario no encontrado' ]);
                return;
            }
            $usuarioProtegido = [
                'id' => $id,
                'dni' => $usuario->getDni(),
                'email' => $usuario->getEmail(),
                'nombre' => $usuario->getNombre(),
                'rol' => $usuario->getRolNombre()
            ];
            http_response_code(200);
            echo json_encode($usuarioProtegido);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'error al obtener el usuario '.$e->getMessage()]);
        }
    }
}
