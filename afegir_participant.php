<?php
require_once "includes/db.php";

// Comprova si tenim les dades necessàries
if (empty($_POST["nom"]) || empty($_POST["cognom"]) || empty($_POST["correu"])) {
    header("Location: index.php?error");
}

$db = DB::get_instance();

if ($db->connected()) {
    if ($db->add_participant($_POST["nom"], $_POST["cognom"], $_POST["correu"])) {
        header("Location: index.php?register-success");
    } else {
        header("Location: index.php?register-error");
    }

}
else
{
    echo "<p class='message error' id='message'> No es pot connectar amb la base de dades </p>";
}
