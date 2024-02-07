<?php

require_once "config.php";


$book = [
    "titolo" => isset($_REQUEST['titolo']) ? $_REQUEST['titolo'] : '',
    "autore" => isset($_REQUEST['autore']) ? $_REQUEST['autore'] : '',
    "anno_pubblicazione" => isset($_REQUEST['anno']) ? $_REQUEST['anno'] : '',
    "genere" => isset($_REQUEST['genere']) ? $_REQUEST['genere'] : '',
];

function getAllBooks($mysqli)
{
    $libri = [];
    $sql = "SELECT * FROM libri;";
    $res = $mysqli->query($sql);
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $libri[] = $row;
        }
    }
    return $libri;
}


function addBook($mysqli, $book)
{
    $titolo = $book['titolo'];
    $autore = $book['autore'];
    $anno_pubblicazione = $book['anno_pubblicazione'];
    $genere = $book['genere'];

    $sql = "INSERT INTO libri (titolo, autore, anno_pubblicazione, genere) 
                VALUES ('$titolo', '$autore', '$anno_pubblicazione', '$genere')";
    if (!$mysqli->query($sql)) {
        echo ($mysqli->error);
    } else {
        echo 'Record aggiunto con successo!!!';
    }
    header('location: index.php');
}

function removeBook($mysqli, $id)
{
    if (!$mysqli->query('DELETE FROM libri WHERE id = ' . $id)) {
        echo ($mysqli->connect_error);
    } else {
        echo 'Libro rimosso con successo!';
    }
}


function updateBook($mysqli, $id, $titolo, $autore, $anno_pubblicazione, $genere)
{
    $sql = "UPDATE libri SET 
                        titolo = '" . $titolo . "', 
                        autore = '" . $autore . "',
                        anno_pubblicazione = '" . $anno_pubblicazione . "',
                        genere = '" . $genere . "'
                        WHERE id = " . $id;
    if (!$mysqli->query($sql)) {
        echo ($mysqli->connect_error);
    } else {
        echo 'Libro modificato con successo!';
    }
}


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









<?php
/*
require_once 'config.php';

include_once('function.php');

if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'login') {
    echo 'Sono nella sezione login';
    login($mysqli, $_REQUEST['email'], $_REQUEST['password']);
    exit(header('Location: http://localhost/S1L4_SQL/Esercizio/'));
} else if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'logout') {
    echo 'Sono nella sezione logout';
    session_unset();
    exit(header('Location: http://localhost/S1L4_SQL/Esercizio/'));
}

$contacts = [];
$target_dir = "uploads/";
$image = $target_dir . 'avatar.png';

if (!empty($_FILES['image'])) {
    if ($_FILES['image']["type"] === 'image/png' || $_FILES['image']["type"] === 'image/jpg') {
        if ($_FILES['image']["size"] < 4000000) {
            if (is_uploaded_file($_FILES['image']["tmp_name"]) && $_FILES['image']["error"] === UPLOAD_ERR_OK) {
                if (move_uploaded_file($_FILES['image']["tmp_name"], $target_dir . $_REQUEST['firstname'] . '-' . $_REQUEST['lastname'])) {
                    $image = $target_dir . $_REQUEST['firstname'] . '-' . $_REQUEST['lastname'];
                    echo 'Caricamento avvenuto con successo';
                } else {
                    echo 'Errore!!!';
                }
            }
        } else {
            echo 'FileSize troppo grande';
        }
    } else {
        echo 'FileType non supportato';
    }
}



if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'delete') {
    removeUser($mysqli, $_REQUEST['id']);
    exit(header('Location: http://localhost/S1L4_SQL/Esercizio/'));

} else if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'addpost') {
    $title = strlen(trim(htmlspecialchars($_REQUEST['title']))) > 2 ? trim(htmlspecialchars($_REQUEST['title'])) : exit();
    $description = strlen(trim(htmlspecialchars($_REQUEST['description']))) > 2 ? trim(htmlspecialchars($_REQUEST['description'])) : exit();
    addPost($mysqli, $title, $description);
    exit(header('Location: http://localhost/S1L4_SQL/Esercizio/detail.php'));
} else if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'update') {
    // fare i controlli di validazione dei campi
    $regexphone = '/(?:([+]\d{1,4})[-.\s]?)?(?:[(](\d{1,3})[)][-.\s]?)?(\d{1,4})[-.\s]?(\d{1,4})[-.\s]?(\d{1,9})/';
    preg_match_all($regexphone, htmlspecialchars($_REQUEST['phone']), $matches, PREG_SET_ORDER, 0);
    $regexemail = '/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/m';
    preg_match_all($regexemail, htmlspecialchars($_REQUEST['email']), $matchesEmail, PREG_SET_ORDER, 0);
    $regexPass = '/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/';
    preg_match_all($regexPass, htmlspecialchars($_REQUEST['password']), $matchesPass, PREG_SET_ORDER, 0);

    $firstname = strlen(trim(htmlspecialchars($_REQUEST['firstname']))) > 2 ? trim(htmlspecialchars($_REQUEST['firstname'])) : exit();
    $lastname = strlen(trim(htmlspecialchars($_REQUEST['lastname']))) > 2 ? trim(htmlspecialchars($_REQUEST['lastname'])) : exit();
    $city = strlen(trim(htmlspecialchars($_REQUEST['city']))) > 2 ? trim(htmlspecialchars($_REQUEST['city'])) : exit();
    $phone = $matches ? htmlspecialchars($_REQUEST['phone']) : exit();
    $email = $matchesEmail ? htmlspecialchars($_REQUEST['email']) : exit();
    $pass = $matchesPass ? htmlspecialchars($_REQUEST['password']) : exit();
    $password = password_hash($pass, PASSWORD_DEFAULT);

    updateUser($mysqli, $_REQUEST['id'], $firstname, $lastname, $city, $phone, $email, $password, $image);
    exit(header('Location: http://localhost/S1L4_SQL/Esercizio/'));
} else {

    // fare i controlli di validazione dei campi
    $regexphone = '/(?:([+]\d{1,4})[-.\s]?)?(?:[(](\d{1,3})[)][-.\s]?)?(\d{1,4})[-.\s]?(\d{1,4})[-.\s]?(\d{1,9})/';
    preg_match_all($regexphone, htmlspecialchars($_REQUEST['phone']), $matches, PREG_SET_ORDER, 0);
    $regexemail = '/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/m';
    preg_match_all($regexemail, htmlspecialchars($_REQUEST['email']), $matchesEmail, PREG_SET_ORDER, 0);
    $regexPass = '/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/';
    preg_match_all($regexPass, htmlspecialchars($_REQUEST['password']), $matchesPass, PREG_SET_ORDER, 0);

    $firstname = strlen(trim(htmlspecialchars($_REQUEST['firstname']))) > 2 ? trim(htmlspecialchars($_REQUEST['firstname'])) : exit();
    $lastname = strlen(trim(htmlspecialchars($_REQUEST['lastname']))) > 2 ? trim(htmlspecialchars($_REQUEST['lastname'])) : exit();
    $city = strlen(trim(htmlspecialchars($_REQUEST['city']))) > 2 ? trim(htmlspecialchars($_REQUEST['city'])) : exit();
    $phone = $matches ? htmlspecialchars($_REQUEST['phone']) : exit();
    $email = $matchesEmail ? htmlspecialchars($_REQUEST['email']) : exit();
    $pass = $matchesPass ? htmlspecialchars($_REQUEST['password']) : exit();
    $password = password_hash($pass, PASSWORD_DEFAULT);

    createUser($mysqli, $firstname, $lastname, $city, $phone, $email, $password, $image);
}

?> */




