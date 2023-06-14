<?php
require_once "includes/db.php";
$db = DB::get_instance();

if (!$db->connected()) {
    header("Location: index.php?db-error");
} else {
    echo "Connected";
}
if (isset($_GET['error'])) {
    echo 'S\'ha produït un error inesperat';
}

if (isset($_POST['participant'])) {
    $participant = $_POST['participant'];
    $via = $_POST['via'];
    $data = $_POST['data'];
    $encadenat = isset($_POST['encadenat']);
    $primer = isset($_POST['primer']);
    $assegurador = $_POST['assegurador'];
    if($participant === $assegurador) {
        header("Location: assoliments.php?assegurador-equal-participant");
        return;
    }
    $db->afegir_assoliment($participant, $via, $data, $encadenat, $primer, $assegurador);
    header("Location: index.php?register-success");
}
