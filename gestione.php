<?php

require_once "config.php";
require_once "function.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titolo = !empty(trim($_POST['titolo'])) ? trim(htmlspecialchars($_POST['titolo'])) : null;
    $autore = !empty(trim($_POST['autore'])) ? trim(htmlspecialchars($_POST['autore'])) : null;
    $anno_pubblicazione = !empty(trim($_POST['anno_pubblicazione'])) ? trim(htmlspecialchars($_POST['anno_pubblicazione'])) : null;
    $genere = !empty(trim($_POST['genere'])) ? trim(htmlspecialchars($_POST['genere'])) : null;

    if ($titolo && $autore && $anno_pubblicazione && $genere) {
        $book = [
            "titolo" => $titolo,
            "autore" => $autore,
            "anno_pubblicazione" => $anno_pubblicazione,
            "genere" => $genere,
        ];
        addBook($mysqli, $book);
    } else {
        echo 'Per favore, compila tutti i campi.';
    }
}

$book = [
    "titolo" => isset($_REQUEST['titolo']) ? $_REQUEST['titolo'] : '',
    "autore" => isset($_REQUEST['autore']) ? $_REQUEST['autore'] : '',
    "anno_pubblicazione" => isset($_REQUEST['anno']) ? $_REQUEST['anno'] : '',
    "genere" => isset($_REQUEST['genere']) ? $_REQUEST['genere'] : '',
];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        updateBook($mysqli, $_POST['id'], $_POST['titoloUp'], $_POST['autoreUp'], $_POST['annoUp'], $_POST['genereUp']);
        exit(header('Location: index.php'));
    } else {
        addBook($mysqli, $book);
    }

} else if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'remove') {
    removeBook($mysqli, $_REQUEST['id']);
    exit(header('Location: index.php'));
}


?>