<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["felhasznalonev"] != "admin") {
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <link rel="stylesheet" href="css/navStyle.css">
    <link rel="stylesheet" href="css/ugyfelekStyle.css">

    <title>Admin</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/ikon.jpg">

</head>
<body>
<?php
include "menu.php";

    $sql = 'SELECT * FROM penzforgalom';

function bank_csatlakozas(){

    try {
        $conn = new PDO("mysql:host=localhost;dbname=AdatbProject;charset=utf8", "root", "");
    } catch (PDOException $ex) {
        echo "Csatlakozási hiba: " . $ex->getMessage();
        die();
    }

    return $conn;
}

try {
    $res = bank_csatlakozas()->query($sql);
} catch (PDOException $ex) {
    echo "Csatlakozási hiba: " . $ex->getMessage();
    die();
}

echo '<main>';
echo '<table class="table">';
echo '<tr>
        <th colspan="9">Pénzforgalmak</th>
    </tr>';
echo '<tr>';
echo '<th>Azonosító</th>';
echo '<th>Típus</th>';
echo '<th>Megbízott név</th>';
echo '<th>Megbízott számalszáma</th>';
echo '<th>Közlemény</th>';
echo '<th>Helyszín</th>';
echo '<th>Megbízószámlaszám</th>';
echo '<th>Összeg</th>';
echo '<th>Dátum</th>';
echo '</tr>';
foreach ($res as $current_row) {
    echo '<tr>';
    for ($i = 0; $i < count($current_row) / 2; $i += 1) {
        if($current_row[$i] === NULL){
            echo '<td>' ."-" . '</td>';
        }else{
            if($i == 7){
                echo '<td>' . $current_row[$i] ." Ft". '</td>';
            }else{
                echo '<td>' . $current_row[$i] . '</td>';
            }

        }

    }
    echo '</tr>';


}
echo '</table>';
echo '</main>';

?>
</body>
</html>