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

    private function verify()
    {
        if ($this->usuarioAutenticado === null) {
            http_response_code(401);
            echo json_encode(['error' => 'Usuario no autenticado']);
            return false;
        }

        if ($this->usuarioAutenticado->getRolNombre() !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Acceso Denegado, solo los administradores pueden ver esta información']);
            return false;
        }

        return true;
    }
    //Get /admin/users 
    //obtener todos los usuarios (solo disponible para los administradores)
    public function getAllUsers()
    {


        if(!$this->verify()){
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

    public function getUserById($id)
    {
        if(!$this->verify()){
            return;
        }

        try {

            $usuario = UsuarioDAO::getUserById($id);

            if ($usuario === null) {
                http_response_code(404);
                echo json_encode(['error' => 'usuario no encontrado']);
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
            echo json_encode(['error' => 'error al obtener el usuario ' . $e->getMessage()]);
        }
    }

    //Post /admin/users
    //Crear un nuevo usuario (solo disponible para los administradores)
    public function createUser()
    {
        if(!$this->verify()){
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        $camposObligatorios = ['dni', 'clave', 'email', 'nombre', 'rol_id'];
        foreach ($camposObligatorios as $campo) {
            if (!isset($datos[$campo]) || trim($datos[$campo]) === '') {
                http_response_code(400);
                echo json_encode(['error' => "El campo '$campo' es obligatorio y no puede estar vacío"]);
                return;
            }
        }

        $dni = trim($datos['dni']);
        $clave = $datos['clave'];
        $email = trim($datos['email']);
        $nombre = trim($datos['nombre']);
        $rol_id = (int)$datos['rol_id'];

        if ($rol_id !== 1 && $rol_id !== 2) {
            http_response_code(400);
            echo json_encode(['error' => 'El rol_id debe ser 1 (admin) o 2 (gamer)']);
            return;
        }

        try {
            if (UsuarioDAO::getUserByDni($dni) !== null) {
                http_response_code(409);
                echo json_encode(['error' => 'ese dni ya esta registrado']);
                return;
            }

            if (usuarioDAO::getUserByEmail($email) !== null) {
                http_response_code(409);
                echo json_encode(['error' => 'ese email ya esta registrado']);
                return;
            }


            $nuevoUsuario = new Usuario();
            $nuevoUsuario->setDni($dni);
            $nuevoUsuario->setClave($clave);
            $nuevoUsuario->setEmail($email);
            $nuevoUsuario->setNombre($nombre);
            $nuevoUsuario->setRolId($rol_id);

            $exito = usuarioDAO::createUser($nuevoUsuario);

            echo json_encode([
                'mensaje' => 'Usuario Creado Correctamente',
                'id' => $nuevoUsuario->getId(),
                'nombre' => $nuevoUsuario->getNombre(),
                'email' => $nuevoUsuario->getEmail(),
                'rol' => $nuevoUsuario->getRolNombre()
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'error al crear usuario']);
        }
    }

    //Put /admin/users/id
    // actualizar usuario existente(solo disponible para administradores)
    public function updateUser($id)
    {

        if(!$this->verify()){
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);
        try {

            //cogemos el usuario actual para hacer validacion (existe y comparar dni y correo)
            $usuarioActual = UsuarioDAO::getUserById($id);
            if ($usuarioActual === null) {
                http_response_code(404);
                echo json_encode(['error' => 'usuario no encontrado']);
                return;
            }
            //si no se introduce alguno de estos datos para updatear se queda el suyo
            $nuevoDni = isset($datos['dni']) ? trim($datos['dni']) : $usuarioActual->getDni();
            $nuevoEmail = isset($datos['email']) ? trim($datos['email']) : $usuarioActual->getEmail();
            $nuevoNombre = isset($datos['nombre']) ? trim($datos['nombre']) : $usuarioActual->getNombre();
            $nuevaClave = isset($datos['clave']) ? trim($datos['nombre']) : $usuarioActual->getClave();
            $nuevoRolId = isset($datos['rol_id']) ?  trim($datos['rol_id']) : $usuarioActual->getRolId();

            if ($nuevoRolId !== 1 || $nuevoRolId !== 2) {
                http_response_code(400);
                echo json_encode(['error' => 'el rol_id solo puede ser 1 admin o 2 gamer']);
                return;
            }

            if ($nuevoDni !== $usuarioActual->getDni()) {
                if (usuarioDAO::getUserByDni($nuevoDni) !== null) {
                    http_response_code(409);
                    echo json_encode(['error' => 'el dni ya esta registrado']);
                    return;
                }
            }

            if ($nuevoEmail !== $usuarioActual->getEmail()) {
                if (usuarioDAO::getUserByEmail($nuevoEmail) !== null) {
                    http_response_code(409);
                    echo json_encode(['error' => 'el email ya esta registrado']);
                    return;
                }
            }

            /**
             * se que este bloque de aqui debajo no es eficiente por que 
             * en caso de que alguna variable no se haya cambiado por x o por y
             * seria la misma que tenia y aqui la estariamos cambiando a la misma que tiene ya,
             * ahora mismo no se me ocurre otra cosa mejor, se intentará mejorar
             * 
             */
            $usuarioActual->setDni($nuevoDni);
            $usuarioActual->setEmail($nuevoEmail);
            $usuarioActual->setNombre($nuevoNombre);
            $usuarioActual->setClave($nuevaClave);
            $usuarioActual->setRolId($nuevoRolId);

            $exito = usuarioDAO::updateById($usuarioActual);

            http_response_code(200);
            echo json_encode([
                'mensaje' => 'usuario updateado correctamente',
                'id' => $usuarioActual->getId(),
                'dni' => $usuarioActual->getDni(),
                'nombre' => $usuarioActual->getNombre()
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'error al actualizar el usuario']);
        }
    }

    //Delete /admin/users/id
    // Elimina un usuario (solo disponible para los administradores)
    public function delete($id)
    {

        if(!$this->verify()){
            return;
        }

        try {
            if (UsuarioDAO::getUserById($id) === null) {
                http_response_code(404);
                echo json_encode(['error' => 'El usuario que quieres borrar no existe']);
                return;
            }

            $exito = usuarioDAO::deleteUser($id);

            if ($exito) {
                http_response_code(200);
                echo json_encode([
                    'mensaje' => 'usuario eliminado correctamente'
                ]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'no se pudo eliminar el usuario']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'el usuario no ha podido eliminarse correctamente']);
        }
    }
}
