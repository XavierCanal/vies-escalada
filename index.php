<?php
if (isset($_GET['register-success'])) {
    echo 'S\'ha registrat correctament <br>';
}
if (isset($_GET['register-error'])) {
    echo 'Error al registrar, recorda que el camp email ha de ser unic. <br>';
}
if (isset($_GET['error'])) {
    echo 'Error inesperat <br>';
}
if (isset($_GET['db-error'])) {
    echo 'Error amb la base de dades. <br>';
}
?>
<a href='registre.php'>Registrar-se</a>
<br>
<a href='assoliments.php'>Assoliments</a>
<br>
<a href='participants.php'>Participants</a>
<br>
<a href='debug.php'>Debug</a>
<br>
<a href='estadistiques.php'>Estadistiques</a>
