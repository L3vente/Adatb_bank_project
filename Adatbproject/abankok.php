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
function bank_csatlakozas(){

    try {
        $conn = new PDO("mysql:host=localhost;dbname=AdatbProject;charset=utf8", "root", "");
    } catch (PDOException $ex) {
        echo "Csatlakozási hiba: " . $ex->getMessage();
        die();
    }

    return $conn;
}
$sql = "SELECT bank.nev as bnev,bank.szekhely,bankfiok.bfiokszam,bankfiok.cim as bankfiokcim FROM bank, bankfiok WHERE bank.nev = bankfiok.nev ORDER BY bank.nev";
$res = bank_csatlakozas()->query($sql);
echo '<main>';
echo '<table class="table">';
echo '<tr>
            <th colspan="6">Bankok és bankfiókjaik</th>
        </tr>';
echo '<tr>';


echo '<th>Banknév</th>';
echo '<th>Székhely</th>';
echo '<th>Bankfiókszám</th>';
echo '<th>Bankfiókcím</th>';
echo '<th colspan="1">Szerkesztés</th>';
echo '</tr>';
$sql1 = "SELECT COUNT(bank.nev) as db FROM bank,bankfiok WHERE bank.nev = bankfiok.nev GROUP BY bank.nev ORDER BY bank.nev";
$res1 = bank_csatlakozas()->query($sql1);
$szamok = [];
$i = 0;
foreach ($res1 as $current_row2){
    $szamok[$i++] = $current_row2["db"];
}
$i = 0;
foreach ($res as $current_row) {
    echo '<tr>';
    if(!isset($bankok[$current_row["bnev"]])){
        $bankok[$current_row["bnev"]] = 0;
        if($i % 2 === 0){
            echo '<td rowspan="'.$szamok[$i].'" style="background-color: #f3f3f3">'.$current_row["bnev"].'</td>';
            echo '<td rowspan="'.$szamok[$i].'" style="background-color: #f3f3f3">'.$current_row["szekhely"].'</td>';
        }else{
            echo '<td rowspan="'.$szamok[$i].'"style="background-color: rgba(192, 192, 192, 0.87)">'.$current_row["bnev"].'</td>';
            echo '<td rowspan="'.$szamok[$i].'"style="background-color: rgba(192, 192, 192, 0.87)">'.$current_row["szekhely"].'</td>';
        }
        echo '<td>'.$current_row["bfiokszam"].'</td>';
        echo '<td>'.$current_row["bankfiokcim"].'</td>';
        echo '<td><form method="post" action="abnkmod.php"><input type="hidden" name="bfiokszam" value="' . $current_row["bfiokszam"] . '"><button class="nagy" type="submit" name="szerkeszt">Szerkesztés</button></form></td>';
        $i++;
    }else{
        echo '<td>'.$current_row["bfiokszam"].'</td>';
        echo '<td>'.$current_row["bankfiokcim"].'</td>';
        echo '<td><form method="post" action="abnkmod.php"><input type="hidden" name="bfiokszam" value="' . $current_row["bfiokszam"] . '"><button class="nagy" type="submit" name="szerkeszt">Szerkesztés</button></form></td>';
    }
    echo '</tr>';



}
echo '</table>';
echo '</main>';

?>
</body>
</html>

