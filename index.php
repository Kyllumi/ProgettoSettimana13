<?php
require_once 'config.php';
require_once 'gestione.php';

$libri = getAllBooks($mysqli);

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libreria - Libri Per Tutti!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-dark">

    <nav class="navbar navbar-expand-lg bg-dark text-white">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Link</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <button type="button" class="btn btn-primary mt-4 d-flex mx-auto" data-bs-toggle="modal"
        data-bs-target="#modaleAggiunta">
        Aggiungi un libro
    </button>

    <table class="table table-dark table-hover container mt-4 border">
        <thead>
            <tr class="text-center">
                <th scope="col">ID</th>
                <th scope="col">Titolo</th>
                <th scope="col">Autore</th>
                <th scope="col">Anno</th>
                <th scope="col">Genere</th>
                <th scope="col">Azioni</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            foreach ($libri as $key => $libro) {
                echo '<tr class="text-center">
                        <th scope="row">' . $libro['id'] . '</th>
                        <td>' . $libro['titolo'] . '</td>
                        <td>' . $libro['autore'] . '</td>
                        <td>' . $libro['anno_pubblicazione'] . '</td>
                        <td>' . $libro['genere'] . '</td>
                        <th>
                            <div class="d-flex justify-content-evenly align-items-center">
                                <a role="button" class="btn btn-warning px-2 py-1" data-bs-toggle="modal"
                                    data-bs-target="#modaleUpdate_' . $libro['id'] . '"><i class="bi bi-pencil-square"></i></a>
                                <a role="button" class="btn btn-danger px-2 py-1" href="gestione.php?action=remove&id=' . $libro['id'] . '"><i class="bi bi-x-lg"></i></a>
                            </div>
                        </th>
                    </tr>';

                // Modale per l'aggiunta di un libro
                echo '<div class="modal fade" id="modaleAggiunta" tabindex="-1" aria-labelledby="modaleAggiunta" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Dati del libro</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="gestione.php">
                                        <div class="mb-3">
                                            <label for="titoloLibro" class="form-label">Titolo</label>
                                            <input type="text" class="form-control" id="titoloLibro" aria-describedby="titoloLibro"
                                                name="titolo">
                                        </div>
                                        <div class="mb-3">
                                            <label for="autoreLibro" class="form-label">Autore</label>
                                            <input type="text" class="form-control" id="autoreLibro" name="autore">
                                        </div>
                                        <div class="mb-3">
                                            <label for="annoLibro" class="form-label">Anno di pubblicazione</label>
                                            <input type="number" step="1" class="form-control" id="annoLibro" name="anno">
                                        </div>
                                        <div class="mb-3">
                                            <label for="genereLibro" class="form-label">Genere</label>
                                            <input type="text" class="form-control" id="genereLibro" name="genere">
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Aggiungi il libro</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>';

                // Modale per l'aggiornamento di un libro
                echo '<div class="modal fade" id="modaleUpdate_' . $libro['id'] . '" tabindex="-1" aria-labelledby="modaleUpdate" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Modifica i dati</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="gestione.php">
                                    <input type="hidden" name="id" value="' . $libro['id'] . '">
                                        <div class="mb-3">
                                            <label for="titoloLibro" class="form-label">Titolo</label>
                                            <input type="text" class="form-control" id="titoloLibro" aria-describedby="titoloLibro"
                                                name="titoloUp" value=" ' . $libro['titolo'] . '">
                                        </div>
                                        <div class="mb-3">
                                            <label for="autoreLibro" class="form-label">Autore</label>
                                            <input type="text" class="form-control" id="autoreLibro" name="autoreUp"
                                                value="' . $libro['autore'] . ' ">
                                        </div>
                                        <div class="mb-3">
                                            <label for="annoLibro" class="form-label">Anno di pubblicazione</label>
                                            <input type="number" step="1" class="form-control" id="annoLibro" name="annoUp"
                                                value="' . $libro['anno_pubblicazione'] . ' ">
                                        </div>
                                        <div class="mb-3">
                                            <label for="genereLibro" class="form-label">Genere</label>
                                            <input type="text" class="form-control" id="genereLibro" name="genereUp"
                                                value=" ' . $libro['genere'] . ' ">
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                            <button type="submit" class="btn btn-primary" name="action" value="update">Aggiorna libro</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
            ?>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>