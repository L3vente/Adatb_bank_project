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
    <link rel="stylesheet" href="css/formStyle.css">

    <title>Admin</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/ikon.jpg">
</head>
<body>
<?php
include "menu.php";
function bank_csatlakozas()
{

    try {
        $conn = new PDO("mysql:host=localhost;dbname=AdatbProject;charset=utf8", "root", "");
    } catch (PDOException $ex) {
        echo '<script>alert("Sikertelen csat!")</script>';
        die();
    }

    return $conn;
}
if (isset($_POST["szerkeszt"])) {
    $bfiokszam = $_POST["bfiokszam"];
    $sql = "SELECT bank.nev,bank.szekhely,bankfiok.bfiokszam,bankfiok.cim FROM bank,bankfiok WHERE bank.nev = bankfiok.nev AND bankfiok.bfiokszam = $bfiokszam";
    $conn = bank_csatlakozas();
    $res = $conn->query($sql);

    foreach ($res as $current_row){
            $adat = $current_row;
            break;
    }
}
if(isset($_POST["modositt"])){
    $nev = $_POST["banknev"];
    $szekhely = $_POST["szekhely"];
    $bfiokcim = $_POST["bfiokcim"];
    $bfiokszam = $_POST["bfiokszam"];
    $erbank = $_POST["erbank"];
    $stmt = bank_csatlakozas()->prepare('BEGIN;
    UPDATE bank SET nev = :nev, szekhely = :szekhely WHERE nev = :erbank;
    UPDATE bankfiok SET cim = :cim WHERE bfiokszam = :bfiokszam;
    COMMIT;');
    $stmt->bindParam(':nev', $nev, PDO::PARAM_STR, 256);
    $stmt->bindParam(':szekhely', $szekhely, PDO::PARAM_STR, 256);
    $stmt->bindParam(':erbank', $erbank, PDO::PARAM_STR, 256);
    $stmt->bindParam(':cim', $bfiokcim, PDO::PARAM_STR, 256);
    $stmt->bindParam(':bfiokszam', $bfiokszam, PDO::PARAM_INT, 11);
    $stmt->execute();
    $conn = null;
    echo '<script>alert("Sikeres módosítás!")</script>';
    echo '<meta http-equiv="Refresh" content="0;url=abankok.php">';
    die();
}
?>
<div id="id11" style="display: block" class="modal">
    <form class="modal-content animate" method="POST" accept-charset="utf-8">
        <div class="container">
            <span onclick="megse()" class="close" title="Close Modal">&times;</span>
            <h1>Bank/bankfiók módosítása adatok módosítása</h1>
            <hr>
            <label for="banknev"><b>Banknév</b></label>
            <input type="text" name="banknev" value="<?= $adat["nev"] ?>" required/>
            <label for="szekhely"><b>Széhely</b></label>
            <input type="text" name="szekhely" value="<?= $adat["szekhely"] ?>" required/>
            <hr>
            <label for="bfiokszam"><b>Bankfiókszám</b></label>
            <input type="number" name="bfiokszam" value="<?= $adat["bfiokszam"] ?>" readonly/>
            <label for="bfiokcim"><b>Bankfiókcím</b></label>
            <input type="text" name="bfiokcim" value="<?= $adat["cim"] ?>" required/>
            <input type="hidden" name="erbank" value="<?= $adat["nev"] ?>">
            <button type="submit" class="nagy" name="modositt">Elküld</button>
        </div>
    </form>
</div>
</body>
</html>
<script>
    function megse() {
        window.open("abankok.php", "_self");
    }
</script>
