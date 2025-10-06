<?php
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

            $exito = partidaDAO::createPartida($nuevaPartida);

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
}
