<?php

// Verifica se sono stati inviati dati dal modulo di registrazione
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include il file di connessione al database
    require_once './connessione_database.php';
    $pdo = (new Database)->connect();

    // Recupera il nome del gioco e il file immagine inviati dal modulo
    $title = $_POST["title"];
    $image = $_FILES["image"]["name"];

    // Percorso della directory di destinazione per il file immagine caricato
    $target_dir = "uploads/";

    // Percorso completo del file immagine
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Verifica se il file immagine è stato caricato correttamente
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Query per inserire il nuovo gioco nel database
        $query = "INSERT INTO games (title, image) VALUES (:title, :image)";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':title', $title);
        $statement->bindParam(':image', $target_file); // Salviamo il percorso dell'immagine

        // Esegui la query preparata
        if ($statement->execute()) {
            // Inserimento riuscito, reindirizza alla dashboard o mostra un messaggio di successo
            header('Location: dashboard.php');
            exit;
        } else {
            // Gestione degli errori durante l'inserimento nel database
            echo "Errore durante l'inserimento del gioco nel database.";
        }
    } else {
        // Gestione degli errori durante il caricamento del file immagine
        echo "Errore durante il caricamento del file immagine.";
    }
}
