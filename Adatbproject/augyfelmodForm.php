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

if (isset($_POST["modosit"])) {
    if (!isset($_POST["phone"]) || trim($_POST["phone"]) === "" || !isset($_POST["email"]) || trim($_POST["email"]) === "") {

        echo '<script>alert("Hiba: Adj meg minden adatot!")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=augyfelek.php">';
        die();
    } else {
        if(!(!isset($_POST["cegnev"]) || trim($_POST["cegnev"]) === "" || !isset($_POST["ado"]) || trim($_POST["ado"]) === "" || !isset($_POST["szek"]) || trim($_POST["szek"]) === "" )){
            $ceg = $_POST["cegnev"];
            $ado = $_POST["ado"];
            $szek = $_POST["szek"];
            $vez = null;
            $ker = null;
            $lak = null;
            $szemig = null;
        }else if(isset($_POST["vez"]) && trim($_POST["vez"]) !== "" && isset($_POST["ker"]) && trim($_POST["ker"]) !== "" && isset($_POST["cim"]) && trim($_POST["cim"]) !== "" && isset($_POST["szem"]) && trim($_POST["szem"]) !== ""){
            $vez = $_POST['vez'];
            $ker = $_POST['ker'];
            $lak = $_POST['cim'];
            $szemig = $_POST["szem"];
            $ceg = null;
            $ado = null;
            $szek = null;
        }else{
            echo '<script>alert("Hiba: Adj meg minden adatot! specs")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=augyfelek.php">';
            die();
        }
        $tel = $_POST['phone'];
        $email = $_POST['email'];
        $id = $_POST["ugyfelid"];


        $sikeres = ugyfelet_modosit($id, $tel, $email, $vez, $ker, $lak, $szemig,$ceg,$ado,$szek);


        if ($sikeres) {
            echo '<script>alert("Sikeres módosítás")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=augyfelek.php">';
            die();
        } else {
            echo '<script>alert("Sikertelen módosítás!")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=augyfelek.php">';
            die();
        }
    }

}
function bank_csatlakozas()
{

    try {
        $conn = new PDO("mysql:host=localhost;dbname=AdatbProject;charset=utf8", "root", "");
    } catch (PDOException $ex) {
        echo '<script>alert("Sikertelen csat!")</script>';
        echo "Csatlakozási hiba: " . $ex->getMessage();
        die();
    }

    return $conn;
}

function ugyfelet_leker(){
    $id = $_POST["ugyfelid"];
    $sql = "SELECT ugyfel.ugyfelid,ugyfel.felhasznalonev,ugyfel.telefonszam,ugyfel.email,maganszemely.szemelyiszam,maganszemely.lakcim,maganszemely.vezeteknev,maganszemely.keresztnev,jogiszemely.cegnev,jogiszemely.adoszam,jogiszemely.szekhely FROM ugyfel,jogiszemely,maganszemely WHERE ugyfel.ugyfelid = jogiszemely.ugyfelid AND ugyfel.ugyfelid = maganszemely.ugyfelid AND ugyfel.ugyfelid = $id";
    $res = bank_csatlakozas()->query($sql);
    $ugyfel = [];
    foreach ($res as $current_row) {
        $ugyfel = $current_row;
        break;
    }
    return $ugyfel;
}
function ugyfelet_modosit($id,$tel, $email, $vez, $ker, $lak,$szemig,$ceg,$ado,$szek) {

    if ( !($conn = bank_csatlakozas()) ) {
        echo '<script>alert("HIBA")</script>';
        die("Hiba a csatlakozásnál");
    }
    $stmt = $conn->prepare('BEGIN;
	UPDATE ugyfel SET telefonszam=:telefonszam, email=:email WHERE ugyfelid=:ugyfelid; 
	UPDATE jogiszemely SET adoszam=:adoszam, szekhely=:szekhely, cegnev=:cegnev WHERE ugyfelid=:ugyfelid;
	UPDATE maganszemely SET szemelyiszam=:szemelyiszam, lakcim=:lakcim, vezeteknev=:vezeteknev, keresztnev=:keresztnev WHERE ugyfelid=:ugyfelid;
	COMMIT;');
    $stmt->bindParam(':ugyfelid',$id, PDO::PARAM_INT,11);
    $stmt->bindParam(':telefonszam',$tel, PDO::PARAM_INT, 8);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR, 256);
    $stmt->bindParam(':adoszam',$ado, PDO::PARAM_STR, 256);
    $stmt->bindParam(':szekhely',$szek, PDO::PARAM_STR, 256);
    $stmt->bindParam(':cegnev',$ceg, PDO::PARAM_STR, 256);
    $stmt->bindParam(':szemelyiszam',$szemig, PDO::PARAM_STR, 20);
    $stmt->bindParam(':lakcim',$lak, PDO::PARAM_STR, 20);
    $stmt->bindParam(':vezeteknev', $vez, PDO::PARAM_STR, 20);
    $stmt->bindParam(':keresztnev', $ker, PDO::PARAM_STR, 20);
    $stmt->execute();
    $stmt = null;
    $conn = null;
    return true;
}
$ugyfel = ugyfelet_leker();
?>
<div id="id03" style="display: block" class="modal">
    <form class="modal-content animate" method="POST" accept-charset="utf-8">
        <div class="container">
            <span onclick="megse()" class="close" title="Close Modal">&times;</span>
            <h1>Ügyfél adatok módosítása</h1>
            <hr>
            <label for="ugyfelid"><b>Ügyfél azonosító</b></label>
            <input type="text" name="ugyfelid" value="<?= $ugyfel["ugyfelid"] ?>" readonly/>
            <label for="email"><b>Email</b></label>
            <input type="email" name="email" value="<?= $ugyfel["email"] ?>" required/>
            <label for="phone"><b>Telefon</b></label>
            <input type="tel" pattern="[0-9]{9}" name="phone" value="<?= $ugyfel["telefonszam"] ?>" required/>
            <?php if ($ugyfel["cegnev"] != NULL) {
                echo '<label for="cegnev"><b>Cégnév</b></label><input type="text" name="cegnev" value="' . $ugyfel["cegnev"] . '"/><label for="ado"><b>Adószám</b></label><input type="text" name="ado" value="' . $ugyfel["adoszam"] . '"/><label for="szek"><b>Székhely</b></label><input type="text" name="szek" value="' . $ugyfel["szekhely"] . '"/>';
            } else {
                echo '<label for="vez"><b>Vezetéknév</b></label><input type="text" name="vez" value="' . $ugyfel["vezeteknev"] . '" required/><label for="ker"><b>Keresztnév</b></label>
                <input type="text" name="ker" value="' . $ugyfel["keresztnev"] . '" required/>
                <label for="szem"><b>Személyi igazolvány száma</b></label>
                <input type="text" name="szem" value="' . $ugyfel["szemelyiszam"] . '" required/>
                <label for="szem"><b>Lakcím</b></label>
                <input type="text" name="cim" value="' . $ugyfel["lakcim"] . '" required/>';
            } ?>
            <button type="submit" class="nagy" name="modosit">Elküld</button>
        </div>
    </form>
</div>
</body>
</html>
<script>
    function megse() {
        window.open("augyfelek.php", "_self");
    }
</script>