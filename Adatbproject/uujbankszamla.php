<?php
if ( !($conn = bank_csatlakozas()) ) {
    echo '<script>alert("HIBA")</script>';
    die("Hiba a csatlakozásnál");
}
$sql ="SELECT bank.nev, bankfiok.cim FROM bank,bankfiok WHERE bank.nev = bankfiok.nev ORDER BY bank.nev";
$res = $conn->query($sql);
if (isset($_POST["szamla"])) {
    $conn = null;
    $sikeres = ujbakszmala();


    if ($sikeres) {
        echo '<script>alert("Sikeres hozzáadás!")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=uszamla.php">';
    } else {
        echo '<script>alert("Sikertelen hozzáadás!")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=uugyintezes.php">';
    }
}
function ujbakszmala(){
    $egy = $_POST["egyenleg"];
    $tipus = $_POST["tipus"];
    $bank = $_POST["bankok"];
    $cim = $_POST["fiok"];
    if ( !($conn = bank_csatlakozas()) ) {
        echo '<script>alert("HIBA")</script>';
        die("Hiba a csatlakozásnál");
    }
    $sql = "SELECT szamlaszam FROM bankszamla ORDER BY szamlaszam";

    $res = $conn->query($sql);
    for ($i = 10001; $i < 100000; $i++) {
        $szamlaszamok[$i] = -1;
    }
    foreach ($res as $current_row) {
        for ($i = 0; $i < count($current_row) / 2; $i += 1) {
            if ($current_row[$i] != NULL) {
                $szamlaszamok[(int)($current_row[$i])] = 1;
            }

        }
    }
    for ($i = 10001; $i < 100000; $i++) {
        if ($szamlaszamok[$i] == -1) {
            $szamlaszam = $i;
            break;
        }
    }
    if(isset($_POST["szam"]) && trim($_POST["szam"] !== "")){
        $szam = $_POST["szam"];
        $sql1 = 'SELECT ugyfel.ugyfelid FROM ugyfel,jogiszemely,maganszemely WHERE ugyfel.ugyfelid = jogiszemely.ugyfelid AND ugyfel.ugyfelid = maganszemely.ugyfelid AND (maganszemely.szemelyiszam = "'.$szam.'" OR jogiszemely.adoszam = "'.$szam.'")';
        $res2 = bank_csatlakozas()->query($sql1);
        $adatok = [];
        foreach ($res2 as $current_row2){
            $adatok = $current_row2;
            break;
        }
        if($adatok == null){
            echo '<script>alert("Nincs ilyen másik ügyfél!")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=uugyintezes.php">';
            die();
        }
        $stmt = $conn->prepare('BEGIN;
    INSERT INTO bankszamla (szamlaszam, banknev, tipus, egyenleg) VALUES (:szamlaszam, :banknev, :tipus, :egyenleg);
    INSERT INTO tulajdona (ugyfelid, szamlaszam) VALUES (:ugyfelid, :szamlaszam);
    INSERT INTO tulajdona (ugyfelid, szamlaszam) VALUES (:ugyfelid2, :szamlaszam);
    INSERT INTO penzforgalom (tipus, helyszin, megbizoszamlaszam, osszeg) VALUES (:tipus1, :helyszin, :megbizoszamlaszam, :egyenleg);
    COMMIT;');
        $tipus1 = "Bankszámla nyitás";
        $stmt->bindParam(':szamlaszam', $szamlaszam, PDO::PARAM_INT, 11);
        $stmt->bindParam(':banknev', $bank, PDO::PARAM_STR, 256);
        $stmt->bindParam(':tipus', $tipus, PDO::PARAM_STR, 256);
        $stmt->bindParam(':egyenleg', $egy, PDO::PARAM_INT, 11);
        $stmt->bindParam(':ugyfelid', $_SESSION["user"]["ugyfelid"], PDO::PARAM_INT, 11);
        $stmt->bindParam(':ugyfelid2', $adatok["ugyfelid"], PDO::PARAM_INT, 11);
        $stmt->bindParam(':tipus1', $tipus1, PDO::PARAM_STR, 256);
        $stmt->bindParam(':helyszin', $cim, PDO::PARAM_STR, 256);
        $stmt->bindParam(':megbizoszamlaszam', $szamlaszam, PDO::PARAM_STR, 256);
        $stmt->execute();
        $_SESSION["user"]["szamlaszam"] = $szamlaszam;
        $conn = null;
        return true;
    }else{

        $stmt = $conn->prepare('BEGIN;
    INSERT INTO bankszamla (szamlaszam, banknev, tipus, egyenleg) VALUES (:szamlaszam, :banknev, :tipus, :egyenleg);
    INSERT INTO tulajdona (ugyfelid, szamlaszam) VALUES (:ugyfelid, :szamlaszam);
    INSERT INTO penzforgalom (tipus, helyszin, megbizoszamlaszam, osszeg) VALUES (:tipus1, :helyszin, :megbizoszamlaszam, :egyenleg);
    COMMIT;');
        $tipus1 = "Bankszámla nyitás";
        $stmt->bindParam(':szamlaszam', $szamlaszam, PDO::PARAM_INT, 11);
        $stmt->bindParam(':banknev', $bank, PDO::PARAM_STR, 256);
        $stmt->bindParam(':tipus', $tipus, PDO::PARAM_STR, 256);
        $stmt->bindParam(':egyenleg', $egy, PDO::PARAM_INT, 11);
        $stmt->bindParam(':ugyfelid', $_SESSION["user"]["ugyfelid"], PDO::PARAM_INT, 11);
        $stmt->bindParam(':tipus1', $tipus1, PDO::PARAM_STR, 256);
        $stmt->bindParam(':helyszin', $cim, PDO::PARAM_STR, 256);
        $stmt->bindParam(':megbizoszamlaszam', $szamlaszam, PDO::PARAM_STR, 256);
        $stmt->execute();
        $_SESSION["user"]["szamlaszam"] = $szamlaszam;
        $conn = null;
        return true;
    }
}
?>
<div id="id04" class="modal">

    <form class="modal-content animate" method="POST" accept-charset="utf-8">
        <div class="container">
            <span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>
            <h1>Új bankszámla nyitása</h1>
            <p>Töltsd ki az alábbi mezőket, az összes megadása kötelező</p>
            <hr>
            <label for="bankok"><b>Válassz bankot:</b></label>
            <select name="bankok">
                <?php

                foreach ($res as $current_row) {

                    if(!isset($bankok[$current_row["nev"]])){
                        $bankok[$current_row["nev"]] = 0;
                        echo '<option value="' . $current_row[0] . '">' . $current_row[0] . '</option>';
                    }

                }
                ?>
            </select>
            <label for="fiok"><b>Bankfiók</b></label>
            <select name="fiok">
                <?php
                $res1 = $conn->query($sql);
                $current_row = 0;
                foreach ($res1 as $current_row1) {
                    echo '<option value="'.$current_row1[1] .'">'.$current_row1[0]."-".$current_row1[1].'</option>';
                }
                ?>
            </select>
            <label for="tipus"><b>Számla típusa:</b></label>
            <select name="tipus">
                <option value="Folyószámla">
                    Folyószámla
                </option>
                <option value="Megtakarítási számla">
                    Megtakarítási számla
                </option>
                <option value="Hitelszámla">
                    Hitelszámla
                </option>
            </select>
            <label for="egyenleg"><b>Kezdő egyenleg:</b></label>
            <input type="number" name="egyenleg" min="0" max="10000000" required>
            <label>
                <b>Másik ügyfél hozzáadása</b> <input id="osszeset" type="checkbox" onchange='handleClick(this);' name="osszes" style="margin-bottom:15px">
            </label>
            <div id="ugyfel">

            </div>
            <button type="submit" class="nagy" name="szamla">Elküld</button>
        </div>
    </form>
</div>
<script>
    let ugyfel = '<label for="szam"><b>Személyiszám/adószám</b></label> <input type="text" name="szam"/>';
    function handleClick(cb) {
        if(cb.checked){
            document.getElementById('ugyfel').innerHTML = ugyfel;
        }else {
            document.getElementById('ugyfel').innerHTML = "";
        }
    }

</script>

