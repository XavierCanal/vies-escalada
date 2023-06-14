<a href='index.php'>Back</a>
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

$data = $db->get_assoliments_participants();
echo "<table style='border: aquamarine'>";
echo "<tr>";
echo "<th>Participant</th>";
echo "<th>Via</th>";
echo "<th>Intent</th>";
echo "<th>Data</th>";
echo "<th>Encadenat</th>";
echo "<th>Primer</th>";
echo "<th>Assegurador</th>";
echo "<th>Grau</th>";
echo "</tr>";
foreach ($data as $d) {
    $encadenat = '';
    $primer = '';
    if ($d["encadenat"] == 1) {
        $d["encadenat"] = "Si";
        $encadenat = "color: #2062ff;";
    } else {
        $d["encadenat"] = "No";
    }
    if ($d["primer"] == 1) {
        $d["primer"] = "Si";
        $primer = "font-weight: bold;";
    } else {
        $d["primer"] = "No";
    }
    echo "<tr>";
    echo "<td>" . $d["nom"] . " " . $d["cognom"] . "</td>";
    echo "<td style='$encadenat $primer'>" . $d["via"] . "</td>";
    echo "<td>" . $d["intent"] . "</td>";
    echo "<td>" . $d["data"] . "</td>";
    echo "<td>" . $d["encadenat"] . "</td>";
    echo "<td>" . $d["primer"] . "</td>";
    echo "<td>" . $d["assegurador"] . "</td>";
    echo "<td>" . $d["grau"] . "</td>";
    echo "</tr>";
}
?>

<style>
    table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table td, table th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    table tr:nth-child(even){background-color: #f2f2f2;}

    table tr:hover {background-color: #ddd;}

    table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }
</style>
