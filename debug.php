<?php
require_once "includes/db.php";
$db = DB::get_instance();
if(!$db->connected()){
    header("Location: index.php?db-error");
} else {
    echo "Connected";
}
?>

<a href='index.php'>Back</a>
<br> <br>
<form action="debug.php" method="post">
    Eliminar tots els assoliments
    <input type="submit" name="eliminarAssoliments" value="GO" />
</form>

<form action="debug.php" method="post">
    Eliminar tots els participants
    <input type="submit" name="eliminarParticipants" value="GO" />
</form>

<form action="debug.php" method="post">
    Eliminar vies i sectors
    <input type="submit" name="eliminarViesSectors" value="GO" />
</form>

<form action="debug.php" method="post">
    Emplenar vies i sectors
    <input type="submit" name="generarViesSectors" value="GO" />
</form>

<?php
if (isset($_POST['eliminarAssoliments'])) {

    $db->eliminar_assoliments();
}

if (isset($_POST['eliminarParticipants'])) {

    $db->eliminar_participants();
}

if (isset($_POST['eliminarViesSectors'])) {

    $db->eliminar_vies_sectors();
}

if (isset($_POST['generarViesSectors'])) {

    $db->generar_vies_sectors();
}

