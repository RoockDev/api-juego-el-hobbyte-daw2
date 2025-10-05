<?php

require_once __DIR__ . '/database.php';

class usuarioDAO
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::connect();
    }

    public static function createUser($usuario)
    {
        try {
            $conexion = Database::connect();
            $query = "INSERT INTO usuarios(dni,clave,email,nombre,rol_id) VALUES (?,?,?,?,?)";
            $stmt = $conexion->prepare($query);
            $dni = $usuario->getDni();
            $clave = $usuario->getClave();
            $email = $usuario->getEmail();
            $nombre = $usuario->getNombre();
            $rol_id = $usuario->getRolId();
            $stmt->bind_param('ssssi', $dni, $clave, $email, $nombre, $rol_id);
            $ok = $stmt->execute();

            $stmt->close();

            return $ok;
        } catch (Exception $e) {
            throw new Exception("Error al insertar un usuario" . $e->getMessage());
        } finally {
            $conexion->close();
        }
    }

    public static function getUserByDni($dni)
    {
        try {
            $conexion = Database::connect();
            $query = "SELECT u.id,u.dni,u.clave,u.email,u.nombre,r.nombre as rol_nombre
            FROM usuarios u
            JOIN roles r ON u.rol_id = r.id
            WHERE u.dni = ? ";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("s", $dni);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $usuario = null;
            if ($fila = $resultado->fetch_assoc()) {

                $usuario = new Usuario();
                $usuario->setId($fila['id']);
                $usuario->setDni($fila['dni']);
                $usuario->setClave($fila['clave']);
                $usuario->setEmail($fila['email']);
                $usuario->setNombre($fila['nombre']);
                $usuario->setRolNombre($fila['rol_nombre']);
            }

            $stmt->close();
            return $usuario;
        } catch (Exception $e) {
            throw new Exception("Error al buscar usuario" . $e->getMessage());
        } finally {
            $conexion->close();
        }
    }
     public static function getUserByEmail($email)
    {
        try {
            $conexion = Database::connect();
            $query = "SELECT u.id,u.dni,u.clave,u.email,u.nombre,r.nombre as rol_nombre
            FROM usuarios u
            JOIN roles r ON u.rol_id = r.id
            WHERE u.email = ? ";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $usuario = null;
            if ($fila = $resultado->fetch_assoc()) {

                $usuario = new Usuario();
                $usuario->setId($fila['id']);
                $usuario->setDni($fila['dni']);
                $usuario->setClave($fila['clave']);
                $usuario->setEmail($fila['email']);
                $usuario->setNombre($fila['nombre']);
                $usuario->setRolNombre($fila['rol_nombre']);
            }

            $stmt->close();
            return $usuario;
        } catch (Exception $e) {
            throw new Exception("Error al buscar usuario" . $e->getMessage());
        } finally {
            $conexion->close();
        }
    }

    public static function getUserById($id)
    {
        try {
            $conexion = Database::connect();
            $query = "SELECT u.id,u.dni,u.clave,u.email,u.nombre,r.nombre as rol_nombre
            FROM usuarios u
            JOIN roles r ON u.rol_id = r.id
            WHERE u.id = ? ";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $usuario = null;
            if ($fila = $resultado->fetch_assoc()) {

                $usuario = new Usuario();
                $usuario->setId($fila['id']);
                $usuario->setDni($fila['dni']);
                $usuario->setClave($fila['clave']);
                $usuario->setEmail($fila['email']);
                $usuario->setNombre($fila['nombre']);
                $usuario->setRolNombre($fila['rol_nombre']);
            }

            $stmt->close();
            return $usuario;
        } catch (Exception $e) {
            throw new Exception("Error al buscar usuario" . $e->getMessage());
        } finally {
            $conexion->close();
        }
    }

    public static function getAllUsers()
    {
        try {
            $conexion = Database::connect();
            $sql = "SELECT u.id, u.dni, u.email, u.nombre, r.nombre as rol_nombre
                    FROM usuarios u
                    JOIN roles r ON u.rol_id = r.id";

            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $usuarios = [];

            while ($fila = $resultado->fetch_assoc()) {

                $usuario = new Usuario();
                $usuario->setId($fila['id']);
                $usuario->setDni($fila['dni']);

                $usuario->setEmail($fila['email']);
                $usuario->setNombre($fila['nombre']);
                $usuario->setRolNombre($fila['rol_nombre']);




                $usuarios[] = $usuario;
            }
        } catch (Exception $e) {
            throw new Exception("Error al obtener todos los usuarios" . $e->getMessage());
        } finally {
            $conexion->close();
        }
    }

    public static function updateByDni($usuario){
        try {
            $conexion = Database::connect();
            $query = "UPDATE usuarios SET dni = ?, email = ?, clave = ?, nombre = ? WHERE dni = ?";
            $stmt = $conexion->prepare($query);
            $dni = $usuario->getDni();
            $email = $usuario->getEmail();
            $clave = $usuario->getClave();
            $nombre = $usuario->getNombre();

            $stmt->bind_param('ssss',$dni,$email,$clave,$nombre);
            $ok = $stmt->execute();

            $stmt->close();
            return $ok;

        } catch (Exception $e) {
            throw new Exception("Error al actualizar usuario".$e->getMessage());
            
        }finally{
            $conexion->close();
        }
    }

     public static function updateById($usuario){
        try {
            $conexion = Database::connect();
            $query = "UPDATE usuarios SET dni = ?, email = ?, clave = ?, nombre = ? WHERE id = ?";
            $stmt = $conexion->prepare($query);
            $dni = $usuario->getDni();
            $email = $usuario->getEmail();
            $clave = $usuario->getClave();
            $nombre = $usuario->getNombre();
            $id = $usuario->getId();

            $stmt->bind_param('ssssi',$dni,$email,$clave,$nombre,$id);
            $ok = $stmt->execute();

            $stmt->close();
            return $ok;

        } catch (Exception $e) {
            throw new Exception("Error al actualizar usuario".$e->getMessage());
            
        }finally{
            $conexion->close();
        }
    }

    public static function deleteUser($dni){
        try {
            $conexion = Database::connect();
            $query = "DELETE FROM usuarios WHERE dni = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("s",$dni);
            $ok = $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception("Error al borrar usuarios".$e->getMessage());
            
        }finally{
            $conexion->close();
        }
    }
}
