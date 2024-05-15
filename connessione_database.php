<?php

class Database
{
    // Parametri per la connessione al database
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "progetto_accesso";
    private $charset = "utf8mb4";
    private $pdo;
    private $error;

    // Metodo per stabilire la connessione al database utilizzando PDO
    public function connect()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }

        return $this->pdo;
    }

    // Metodo per eseguire una query
    public function query($sql)
    {
        return $this->pdo->query($sql);
    }

    // Metodo per preparare una query
    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    // Metodo per ottenere eventuali errori
    public function getError()
    {
        return $this->error;
    }
}
