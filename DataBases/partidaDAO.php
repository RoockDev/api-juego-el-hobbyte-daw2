<?php

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../Models/Partida.php';

class PartidaDAO{

    public static function createPartida($partida){
        try {
            $conexion = Database::connect();
            $query = "INSERT INTO partidas (usuarioId,estado,tablero,heroes,contador_casillas_destapadas,
            contador_fallos_seguidos) VALUES (?,?,?,?,?,?)";
            $stmt = $conexion->prepare($query);

            $usuarioId = $partida->getUsuarioId();
            $estado = $partida->getEstado();
            $tablero = $partida->getTablero();
            $heroes = $partida->getHeroes();
            $contadorCasillasDestapadas = $partida->getContadorCasillasDestapadas();
            $contadorFallosSeguidos = $partida->getContadorFallosSeguidos();
            $stmt->bind_param('isssii',$usuarioId,$estado,$tablero,$heroes,$contadorCasillasDestapadas,$contadorFallosSeguidos);
            $ok = $stmt->execute();
            $stmt->close();
            return $ok;
        } catch (Exception $e) {
            throw new Exception("Error al crear partida",$e->getMessage());
            
        }finally{
            $conexion->close();
        }
    }

    public static function getPartidaById($id){
        try {
            $conexion = Database::connect();
            $query = "SELECT * FROM partidas WHERE id = ? ";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $partida = null;

            if ($fila = $resultado->fetch_assoc()) {
                $partida = new Partida();
                $partida ->setId($fila['id']);
                $partida ->setUsuarioId($fila['usuarioId']);
                $partida->setEstado($fila['estado']);
                $partida->setTablero($fila['tablero']);
                $partida->setHeroes($fila['heroes']);
                $partida->setContadorCasillasDestapadas($fila['contador_casillas_destapadas']);
                $partida->setContadorFallosSeguidos($fila['contador_fallos_seguidos']);
            }

            $stmt->close();
            return $partida;
        } catch (Exception $e) {
            throw new Exception("Error al buscar partida".$e->getMessage());
            
        }finally{
            $conexion->close();
        }
    }

    public static function getPartidasByUsuarioId($usuarioId){
        try {
            $conexion = Database::connect();
            $query = "SELECT * FROM partidas WHERE usuarioId = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("i",$usuarioId);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $partidas = [];

            while ($fila = $resultado->fetch_assoc()) {
                 $partida = new Partida();
                $partida ->setId($fila['id']);
                $partida ->setUsuarioId($fila['usuarioId']);
                $partida->setEstado($fila['estado']);
                $partida->setTablero($fila['tablero']);
                $partida->setHeroes($fila['heroes']);
                $partida->setContadorCasillasDestapadas($fila['contador_casillas_destapadas']);
                $partida->setContadorFallosSeguidos($fila['contador_fallos_seguidos']);

                $partidas[] = $partida;
            }
            $stmt->close();
            return $partidas;

        } catch (Exception $e) {
            throw new Exception("Error al buscar partidas por usuario".$e->getMessage());
            
        }finally{
            $conexion->close();
        }
    }

    public static function updatePartida($partida){
        try {
            $conexion = Database::connect();
            $query = "UPDATE partidas SET usuarioId = ?, estado = ?, tablero = ?, heroes = ?, contador_casillas_destapadas = ?, contador_fallos_seguidos = ? WHERE id = ?";
           $stmt = $conexion->prepare($query);
            $usuarioId = $partida->getUsuarioId();
            $estado = $partida->getEstado();
            $tablero = $partida->getTablero();
            $heroes = $partida->getHeroes();
            $contadorCasillasDestapadas = $partida->getContadorCasillasDestapadas();
            $contadorFallosSeguidos = $partida->getContadorFallosSeguidos();
            $id = $partida->getId();

            $stmt->bind_param('isssiii', $usuarioId,$estado, $tablero, $heroes, $contadorCasillasDestapadas,$contadorFallosSeguidos,$id);
            $ok = $stmt->execute();

            $stmt->close();

            return $ok;
        } catch (Exception $e) {
            throw new Exception("Error al actualizar la partida".$e->getMessage());
            
        }finally{
            $conexion->close();
        }

    }

    public static function deletePartida($id){
        try {
            $conexion = Database::connect();
            $query = "DELETE FROM partidas WHERE id = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param('i',$id);
            $ok = $stmt->execute();

            $stmt->close();
            return $ok;
        } catch (Exception $e) {
            throw new Exception("Error al borrar partida".$e->getMessage());
            
        }finally{
            $conexion->close();
        }
    }

    public static function getPartidasByEstado($estado){
        try {
            $conexion = Database::connect();
            $query = "SELECT * FROM partidas WHERE estado = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param('s',$estado);
            $ok = $stmt->execute();
            $resultado = $stmt->get_result();
            $partidas = [];

             while ($fila = $resultado->fetch_assoc()) {
                $partida = new Partida();
                $partida->setId($fila['id']);
                $partida->setUsuarioId($fila['usuarioId']);
                $partida->setEstado($fila['estado']);
                $partida->setTablero($fila['tablero']);
                $partida->setHeroes($fila['heroes']);
                $partida->setContadorCasillasDestapadas($fila['contador_casillas_destapadas']);
                $partida->setContadorFallosSeguidos($fila['contador_fallos_seguidos']);
                
                $partidas[] = $partida;
            }
            
            $stmt->close();
            return $partidas;
        } catch (Exception $e) {
            throw new Exception("Error al obtener partidas por estado".$e->getMessage());
            
        }finally{
            $conexion->close();
        }
    }

    


    
}