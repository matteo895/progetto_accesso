<?php
session_start();

// Verifica se l'utente è autenticato, altrimenti reindirizzalo alla pagina di login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// Includi il file di connessione al database
require_once './connessione_database.php';

// Crea un'istanza della classe Database per la connessione al database
$database = new Database();
$pdo = $database->connect();

// Recupera i titoli e le immagini dei giochi dal database
$query = "SELECT id, title, image FROM games";
$statement = $pdo->prepare($query);
$statement->execute();
$games = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<style>
    body {
        background: url("uploads/dragonball_super_cover.webp");
        background-size: cover;
    }

    .container {
        background-color: rgba(0, 0, 0, 0.5);
        margin-bottom: 2rem;
    }

    .card .card-img-top {
        width: 100%;
        height: 200px;
        object-fit: contain;
    }
</style>

<body class="text-white">
    <div class="container ">
        <h1 class="mt-4 mb-3 py-2 text-center">HAI EFFETTUALO L'ACCESSO ALLA PAGINA DI MODIFICA</h1>
        <p class="text-center font-weight-bold mb-5 mt-4">NON CE LA POZZ FÀ</p>

        <!-- Aggiungi Nuovo Gioco -->
        <div class="card mb-4 shadow-lg rounded">
            <h5 class="card-header bg-dark font-weight-bold">AGGIUNGI NUOVO GIOCO</h5>
            <div class="card-body">
                <form action="aggiungi_gioco.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title" class="bg-dark font-weight-bold">Titolo :</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="image" class="bg-dark font-weight-bold">Immagine :</label>
                        <input type="file" class="form-control-file" id="image" name="image" accept="" required>
                    </div>
                    <button type="submit" class="btn btn-success shadow-lg rounded font-weight-bold ">Aggiungi Gioco</button>
                </form>
            </div>
        </div>

        <!-- Giochi Presenti -->
        <h2 class="mt-4 mb-3 text-center font-weight-bold">LISTA DI GIOCHI</h2>
        <div class="row">
            <?php foreach ($games as $game) : ?>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card-body">
                        <h4 class="card-title text-center font-weight-bold"><?php echo $game['title']; ?></h4>
                        <div class="card h-100 shadow-lg rounded ">
                            <div class="image-container">
                                <img class="card-img-top mb-3 mt-2 " src="<?php echo $game['image']; ?>" alt="<?php echo $game['title']; ?>">
                            </div>
                            <form class="px-3" action="modifica_gioco.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="existing_title" value="<?php echo $game['title']; ?>">
                                <input type="hidden" name="id" value="<?php echo $game['id']; ?>">
                                <div class="form-group">
                                    <label for="title" class="bg-dark mb-3">Titolo:</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $game['title']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="image" class="bg-dark mt-1 mb-3">Immagine:</label>
                                    <input type="file" class="form-control-file" id="image" name="image" <?php if (empty($game['image'])) echo 'required'; ?>>
                                </div>
                                <div class="form-group d-flex justify-content-between ">
                                    <button type="submit" class="btn btn-warning shadow-lg rounded font-weight-bold ">MODIFICA</button>
                                    <form action="modifica_gioco.php" method="post" class="d-inline ml-2">
                                        <input type="hidden" name="id" value="<?php echo $game['id']; ?>">
                                    </form>
                                    <form action="elimina_gioco.php" method="post" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $game['id']; ?>">
                                        <button type="submit" class="btn btn-danger shadow-lg rounded font-weight-bold">ELIMINA</button>
                                    </form>
                                </div>
                            </form>



                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <a class="logout btn btn-primary shadow-lg rounded font-weight-bold mt-3 mb-3" href="logout.php">Logout</a>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>