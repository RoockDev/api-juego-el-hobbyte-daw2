<?php

class Partida{
    private $id;
    private $usuario_id;
    private $estado;
    private $tablero;
    private $heroes;
    private $contador_casillas_destapadas;
    private $contador_fallos_seguidos;

    public function __construct($id=null,$usuario_id = null,$estado = null, $tablero = null, $heroes = null, $contador_casillas_destapadas = null, $contador_fallos_seguidos = null)
    {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->estado = $estado;
        $this->tablero = $tablero;
        $this->heroes = $heroes;
        $this->contador_casillas_destapadas = $contador_casillas_destapadas;
        $this->contador_fallos_seguidos = $contador_fallos_seguidos;
    }

    private function generarTablero(){
        $tipos = ['magia','fuerza','habilidad'];
        $tablero = [];

        for ($i=0; $i < 20 ; $i++) { 
            $tipo = $tipos[array_rand($tipos)];
        }

        $rand = mt_rand(1,100);

        if ($rand <= 65) {
            $esfuerzo = [5,10,15,20][array_rand([5,10,15,20])];
        }elseif ($rand <=95) {
            $esfuerzo = [25,30,35,40][array_rand([25,30,35,40])];
        }else{
            $esfuerzo = [45,50][array_rand([45,50])];
        }

        $tablero[] = [
            'tipo' => $tipo,
            'esfuerzo' => $esfuerzo
        ];

        return $tablero;
    }

    private function inicializarHeroes(){
       return [
        'Gandalf' => 50,
        'Thorin' => 50,
        'Bilbo' => 50
       ];
    }

    public function iniciarPartida(){
        $this->tablero = $this->generarTablero();
        $this->heroes = $this->inicializarHeroes();
        $this->estado = "en curso";
        $this->contador_casillas_destapadas = 0;
        $this->contador_fallos_seguidos = 0;

    }
    

    /**
     * Get the value of id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of usuario_id
     */
    public function getUsuarioId() {
        return $this->usuario_id;
    }

    /**
     * Set the value of usuario_id
     */
    public function setUsuarioId($usuario_id): self {
        $this->usuario_id = $usuario_id;
        return $this;
    }

    /**
     * Get the value of estado
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     * Set the value of estado
     */
    public function setEstado($estado): self {
        $this->estado = $estado;
        return $this;
    }

    /**
     * Get the value of tablero
     */
    public function getTablero() {
        return $this->tablero;
    }

    /**
     * Set the value of tablero
     */
    public function setTablero($tablero): self {
        $this->tablero = $tablero;
        return $this;
    }

    /**
     * Get the value of heroes
     */
    public function getHeroes() {
        return $this->heroes;
    }

    /**
     * Set the value of heroes
     */
    public function setHeroes($heroes): self {
        $this->heroes = $heroes;
        return $this;
    }

    /**
     * Get the value of contador_casillas_destapadas
     */
    public function getContadorCasillasDestapadas() {
        return $this->contador_casillas_destapadas;
    }

    /**
     * Set the value of contador_casillas_destapadas
     */
    public function setContadorCasillasDestapadas($contador_casillas_destapadas): self {
        $this->contador_casillas_destapadas = $contador_casillas_destapadas;
        return $this;
    }

    /**
     * Get the value of contador_fallos_seguidos
     */
    public function getContadorFallosSeguidos() {
        return $this->contador_fallos_seguidos;
    }

    /**
     * Set the value of contador_fallos_seguidos
     */
    public function setContadorFallosSeguidos($contador_fallos_seguidos): self {
        $this->contador_fallos_seguidos = $contador_fallos_seguidos;
        return $this;
    }
}