<?php

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Models/Partida.php';
require_once __DIR__ . '/../DataBases/PartidaDAO.php';

class PartidaController
{
    private $usuarioAutenticado;

    public function __construct(Usuario $usuarioAutenticado)
    {
        $this->usuarioAutenticado = $usuarioAutenticado;
    }

    //Post /gamer/games 
    // crear una nueva partida
    public function createGame()
    {
        try {
            $datos = json_decode(file_get_contents('php://input'), true);
            //in_array l oque hace es buscar el valor especifico de un array, aqui mira si en tipo hay tipo estandat o personalizada 
            if (!isset($datos['tipo']) || !in_array($datos['tipo'], ['estandar', 'personalizada'])) {
                http_response_code(400);
                echo json_encode(['error' => 'el campo "tipo" es obligatorio y debe ser "estandar" o "personalizada" ']);
                return;
            }

            $tipo = $datos['tipo'];
            $num_casillas = null;

            if ($tipo === 'personalizada') {
                if (!isset($datos['numCasillas'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'el numero de casillas es obligatorio, si no no seria una partida personalizada']);
                    return;
                }

                $num_casillas = (int)$datos['numCasillas'];

                if ($num_casillas < 10 || $num_casillas > 100) {
                    http_response_code(400);
                    echo json_encode(['error' => 'el numero de casillas debo estar entre 10 y 100']);
                    return;
                }
            }

            $partidas = PartidaDAO::getPartidasByUsuarioId($this->usuarioAutenticado->getId());
            $partidasEnCurso = 0;

            foreach ($partidas as $partida) {
                if ($partida->getEstado() === 'en curso') {
                    $partidasEnCurso++;
                }
            }

            if ($partidasEnCurso > 2) {
                http_response_code(400);
                echo json_encode(['error' => 'Maximo dos partidas abiertas, termine una para poder crear otra']);
                return;
            }

            $nuevaPartida = new Partida();
            $nuevaPartida->setUsuarioId($this->usuarioAutenticado->getId());

            if ($tipo === 'estandar') {
                $nuevaPartida->iniciarPartida();
            } else if ($tipo === 'personalizada') {
                $nuevaPartida->iniciarPartidaPersonalizada($num_casillas);
            }

            $exito = PartidaDAO::createPartida($nuevaPartida);

            http_response_code(201);
            echo json_encode([
                'id' => $nuevaPartida->getId(),
                'usuarioId' => $nuevaPartida->getUsuarioId(),
                'estado' => $nuevaPartida->getEstado(),
                'tablero' => $nuevaPartida->getTablero(),
                'heroes' => $nuevaPartida->getHeroes(),
                'contador_casillas_destapadas' => $nuevaPartida->getContadorCasillasDestapadas(),
                'contador_fallos_seguidos' => $nuevaPartida->getContadorFallosSeguidos()
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'error al crear la partida: '. $e->getMessage()]);
        }
    }

    //get /gamer/games
    // obtener todas las partidas abiertas del jugador
    public function getGames(){
        try {
            $partidas = PartidaDAO::getPartidasByUsuarioId($this->usuarioAutenticado->getId());
            $partidasAbiertas = [];
            foreach($partidas as $partida){
                $partidasAbiertas[] = [
                    'id' => $partida->getId(),
                    'tablero' => $partida->getTablero(),
                    'estado' => $partida->getEstado(),
                    'heroes' => $partida->getHeroes(),
                    'contador_casillas_destapadas' => $partida->getContadorCasillasDestapadas(),
                    'contador_fallos_seguidos' => $partida->getContadorFallosSeguidos()
                ];
            }

            http_response_code(200);
            echo json_encode($partidasAbiertas);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'error al obtener la lista de partidas del usuario']);
        }
    }

    //Get /gamer/games/gameId
    //obtener el estado actual de la partida

    public function getGameState($id){
        try {
           
            $partida = PartidaDAO::getPartidaById($id);
            if ($partida === null) {
                http_response_code(404);
                echo json_encode(['error' => 'esa id no corresponde con ninguna partida']);
                return;
            }

            if ($partida->getUsuarioId() !== $this->usuarioAutenticado->getId()) {
                http_response_code(403);
                echo json_encode(['error' => 'ese id de partida no corresponde con ninguna de tus partidas']);
                return;
            }

            http_response_code(200);
            echo json_encode([
                'id' => $partida->getId(),
                'usuarioId' => $this->usuarioAutenticado->getId(),
                'estado' => $partida->getEstado(),
                'tablero' => $partida->getTablero(),
                'heroes' => $partida->getHeroes(),
                'contador_casillas_destapadas' => $partida->getContadorCasillasDestapadas(),
                'contador_fallos_seguidos' => $partida->getContadorFallosSeguidos()
            ]);

            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'error al obtener el estado de la partida']);
        }
    }

    //Post /gamer/games/gameId/tiles/tilePosition
    // destapar una casilla

    public function openTile($gameId,$tilePosition){
        try {
            
            if (!is_numeric($tilePosition) || $tilePosition > 1) {
                http_response_code(400);
                echo json_encode(['error' => 'la posicion de la casilla tiene que ser un numero y mayor que 0']);
                return;
            }

            $titlePositiion = (int)$tilePosition;

            $partida = PartidaDAO::getPartidaById($gameId);
            if ($partida === null) {
                http_response_code(404);
                echo json_encode(['error' => 'partida no encontrada']);
                return;
            }

            if ($partida->getUsuarioId() !== $this->usuarioAutenticado->getId()) {
                http_response_code(403);
                echo json_encode(['error' => 'no tienes los permisos necesarios para acceder a esta partida']);
                return;
            }

            if ($partida->getEstado() !== 'en curso') {
                http_response_code(400);
                echo json_encode(['error' => 'la partida ya ha finalizado']);
                return;
            }

            $partida->destaparCasilla($titlePositiion);
            $exito = PartidaDAO::updatePartida($partida);

            http_response_code(200);
            echo json_encode([
                'id' => $partida->getId(),
                'estado' => $partida->getEstado(),
                'tablero' => $partida->getTablero(),
                'heroes' => $partida->getHeroes(),
                'contador_casillas_destapadas' => $partida->getContadorCasillasDestapadas(),
                'contador_fallor_seguidos' => $partida->getContadorFallosSeguidos()
            ]);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'error de juego '.$e->getMessage()]);
        }
    }

    //Post /gamer/games/gameId/surrender
    // rendirse

    public function surrender($gameId){
        try {
            $partida = PartidaDAO::getPartidaById($gameId);
            if ($partida === null) {
                http_response_code(404);
                echo json_encode(['error' => 'partida no encontrada']);
                return;
            }

            if ($partida->getEstado() !== 'en curso') {
                http_response_code(400);
                echo json_encode(['error' => 'la partida ya ha finalizado']);
                return;
            }

            if ($partida->getUsuarioId() !== $this->usuarioAutenticado->getId()) {
                http_response_code(403);
                echo json_encode(['error' => 'no tienes permisos necesarios para acceder a esta partida']);
                return;
            }

            $partida->rendirse();

            $exito = PartidaDAO::updatePartida($partida);

            http_response_code(200);
            echo json_encode([
                'id' => $partida->getId(),
                'estado' => $partida->getEstado(),
                'tablero' => $partida->getTablero(),
                'heroes' => $partida->getHeroes(),
                'contador_casillas_destapadas' => $partida->getContadorCasillasDestapadas(),
                'contador_fallos_seguidos' => $partida->getContadorFallosSeguidos()

            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'error al intentar rendirte '.$e->getMessage()]);
        }
    }
}
