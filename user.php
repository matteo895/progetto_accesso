<?php

class User
{
    // Proprietà della classe User
    private $id;
    private $username;
    private $password;

    // Costruttore della classe User
    public function __construct($id, $username, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    // Metodo per ottenere l'ID dell'utente
    public function getId()
    {
        return $this->id;
    }

    // Metodo per ottenere lo username dell'utente
    public function getUsername()
    {
        return $this->username;
    }

    // Metodo per ottenere la password dell'utente
    public function getPassword()
    {
        return $this->password;
    }
}
