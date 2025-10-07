<?php

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../Models/Rol.php';

class RolDAO{
    public static function createRol($rol){
        try {
            $conexion = Database::connect();
            $query = 'INSERT INTO roles(nombre) VALUES (?)';
            $stmt = $conexion->prepare($query);
            $nombre = $rol->getNombre();
            $stmt->bind_param('s',$nombre);
            $ok = $stmt->execute();

            $stmt->close();
            return $ok;
        } catch (Exception $e) {
            throw new Exception("Error al crear rol".$e->getMessage());

        }finally{
            $conexion->close();
        }
    }

    public static function getRolById($id){
        try {
            $conexion = Database::connect();
            $query = "SELECT * FROM roles WHERE id = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $rol = null;

            if ($fila = $resultado->fetch_assoc()) {
                $rol = new Rol();
                $rol->setId($fila['id']);
                $rol->setNombre($fila['nombre']);
            }

            $stmt->close();
            return $rol;

        } catch (Exception $e) {
            throw new Exception("Error al obtener rol".$e->getMessage());
            
        }finally{
            $conexion->close();
        }
    }

    public static function getAllRoles(){
        try {
            $conexion = Database::connect();
            $query = "SELECT * FROM roles";
            $stmt = $conexion->prepare($query);
            $stmt ->execute();
            $resultado = $stmt->get_result();
            $roles = [];

            while ($fila = $resultado->fetch_assoc()) {
                $rol = new Rol();
                $rol->setId($fila['id']);
                $rol->setNombre($fila['nombre']);

                $roles[] = $rol;
            }

            $stmt->close();
            return $roles;

        } catch (Exception $e) {
            throw new Exception("Error al obtener todos los roles".$e->getMessage());
            
        }finally{
            $conexion->close();
        }
    }

    public static function getRolByNombre($nombre){
        try {
            $conexion = Database::connect();
            $query = "SELECT * FROM roles WHERE nombre = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("s",$nombre);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $rol = null;

            if ($fila = $resultado->fetch_assoc()) {
                $rol = new Rol();
                $rol->setId($fila['id']);
                $rol->setNombre($fila['nombre']);
            }

            $stmt->close();
            return $rol;

        } catch (Exception $e) {
            throw new Exception("Error al buscar rol por nombre".$e->getMessage());
            
        }finally{
            $conexion->close();
        }
    }

    public static function updateRol($rol){
        try {
            $conexion = Database::connect();
            $query = "UPDATE roles SET nombre = ? WHERE id = ?";
            $stmt = $conexion->prepare($query);
            $nombre = $rol->getNombre();
            $id = $rol->getId();

            $stmt->bind_param('si',$nombre,$id);
            $ok = $stmt->execute();

            $stmt->close();
            return $ok;
        } catch (Exception $e) {
            throw new Exception("Error al actualizar rol".$e->getMessage());
            
        }finally{
            $conexion->close();
        }
    }

    public static function deleteRol($id){
        try {
            $conexion = Database::connect();
            $query = "DELETE FROM roles WHERE id = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param('i',$id);
            $ok = $stmt->execute();

            $stmt->close();
            return $ok;
        } catch (Exception $e) {
            throw new Exception("Error al eliminar el rol".$e->getMessage());
            
        }finally{
            $conexion->close();
        }
    }
}