<?php

class Usuario{
    private $id;
    private $dni;
    private $clave;
    private $email;
    private $nombre;
    private $rol_id;
    private $rol_nombre;

    public function __construct($id = null,$dni = null, $clave = null, $email = null,$nombre = null, $rol_id = null, $rol_nombre = null)
    {
        $this->id = $id;
        $this->dni = $dni;
        $this->clave = $clave;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->rol_id = $rol_id;
        $this->rol_nombre = $rol_nombre;
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
     * Get the value of dni
     */
    public function getDni() {
        return $this->dni;
    }

    /**
     * Set the value of dni
     */
    public function setDni($dni): self {
        $this->dni = $dni;
        return $this;
    }

    /**
     * Get the value of clave
     */
    public function getClave() {
        return $this->clave;
    }

    /**
     * Set the value of clave
     */
    public function setClave($clave): self {
        $this->clave = $clave;
        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): self {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre($nombre): self {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * Get the value of rol_id
     */
    public function getRolId() {
        return $this->rol_id;
    }

    /**
     * Set the value of rol_id
     */
    public function setRolId($rol_id): self {
        $this->rol_id = $rol_id;
        return $this;
    }

    /**
     * Get the value of rol_nombre
     */
    public function getRolNombre() {
        return $this->rol_nombre;
    }

    /**
     * Set the value of rol_nombre
     */
    public function setRolNombre($rol_nombre): self {
        $this->rol_nombre = $rol_nombre;
        return $this;
    }
}