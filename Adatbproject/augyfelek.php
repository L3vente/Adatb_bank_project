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
if(isset($_POST["szem"]) && trim($_POST["szem"]) !== "" && isset($_POST["leker"])){
    $szemelyi = $_POST["szem"];
    $sql = "SELECT ugyfel.ugyfelid,ugyfel.telefonszam,ugyfel.email,maganszemely.szemelyiszam,maganszemely.lakcim,maganszemely.vezeteknev,maganszemely.keresztnev,jogiszemely.cegnev,jogiszemely.adoszam,jogiszemely.szekhely FROM ugyfel,jogiszemely,maganszemely WHERE ugyfel.ugyfelid = jogiszemely.ugyfelid AND ugyfel.ugyfelid = maganszemely.ugyfelid AND maganszemely.szemelyiszam LIKE '$szemelyi'";
    $_SESSION["user"]["elozosql"] = $sql;
}else if (isset($_POST["cegnev"]) && trim($_POST["cegnev"]) !== "" && isset($_POST["leker"])){
    $cegnev = $_POST["cegnev"];
    $sql = "SELECT ugyfel.ugyfelid,ugyfel.telefonszam,ugyfel.email,maganszemely.szemelyiszam,maganszemely.lakcim,maganszemely.vezeteknev,maganszemely.keresztnev,jogiszemely.cegnev,jogiszemely.adoszam,jogiszemely.szekhely FROM ugyfel,jogiszemely,maganszemely WHERE ugyfel.ugyfelid = jogiszemely.ugyfelid AND ugyfel.ugyfelid = maganszemely.ugyfelid AND jogiszemely.cegnev LIKE '$cegnev'";
    $_SESSION["user"]["elozosql"] = $sql;
}else if((isset($_POST["lakcim"]) && trim($_POST["lakcim"]) !== "" && isset($_POST["leker"]))){
    $lakcim = $_POST["lakcim"];
    $sql = 'SELECT ugyfel.ugyfelid,ugyfel.telefonszam,ugyfel.email,maganszemely.szemelyiszam,maganszemely.lakcim,maganszemely.vezeteknev,maganszemely.keresztnev,jogiszemely.cegnev,jogiszemely.adoszam,jogiszemely.szekhely FROM ugyfel,jogiszemely,maganszemely WHERE ugyfel.ugyfelid = jogiszemely.ugyfelid AND ugyfel.ugyfelid = maganszemely.ugyfelid AND maganszemely.lakcim LIKE "'.$lakcim.'"';
    $_SESSION["user"]["elozosql"] = $sql;
}else if((isset($_POST["szekhely"]) && trim($_POST["szekhely"]) !== "" && isset($_POST["leker"]))){
    $szekhely = $_POST["szekhely"];
    $sql = "SELECT ugyfel.ugyfelid,ugyfel.telefonszam,ugyfel.email,maganszemely.szemelyiszam,maganszemely.lakcim,maganszemely.vezeteknev,maganszemely.keresztnev,jogiszemely.cegnev,jogiszemely.adoszam,jogiszemely.szekhely FROM ugyfel,jogiszemely,maganszemely WHERE ugyfel.ugyfelid = jogiszemely.ugyfelid AND ugyfel.ugyfelid = maganszemely.ugyfelid AND jogiszemely.szekhely LIKE '$szekhely'";
    $_SESSION["user"]["elozosql"] = $sql;
}else if(isset($_POST["leker"]) && isset($_POST["szamlaszam"]) && trim($_POST["szamlaszam"]) !== ""){
    $szamlaszam = $_POST["szamlaszam"];
    $sql = 'SELECT ugyfel.ugyfelid,ugyfel.telefonszam,ugyfel.email,maganszemely.szemelyiszam,maganszemely.lakcim,maganszemely.vezeteknev,maganszemely.keresztnev,jogiszemely.cegnev,jogiszemely.adoszam,jogiszemely.szekhely FROM ugyfel,jogiszemely,maganszemely,bankszamla,tulajdona WHERE ugyfel.ugyfelid = jogiszemely.ugyfelid AND ugyfel.ugyfelid = maganszemely.ugyfelid AND bankszamla.szamlaszam = tulajdona.szamlaszam AND ugyfel.ugyfelid = tulajdona.ugyfelid AND bankszamla.szamlaszam LIKE "'.$szamlaszam.'"';
} else if(isset($_POST["leker"]) && isset($_POST["osszes"])){
    $sql = "SELECT ugyfel.ugyfelid,ugyfel.telefonszam,ugyfel.email,maganszemely.szemelyiszam,maganszemely.lakcim,maganszemely.vezeteknev,maganszemely.keresztnev,jogiszemely.cegnev,jogiszemely.adoszam,jogiszemely.szekhely FROM ugyfel,jogiszemely,maganszemely WHERE ugyfel.ugyfelid = jogiszemely.ugyfelid AND ugyfel.ugyfelid = maganszemely.ugyfelid";
    $_SESSION["user"]["elozosql"] = $sql;
}else if(isset($_POST["leker"]) && isset($_POST["ceg"])){
    $sql = "SELECT ugyfel.ugyfelid,ugyfel.telefonszam,ugyfel.email,maganszemely.szemelyiszam,maganszemely.lakcim,maganszemely.vezeteknev,maganszemely.keresztnev,jogiszemely.cegnev,jogiszemely.adoszam,jogiszemely.szekhely FROM ugyfel,jogiszemely,maganszemely WHERE ugyfel.ugyfelid = jogiszemely.ugyfelid AND ugyfel.ugyfelid = maganszemely.ugyfelid AND jogiszemely.cegnev NOT LIKE 'NULL'";
    $_SESSION["user"]["elozosql"] = $sql;
}else if(isset($_POST["leker"])){
    $sql = "SELECT ugyfel.ugyfelid,ugyfel.telefonszam,ugyfel.email,maganszemely.szemelyiszam,maganszemely.lakcim,maganszemely.vezeteknev,maganszemely.keresztnev,jogiszemely.cegnev,jogiszemely.adoszam,jogiszemely.szekhely FROM ugyfel,jogiszemely,maganszemely WHERE ugyfel.ugyfelid = jogiszemely.ugyfelid AND ugyfel.ugyfelid = maganszemely.ugyfelid AND maganszemely.szemelyiszam NOT LIKE 'NULL'";
    $_SESSION["user"]["elozosql"] = $sql;
}else {
        $sql  = $_SESSION["user"]["elozosql"];
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
        <th colspan="13">Ügyfelek</th>
    </tr>';
echo '<tr>';


echo '<th>Ügyfélid</th>';
echo '<th>Telefonszám</th>';
echo '<th>E-mail cím</th>';
echo '<th>Személyiszám</th>';
echo '<th>Lakcím</th>';
echo '<th>Vez</th>';
echo '<th>Ker</th>';
echo '<th>Cégnév</th>';
echo '<th>Adószám</th>';
echo '<th>Székhely</th>';
echo '<th colspan="2">Szerkesztés</th>';

echo '</tr>';
foreach ($res as $current_row) {
    echo '<form action="augyfelmodForm.php" method="POST">';
    echo '<tr>';
    for ($i = 0; $i < count($current_row) / 2; $i += 1) {
        if($current_row[$i] == NULL){
            echo '<td>' ."-" . '</td>';
        }else{
            echo '<td>' . $current_row[$i] . '</td>';
        }

    }
    echo '<td><input type="hidden" name="ugyfelid" value="' . $current_row[0] . '"><button class="nagy" type="submit" name="szerkeszt">Szerkesztés</button></form></td>';
    echo '<td><form method="post"><input type="hidden" name="ugyfelid" value="' . $current_row[0] . '"><button class="torles2" type="submit" name="torles">Törlés</button></form></td>';
    echo '</tr>';


}
echo '</table>';
echo '</main>';

?>
</body>
</html>
