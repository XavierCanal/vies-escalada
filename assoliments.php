<?php

require_once "includes/db.php";
$db = DB::get_instance();

if (!$db->connected()) {
    header("Location: index.php?db-error");
} else {
    echo "Connected <br>";
}
if (isset($_GET['error'])) {
    echo 'S\'ha produït un error inesperat';
}
if (isset($_GET['assegurador-equal-participant'])) {
    echo 'ERROR: L\'assegurador no pot ser el mateix que el participant <br>';
}
?>
<a href='index.php'>Back</a>
<form action="afegir_assoliment.php" method="post">
    <h1>Assoliments</h1>
    Participant:
    <label for="participant">
        <input  list="participant" name="participant" type="text" required>
    </label> <br> <br>

    <datalist id="participant">
        <?php

        $participant = $db->get_participants();
        foreach ($participant as $p){

            $nom = $p["nom"];
            $cog = $p["cognom"];
            $email = $p["email"];
            echo "<option value='$email'> $nom $cog </option> \n";
        }
        ?>
    </datalist>
    Via
    <label for="via">
        <input  list="via" name="via" type="text" required>
    </label><br> <br>

    <datalist id="via">
        <?php

        $via = $db->get_vies();
        foreach ($via as $v){
            $nom = $v["nom"];
            $sector = $v["sector"];
            $grau = $v["grau"];
            echo "<option value='$nom'>Sector: $sector - Grau: $grau</option> \n";
        }
        ?>
    </datalist>
    <label>
        Data
        <input name="data" type="date" required>
    </label><br> <br>
    <label>
        Encadenat
        <input name="encadenat" type="checkbox">
    </label><br> <br>
    <label>
        Primer
        <input name="primer" type="checkbox">
    </label><br> <br>
    Assegurador:
    <label for="assegurador">
        <input  list="assegurador" name="assegurador" type="text" required>
    </label> <br> <br>

    <datalist id="assegurador">
        <?php
        foreach ($participant as $p){

            $nom = $p["nom"];
            $cog = $p["cognom"];
            $email = $p["email"];
            echo "<option value='$email'> $nom $cog </option> \n";
        }
        ?>
    </datalist>
    <button>Guarda</button>
</form>
