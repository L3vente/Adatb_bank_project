<?php
if ( !($conn = bank_csatlakozas()) ) {
    echo '<script>alert("HIBA")</script>';
    die("Hiba a csatlakozásnál");
}
$ugyfelid = $_SESSION["user"]["ugyfelid"];

if(isset($_POST["utalas"]) && isset($_POST["szamlaszam"])) {
    $conn = null;
    $conn = bank_csatlakozas();
    $ugyfelszamla = $_POST["szamlaszam"];
    $celszamla = $_POST["celszamlaszam"];
    $sql10 = "SELECT bankszamla.szamlaszam,egyenleg, jogiszemely.cegnev, maganszemely.vezeteknev, maganszemely.keresztnev FROM bankszamla,tulajdona,ugyfel,jogiszemely,maganszemely WHERE bankszamla.szamlaszam = tulajdona.szamlaszam AND ugyfel.ugyfelid = tulajdona.ugyfelid AND jogiszemely.ugyfelid = ugyfel.ugyfelid AND maganszemely.ugyfelid = jogiszemely.ugyfelid AND(bankszamla.szamlaszam = ".$celszamla." OR bankszamla.szamlaszam = ".$ugyfelszamla.")";
    $res10 = $conn->query($sql10);
    foreach ($res10 as $current_row1) {
          $regiosszeg[$current_row1["szamlaszam"]] = $current_row1;
    }

    $conn = null;
    $conn = bank_csatlakozas();
    if ($regiosszeg[$ugyfelszamla]["egyenleg"] < $_POST["osszeg"]) {
        echo '<script>alert("Nincs elég fedezet!")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=uugyintezes.php">';
        die();
    }
    $stmt = $conn->prepare('BEGIN;
    UPDATE bankszamla SET egyenleg=:egyenleg WHERE szamlaszam = :szamlaszam;
    UPDATE bankszamla SET egyenleg=:egyenleg1 WHERE szamlaszam = :szamlaszam1;
    INSERT INTO penzforgalom (tipus, megbizottnev, megbizottszamlaszam, kozlemeny, helyszin, megbizoszamlaszam, osszeg) VALUES ("Átutalás",:nev, :szamlaszam1, :kozlemeny, :helyszin, :szamlaszam, :osszeg);
    INSERT INTO penzforgalom (tipus, megbizottnev, megbizottszamlaszam, kozlemeny, helyszin, megbizoszamlaszam, osszeg) VALUES ("Átutalás",:nev1, :szamlaszam, :kozlemeny, :helyszin, :szamlaszam1, :osszeg1);
    COMMIT;');
    $regiosszeg[$ugyfelszamla]["egyenleg"] -= $_POST["osszeg"];
    $regiosszeg[$celszamla]["egyenleg"] += $_POST["osszeg"];
    $nev = $regiosszeg[$celszamla]["vezeteknev"]." ".$regiosszeg[$celszamla]["keresztnev"];
    $cegnev = $regiosszeg[$celszamla]["cegnev"];
    $nev1 = $regiosszeg[$ugyfelszamla]["vezeteknev"]." ".$regiosszeg[$ugyfelszamla]["keresztnev"];
    $cegnev1 = $regiosszeg[$ugyfelszamla]["cegnev"];
    if(isset($_POST["kozlemeny"]) && trim($_POST["kozlemeny"]) !== ""){
        $kozlemeny = $_POST["kozlemeny"];

    }else{
        $kozlemeny = null;
    }
    if($_POST["cim"] == "Online"){
        $helyzin = null;
    }else{
        $helyzin = $_POST["cim"];
    }
    $osszeg1 = $_POST["osszeg"];
    $osszeg = -$_POST["osszeg"];
    $stmt->bindParam(':egyenleg', $regiosszeg[$ugyfelszamla]["egyenleg"], PDO::PARAM_INT, 11);
    $stmt->bindParam(':szamlaszam', $ugyfelszamla, PDO::PARAM_INT, 11);
    $stmt->bindParam(':egyenleg1', $regiosszeg[$celszamla]["egyenleg"], PDO::PARAM_INT, 11);
    $stmt->bindParam(':szamlaszam1', $celszamla, PDO::PARAM_INT, 11);
    if($regiosszeg[$celszamla]["cegnev"] == null){
        $stmt->bindParam(':nev', $nev, PDO::PARAM_STR, 11);

    }else{
        $stmt->bindParam(':nev', $cegnev, PDO::PARAM_STR, 11);
    }
    if($regiosszeg[$ugyfelszamla]["cegnev"] == null){
        $stmt->bindParam(':nev1', $nev1, PDO::PARAM_STR, 11);

    }else{
        $stmt->bindParam(':nev1', $cegnev1, PDO::PARAM_STR, 11);
    }
    $stmt->bindParam(':kozlemeny', $kozlemeny, PDO::PARAM_STR, 11);
    $stmt->bindParam(':helyszin', $helyzin, PDO::PARAM_STR, 11);
    $stmt->bindParam(':osszeg', $osszeg, PDO::PARAM_INT, 11);
    $stmt->bindParam(':osszeg1', $osszeg1, PDO::PARAM_INT, 11);
    $stmt->execute();
    $conn = null;
    echo '<script>alert("Sikeres átutalás!")</script>';
    echo '<meta http-equiv="Refresh" content="0;url=uszamla.php">';
    die();
    }
?>
<div id="id07" class="modal">
    <form class="modal-content animate" method="POST" accept-charset="utf-8">
        <div class="container">
            <span onclick="document.getElementById('id07').style.display='none'" class="close" title="Close Modal">&times;</span>
            <h1>Válaszd ki melyik bankszámládról, mennyit, és hova szeretnél utalni!</h1>
            <hr>
            <label for="szamlaszam"><b>Válassz számlát:</b></label>
            <select name="szamlaszam">
                <?php
                $sql3 ="SELECT bankszamla.szamlaszam, egyenleg, banknev, tipus FROM bankszamla,tulajdona,ugyfel WHERE bankszamla.szamlaszam = tulajdona.szamlaszam AND ugyfel.ugyfelid = tulajdona.ugyfelid AND ugyfel.ugyfelid = $ugyfelid ORDER BY bankszamla.szamlaszam";
                $res3 = $conn->query($sql3);
                foreach ($res3 as $current_row) {
                    echo '<option value="' . $current_row["szamlaszam"]. '">' . $current_row["szamlaszam"]. '-' .$current_row["banknev"]. '-'. $current_row["tipus"].'-' .$current_row["egyenleg"] .' Ft'. '</option>';
                }
                ?>
            </select>
            <label for="celszamlaszam"><b>Válaszd ki a célszámlát:</b></label>
            <select name="celszamlaszam">
                <?php
                $sql5 = "SELECT bankszamla.szamlaszam, bankszamla.banknev, jogiszemely.cegnev, maganszemely.vezeteknev, maganszemely.keresztnev FROM bankszamla,tulajdona,ugyfel,maganszemely,jogiszemely WHERE jogiszemely.ugyfelid = ugyfel.ugyfelid AND maganszemely.ugyfelid = ugyfel.ugyfelid AND bankszamla.szamlaszam = tulajdona.szamlaszam AND ugyfel.ugyfelid = tulajdona.ugyfelid GROUP BY szamlaszam ORDER BY szamlaszam";
                $res5 = $conn->query($sql5);
                foreach ($res5 as $current_row) {
                    if($current_row["cegnev"] == null){
                        echo '<option value="' . $current_row["szamlaszam"]. '">' . $current_row["szamlaszam"]. '-' .$current_row["banknev"]."-".$current_row["vezeteknev"]." ".$current_row["keresztnev"].'</option>';
                    }else{
                        echo '<option value="' . $current_row["szamlaszam"]. '">' . $current_row["szamlaszam"]. '-' .$current_row["banknev"]."-".$current_row["cegnev"].'</option>';
                    }

                }
                ?>
            </select>
            <label for="osszeg"><b>Összeg</b></label>
            <input type="number" name="osszeg" min="100" required>
            <label for="cim"><b>Helyszín</b></label>
            <select name="cim">
                <?php
                $sql4 ="SELECT nev, cim FROM bankfiok ORDER BY nev";
                $res4 = $conn->query($sql4);
                foreach ($res4 as $current_row) {
                    echo '<option value="' . $current_row["cim"]. '">' . $current_row["nev"]. '-' .$current_row["cim"].'</option>';
                }
                ?>
                <option value="Online">Online</option>
            </select>
            <label for="kozlemeny"><b>Közlemény</b></label>
            <input type="text" name="kozlemeny">
            <button type="submit" class="nagy" name="utalas">Utalás</button>
        </div>
    </form>
</div>
