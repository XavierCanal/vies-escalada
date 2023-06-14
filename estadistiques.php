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

$top_dificultat = $db->get_top_dificultat();
echo "<h2>Top dificultat</h2>";
echo "<table style='border: aquamarine'>";
echo "<tr>";
echo "<th>Participant</th>";
echo "<th>Via</th>";
echo "<th>Grau</th>";
echo "</tr>";
foreach ($top_dificultat as $d) {
    echo "<tr>";
    echo "<td>" . $d["nom"] . " " . $d["cognom"] . "</td>";
    echo "<td>" . $d["via"] . "</td>";
    echo "<td>" . $d["grau"] . "</td>";
    echo "</tr>";
}

$top_ranquing_mes_vies = $db->get_participants_with_more_vies();

echo "<table style='border: aquamarine'>";
echo "<h2>Top ranquing mes vies</h2>";
echo "<tr>";
echo "<th>Participant</th>";
echo "<th>Vies</th>";
echo "</tr>";
foreach ($top_ranquing_mes_vies as $d) {
    echo "<tr>";
    echo "<td>" . $d["nom"] . " " . $d["cognom"] . "</td>";
    echo "<td>" . $d["num_assoliments"] . "</td>";
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
