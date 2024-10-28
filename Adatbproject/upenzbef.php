<?php
if ( !($conn = bank_csatlakozas()) ) {
    echo '<script>alert("HIBA")</script>';
    die("Hiba a csatlakozásnál");
}
$ugyfelid = $_SESSION["user"]["ugyfelid"];
$sql3 ="SELECT bankszamla.szamlaszam, egyenleg, banknev, tipus FROM bankszamla,tulajdona,ugyfel WHERE bankszamla.szamlaszam = tulajdona.szamlaszam AND ugyfel.ugyfelid = tulajdona.ugyfelid AND ugyfel.ugyfelid = $ugyfelid ORDER BY bankszamla.szamlaszam";
$res3 = $conn->query($sql3);
if(isset($_POST["pluszpez"])){
    $ugyfelszamla = $_POST["szamlaszam"];
    $sql3 ="SELECT egyenleg FROM bankszamla,tulajdona,ugyfel WHERE bankszamla.szamlaszam = tulajdona.szamlaszam AND ugyfel.ugyfelid = tulajdona.ugyfelid AND bankszamla.szamlaszam = $ugyfelszamla";
    $res3 = $conn->query($sql3);
    foreach ($res3 as $current_row){
        $regiosszeg =$current_row["egyenleg"];
        break;
    }
    $conn = null;
    $conn = bank_csatlakozas();
    $ujssozeg = $regiosszeg+$_POST["osszeg"];
    $stmt = $conn->prepare('BEGIN;
    UPDATE bankszamla SET egyenleg=:egyenleg WHERE szamlaszam = :szamlaszam;
    INSERT INTO penzforgalom (tipus, megbizottnev, megbizottszamlaszam, kozlemeny, helyszin, megbizoszamlaszam, osszeg) VALUES ("Pénzbefizetés",NULL, NULL, NULL, :helyszin, :szamlaszam, :osszeg);
    COMMIT;');
    $stmt->bindParam(':egyenleg',$ujssozeg, PDO::PARAM_INT, 11);
    $stmt->bindParam(':szamlaszam', $ugyfelszamla, PDO::PARAM_INT, 11);
    $stmt->bindParam(':helyszin', $_POST["cim"], PDO::PARAM_STR, 11);
    $stmt->bindParam(':osszeg', $_POST["osszeg"], PDO::PARAM_INT, 11);
    $stmt->execute();
    $conn = null;
    echo '<script>alert("Sikeres befizetés!")</script>';
    echo '<meta http-equiv="Refresh" content="0;url=uugyintezes.php">';
    die();
}elseif (isset($_POST["minuszpez"])){
    $ugyfelszamla = $_POST["szamlaszam"];
    $sql3 ="SELECT egyenleg FROM bankszamla,tulajdona,ugyfel WHERE bankszamla.szamlaszam = tulajdona.szamlaszam AND ugyfel.ugyfelid = tulajdona.ugyfelid AND bankszamla.szamlaszam = $ugyfelszamla";
    $res3 = $conn->query($sql3);
    foreach ($res3 as $current_row){
        $regiosszeg =$current_row["egyenleg"];
        break;
    }
    if($regiosszeg<$_POST["osszeg"]){
        echo '<script>alert("Nincs elég fedezet!")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=uugyintezes.php">';
        die();
    }
    $conn = null;
    $conn = bank_csatlakozas();
    $ujssozeg = $regiosszeg-$_POST["osszeg"];
    $stmt = $conn->prepare('BEGIN;
    UPDATE bankszamla SET egyenleg=:egyenleg WHERE szamlaszam = :szamlaszam;
    INSERT INTO penzforgalom (tipus, megbizottnev, megbizottszamlaszam, kozlemeny, helyszin, megbizoszamlaszam, osszeg) VALUES ("Pénzfelvét",NULL, NULL, NULL, :helyszin, :szamlaszam, :osszeg);
    COMMIT;');
    $minusz = -$_POST["osszeg"];
    $stmt->bindParam(':egyenleg',$ujssozeg, PDO::PARAM_INT, 11);
    $stmt->bindParam(':szamlaszam', $ugyfelszamla, PDO::PARAM_INT, 11);
    $stmt->bindParam(':helyszin', $_POST["cim"], PDO::PARAM_STR, 11);
    $stmt->bindParam(':osszeg',$minusz, PDO::PARAM_INT, 11);
    $stmt->execute();
    $conn = null;
    echo '<script>alert("Sikeres pénzfelvét!")</script>';
    echo '<meta http-equiv="Refresh" content="0;url=uugyintezes.php">';
    die();
}
?>
<div id="id05" class="modal">
    <form class="modal-content animate" method="POST" accept-charset="utf-8">
        <div class="container">
            <span onclick="document.getElementById('id05').style.display='none'" class="close" title="Close Modal">&times;</span>
            <h1>Válaszd ki melyik bankszámládra mennyit szeretnél befizetni!</h1>
            <hr>
            <label for="szamlaszam"><b>Válassz számlát:</b></label>
            <select name="szamlaszam">
                <?php

                foreach ($res3 as $current_row) {
                        echo '<option value="' . $current_row["szamlaszam"]. '">' . $current_row["szamlaszam"]. '-' .$current_row["banknev"]. '-'. $current_row["tipus"].'-' .$current_row["egyenleg"] .' Ft'. '</option>';
                    }
                ?>
            </select>
                <label for="osszeg"><b>Összeg</b></label>
                <input type="number" name="osszeg" min="100" max="100000000" required>
                <label for="cim"><b>Helyszín</b></label>
            <select name="cim">
                <?php
                $sql4 ="SELECT nev, cim FROM bankfiok ORDER BY nev";
                $res4 = $conn->query($sql4);
                foreach ($res4 as $current_row) {
                    echo '<option value="' . $current_row["cim"]. '">' . $current_row["nev"]. '-' .$current_row["cim"].'</option>';
                }
                ?>
            </select>
            <button type="submit" class="nagy" name="pluszpez">Pénzbefizetés</button>
            <button type="submit" class="nagy" style="margin-top: 25px" name="minuszpez">Pénzfelvét</button>
        </div>
    </form>
</div>
