<?php
$page = "szamla";
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: home.php");
}
function bank_csatlakozas() {

    try {
        $conn = new PDO("mysql:host=localhost;dbname=AdatbProject;charset=utf8", "root", "");
    } catch (PDOException $ex) {
        echo "Csatlakozási hiba: " . $ex->getMessage();
    }

    return $conn;
}
$ugyfeid = $_SESSION["user"]["ugyfelid"];
$sql = "SELECT bankszamla.szamlaszam,bankszamla.banknev,bankszamla.tipus as szamla,bankszamla.egyenleg, penzforgalom.tipus as penz,penzforgalom.osszeg,penzforgalom.datum, penzforgalom.kozlemeny, penzforgalom.megbizottnev, penzforgalom.megbizottszamlaszam FROM bankszamla,tulajdona,ugyfel,penzforgalom WHERE bankszamla.szamlaszam = tulajdona.szamlaszam AND ugyfel.ugyfelid = tulajdona.ugyfelid AND ugyfel.ugyfelid = $ugyfeid AND penzforgalom.megbizoszamlaszam = bankszamla.szamlaszam ORDER BY szamlaszam,datum";
$res = bank_csatlakozas()->query($sql);
$sql1 = "SELECT COUNT(*) as db FROM bankszamla,tulajdona,ugyfel,penzforgalom WHERE bankszamla.szamlaszam = tulajdona.szamlaszam AND ugyfel.ugyfelid = tulajdona.ugyfelid AND ugyfel.ugyfelid = $ugyfeid AND penzforgalom.megbizoszamlaszam = bankszamla.szamlaszam GROUP BY bankszamla.szamlaszam ORDER BY bankszamla.szamlaszam";
$res1 = bank_csatlakozas()->query($sql1);
?>
<!DOCTYPE html>
<html lang="hu">
<head>

    <link rel="stylesheet" href="css/formStyle.css">
    <link rel="stylesheet" href="css/navStyle.css">
    <link rel="stylesheet" href="css/ugyStyle.css">
    <title>Számlák</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF8" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/ikon.jpg">
</head>
<body>
<?php
include "menu.php";
?>
<main>
    <table class="table">
        <tbody>
        <tr>
            <th colspan="4" style="border-right: #332d2d; border-right-style: solid">
                Számla adatok:
            </th>
            <th colspan="6">
                Számlatörténet:
            </th>

        </tr>
        <tr>
            <th>Számlaszám:</th>
            <th>Bank:</th>
            <th>Számla típusa:</th>
            <th>Számla egyenlege:</th>
            <th>Tranzakció dátuma:</th>
            <th>Tranzakció összege:</th>
            <th>Tranzakció típusa:</th>
            <th>Megbízó név, számlaszám</th>
            <th>Megbízott név, számlaszám</th>
            <th>Közlemény:</th>
        </tr>
        <?php
        $szamok = [];
        $i = 0;
         foreach ($res1 as $current_row2){
            $szamok[$i++] = $current_row2["db"];
        }
         $i = 0;
            foreach ($res as $current_row){


                echo '<tr>';
                if(!isset($bankok[$current_row["szamlaszam"]])){
                    $bankok[$current_row["szamlaszam"]] = 0;
                    echo '<td rowspan="'.$szamok[$i].'">'.$current_row["szamlaszam"].'</td>';
                    echo '<td rowspan="'.$szamok[$i].'">'.$current_row["banknev"].'</td>';
                    echo '<td rowspan="'.$szamok[$i].'">'.$current_row["szamla"].'</td>';
                    echo '<td rowspan="'.$szamok[$i].'">'.$current_row["egyenleg"]." Ft".'</td>';
                    echo '<td>'.$current_row["datum"].'</td>';
                    echo '<td>'.$current_row["osszeg"]." Ft".'</td>';
                    echo '<td>'.$current_row["penz"].'</td>';
                    if($current_row["penz"] != "Átutalás"){
                        echo '<td>-</td>';
                        echo '<td>-</td>';
                        echo '<td>-</td>';

                    }else{
                        if($current_row["megbizottnev"] == NULL){
                            echo '<td>-</td>';
                        }else{
                            if($current_row["osszeg"] < 0){
                                echo '<td>-</td>';
                                echo '<td>'.$current_row["megbizottnev"].", ".$current_row["megbizottszamlaszam"].'</td>';
                            }else{
                                echo '<td>'.$current_row["megbizottnev"].", ".$current_row["megbizottszamlaszam"].'</td>';
                                echo '<td>-</td>';
                            }

                        }
                        if($current_row["kozlemeny"] == NULL){
                            echo '<td>-</td>';
                        }else{
                            echo '<td>'.$current_row["kozlemeny"].'</td>';
                        }
                    }
                    $i++;
                }else{
                    echo '<td>'.$current_row["datum"].'</td>';
                    echo '<td>'.$current_row["osszeg"]." Ft".'</td>';
                    echo '<td>'.$current_row["penz"].'</td>';
                    if($current_row["penz"] != "Átutalás"){
                        echo '<td>-</td>';
                        echo '<td>-</td>';
                        echo '<td>-</td>';

                    }else{
                        if($current_row["megbizottnev"] == NULL){
                            echo '<td>-</td>';
                        }else{
                            if($current_row["osszeg"] < 0){
                                echo '<td>-</td>';
                                echo '<td>'.$current_row["megbizottnev"].", ".$current_row["megbizottszamlaszam"].'</td>';
                            }else{
                                echo '<td>'.$current_row["megbizottnev"].", ".$current_row["megbizottszamlaszam"].'</td>';
                                echo '<td>-</td>';
                            }

                        }
                        if($current_row["kozlemeny"] == NULL){
                            echo '<td>-</td>';
                        }else{
                            echo '<td>'.$current_row["kozlemeny"].'</td>';
                        }
                    }
                }
            echo '</tr>';

            }
        ?>
        </tbody>
    </table>
</main>

</body>
</html>
