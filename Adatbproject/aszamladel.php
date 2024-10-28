<?php
function bank_csatlakozas(){

    try {
        $conn = new PDO("mysql:host=localhost;dbname=AdatbProject;charset=utf8", "root", "");
    } catch (PDOException $ex) {
        echo "Csatlakozási hiba: " . $ex->getMessage();
        die();
    }

    return $conn;
}
$sql5 ="SELECT bankszamla.szamlaszam, banknev, tipus, maganszemely.vezeteknev, maganszemely.keresztnev, jogiszemely.cegnev FROM bankszamla,tulajdona,ugyfel,maganszemely,jogiszemely WHERE ugyfel.ugyfelid = maganszemely.ugyfelid AND jogiszemely.ugyfelid = ugyfel.ugyfelid AND bankszamla.szamlaszam = tulajdona.szamlaszam AND ugyfel.ugyfelid = tulajdona.ugyfelid ORDER BY bankszamla.szamlaszam";
$res5 = bank_csatlakozas()->query($sql5);
if(isset($_POST["torol"])){
    $szamlaszam = $_POST["szamlak"];
    $sikeres = szamlat_torol($szamlaszam);
    if ($sikeres) {
        echo '<script>alert("Sikeres törlés!")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=abankszamlak.php">';
        die();
    } else {
        echo '<script>alert("Sikertelen törlés!")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=abankszamlak.php">';
        die();
    }
}
function szamlat_torol($szamlaszam){
    $stmt = bank_csatlakozas()->prepare('DELETE FROM bankszamla WHERE bankszamla.szamlaszam = :szamlaszam');
    $stmt->bindParam(':szamlaszam', $szamlaszam, PDO::PARAM_INT, 11);
    $stmt->execute();
    return true;
}
?>
<!--<div id="id12" class="modal">-->
<!---->
<!--    <form class="modal-content animate" method="POST" accept-charset="utf-8">-->
<!--        <div class="container">-->
<!--            <span onclick="document.getElementById('id12').style.display='none'" class="close" title="Close Modal">&times;</span>-->
<!--            <h1>Bankszámla törlése</h1>-->
<!--            <hr>-->
<!--            <label for="szamlak"><b>Válaszd ki a számlát:</b></label>-->
<!--            <select name="szamlak">-->
<!--                --><?php
//
//                foreach ($res5 as $current_row) {
//                    if($current_row["vezeteknev"] == NULL){
//                        echo '<option value="' . $current_row["szamlaszam"]. '">' . $current_row["szamlaszam"]. '-' .$current_row["banknev"]. '-'. $current_row["tipus"].'-' .$current_row["cegnev"].'</option>';
//                    }else{
//                        echo '<option value="' . $current_row["szamlaszam"]. '">' . $current_row["szamlaszam"]. '-' .$current_row["banknev"]. '-'. $current_row["tipus"].'-' .$current_row["vezeteknev"] ." ".$current_row["keresztnev"]. '</option>';
//                    }
//
//                }
//                ?>
<!--            </select>-->
<!--            <button type="submit" class="torles" name="torol">Törlés</button>-->
<!--        </div>-->
<!--    </form>-->
<!--</div>-->

