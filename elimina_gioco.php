<?php
// Verifica se sono stati inviati dati dal form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connessione al database
    require_once './connessione_database.php';
    $pdo = (new Database)->connect();

    // Recupera l'ID del gioco da eliminare
    $id = $_POST["id"];

    // Esegui l'eliminazione nel database
    $query = "DELETE FROM games WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();

    // Reindirizza alla dashboard
    header('Location: dashboard.php');
    exit;
}
