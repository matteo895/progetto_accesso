<?php

class Game
{
    // Proprietà della classe Game
    private $id;
    private $title;
    private $imageURL;

    // Costruttore della classe Game
    public function __construct($id, $title, $imageURL)
    {
        $this->id = $id;
        $this->title = $title;
        $this->imageURL = $imageURL;
    }

    // Metodo per ottenere l'ID del gioco
    public function getId()
    {
        return $this->id;
    }

    // Metodo per ottenere il titolo del gioco
    public function getTitle()
    {
        return $this->title;
    }

    // Metodo per ottenere l'URL dell'immagine del gioco
    public function getImageURL()
    {
        return $this->imageURL;
    }
}
