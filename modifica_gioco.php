<?php

// Verifica se sono stati inviati dati dal modulo di modifica
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connessione al database
    require_once './connessione_database.php';
    $pdo = (new Database)->connect();

    // Recupera l'ID del gioco da modificare
    $id = $_POST["id"];

    // Recupera il nuovo titolo inviato dal modulo
    $title = $_POST["title"];

    // Recupera il titolo esistente per includerlo nel form
    $existing_title = $_POST["existing_title"];

    // Verifica se è stato fornito un nuovo file immagine
    if (!empty($_FILES["image"]["name"])) {
        // Carica la nuova immagine sul server
        $image = $_FILES["image"];
        $image_path = './uploads/' . $image['name'];
        move_uploaded_file($image['tmp_name'], $image_path);

        // Query per aggiornare il gioco nel database con il titolo e l'immagine
        $query = "UPDATE games SET title = :title, image = :image WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':image', $image_path);
    } else {
        // Query per aggiornare il gioco nel database solo con il titolo
        $query = "UPDATE games SET title = :title WHERE id = :id";
        $statement = $pdo->prepare($query);
    }

    // Associa i parametri e esegui la query
    $statement->bindParam(':id', $id);
    $statement->bindParam(':title', $title);
    $statement->execute();

    // Reindirizza alla dashboard
    header('Location: dashboard.php');
    exit;
}
