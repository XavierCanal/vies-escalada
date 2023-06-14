<?php
require_once "includes/db.php";
$db = DB::get_instance();

if(!$db->connected()){
    header("Location: index.php?db-error");
} else {
    echo "Connected";
}
if (isset($_GET['error'])) {
    echo 'S\'ha produït un error inesperat';
}
?>
<a href='index.php'>Back</a>
<form action="afegir_participant.php" method="post">
    <h1>Escrutini</h1>
    <span>Escull la població on registrar les dades</span>
    <label>
        Nom
        <input name="nom" type="text" required>
    </label>
    <label>
        Cognom
        <input name="cognom" type="text" required>
    </label>
    <label>
        Correu
        <input name="correu" type="email" required>
    </label>

    <input type="hidden" id="comarca" name="comarca"/>
    <input type="hidden" id="demarcacio" name="demarcacio"/>

    <button>Inicia</button>
</form>
