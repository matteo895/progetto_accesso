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

// Verifica se sono stati inviati dati dal modulo di login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera il nome utente e la password inviati dal modulo di login
    $nome_utente = $_POST["username"];
    $password_utente = $_POST["password"];

    // Query per selezionare l'utente corrispondente al nome utente inserito
    $query = "SELECT * FROM users WHERE username = :username";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':username', $nome_utente);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Verifica se l'utente esiste nel database e se la password è corretta
    if ($user && password_verify($password_utente, $user['password'])) {
        // Imposta la variabile di sessione per indicare che l'utente è autenticato
        $_SESSION['logged_in'] = true;
        // Reindirizza alla dashboard
        header('Location: dashboard.php');
        exit;
    } else {
        // Incrementa il conteggio dei tentativi di accesso
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 1;
        } else {
            $_SESSION['login_attempts']++;
        }

        // Controlla se il numero di tentativi è maggiore o uguale a 3
        if ($_SESSION['login_attempts'] >= 3) {
            // Mostra il pop-up di avviso con JavaScript
            echo '<script>alert("Hai superato il limite di prova, verrai reindirizzato alla pagina di registrazione.");</script>';
            // Reindirizza alla pagina di registrazione dopo un certo tempo
            echo '<script>setTimeout(function(){ window.location.href = "register.php"; });</script>';
        } else {
            // Nome utente o password non validi, mostra un messaggio di errore
            $_SESSION['error_message'] = "Nome utente o password non validi.";
            header('Location: login.php');
            exit;
        }
    }
}

?>


<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Stili CSS per il layout del modulo di login */
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

<body class="bg-dark ">
    <div class=" d-flex align-items-center" style="height: 100vh;">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2 class="font-weight-bold">LOGIN</h2>
            <?php if (isset($error_message)) : ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <label for="username">Nome utente:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Accedi">
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>