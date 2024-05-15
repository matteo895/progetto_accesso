<?php

session_start();

// Verifica se l'utente è già autenticato, in tal caso reindirizza alla dashboard
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

// Includi il file della classe Database
require_once './connessione_database.php';

// Crea un'istanza della classe Database per la connessione al database
$database = new Database();
$pdo = $database->connect();

// Verifica se sono stati inviati dati dal modulo di registrazione
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera il nome utente e la password inviati dal modulo di registrazione
    $nome_utente = $_POST["username"];
    $password_utente = $_POST["password"];

    // Hash della password
    $password_hashed = password_hash($password_utente, PASSWORD_DEFAULT);

    // Query per inserire l'utente nel database
    $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':username', $nome_utente);
    $statement->bindParam(':password', $password_hashed);
    $statement->execute();

    // Reindirizza l'utente alla pagina di login dopo la registrazione
    header('Location: index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Stili CSS per il layout del modulo di registrazione */
        form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        label,
        input {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 3px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body class="bg-dark">
    <div class=" d-flex align-items-center" style="height: 100vh;">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Registrazione</h2>
            <label for="username">Nome utente:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Registrati">
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>