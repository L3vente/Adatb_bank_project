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
include "augyfeltorles.php";
//ugyfel.ugyfelid = jogiszemely.ugyfelid AND ugyfel.ugyfelid = maganszemely.ugyfelid AND
if(isset($_POST["atlag"]) && isset($_POST["leker"])){
    $sql = "SELECT ugyfel.ugyfelid,maganszemely.vezeteknev,maganszemely.keresztnev,jogiszemely.cegnev,bankszamla.szamlaszam,bankszamla.egyenleg,bankszamla.banknev,bankszamla.tipus FROM ugyfel,bankszamla,tulajdona,jogiszemely,maganszemely WHERE maganszemely.ugyfelid = ugyfel.ugyfelid AND jogiszemely.ugyfelid = ugyfel.ugyfelid AND bankszamla.szamlaszam = tulajdona.szamlaszam AND ugyfel.ugyfelid = tulajdona.ugyfelid AND bankszamla.egyenleg > (SELECT avg(bankszamla.egyenleg) as atlag FROM bankszamla)";
    $_SESSION["user"]["sql"] = $sql;
}else if (isset($_POST["szamlaszam"]) && trim($_POST["szamlaszam"]) !== "" && isset($_POST["leker"])){
    $szamlaszam = $_POST["szamlaszam"];
    $sql = 'SELECT ugyfel.ugyfelid,maganszemely.vezeteknev,maganszemely.keresztnev,jogiszemely.cegnev,bankszamla.szamlaszam,bankszamla.egyenleg,bankszamla.banknev,bankszamla.tipus FROM ugyfel,bankszamla,tulajdona,jogiszemely,maganszemely WHERE maganszemely.ugyfelid = ugyfel.ugyfelid AND jogiszemely.ugyfelid = ugyfel.ugyfelid AND bankszamla.szamlaszam = tulajdona.szamlaszam AND ugyfel.ugyfelid = tulajdona.ugyfelid AND bankszamla.szamlaszam LIKE "'.$szamlaszam.'"';
    $_SESSION["user"]["sql"] = $sql;
} else if(isset($_POST["leker"]) && isset($_POST["osszes"])){
    $sql = "SELECT ugyfel.ugyfelid,maganszemely.vezeteknev,maganszemely.keresztnev,jogiszemely.cegnev,bankszamla.szamlaszam,bankszamla.egyenleg,bankszamla.banknev,bankszamla.tipus FROM ugyfel,bankszamla,tulajdona,jogiszemely,maganszemely WHERE maganszemely.ugyfelid = ugyfel.ugyfelid AND jogiszemely.ugyfelid = ugyfel.ugyfelid AND bankszamla.szamlaszam = tulajdona.szamlaszam AND ugyfel.ugyfelid = tulajdona.ugyfelid";
    $_SESSION["user"]["sql"] = $sql;
}else{
    $sql = $_SESSION["user"]["sql"];
}

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
        <th colspan="9">Ügyfelek</th>
    </tr>';
echo '<tr>';
echo '<th>Ügyfélid</th>';
echo '<th>Vezetéknév</th>';
echo '<th>Keresztnév</th>';
echo '<th>Cégnév</th>';
echo '<th>Számlaszám</th>';
echo '<th>Egyenleg</th>';
echo '<th>Bank</th>';
echo '<th>Típus</th>';
echo '<th>Törlés</th>';
echo '</tr>';
foreach ($res as $current_row) {
    echo '<tr>';
    for ($i = 0; $i < count($current_row) / 2; $i += 1) {
        if($current_row[$i] === NULL){
            echo '<td>' ."-" . '</td>';
        }else{
            if($i == 5){
                echo '<td>' . $current_row[$i] ." Ft". '</td>';
            }else{
                echo '<td>' . $current_row[$i] . '</td>';
            }

        }

    }
    echo '<td><form action="aszamladel.php" method="post"><input type="hidden" name="szamlak" value="' .$current_row[4].'"><button type="submit" class="torles2" name="torol">Törlés</button></form></td>';
    echo '</tr>';


}
echo '</table>';
echo '</main>';

?>
</body>
</html>
