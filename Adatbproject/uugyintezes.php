<?php
$page = "ugyintezes";
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>

    <link rel="stylesheet" href="css/formStyle.css">
    <link rel="stylesheet" href="css/navStyle.css">
    <link rel="stylesheet" href="css/ugyStyle.css">
    <title>Ügyintézés</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF8" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/ikon.jpg">
</head>
<body>
<?php
include "menu.php";
include "uugyfelmodositas.php";
include "uujbankszamla.php";
include "upenzbef.php";
include "uutalas.php"
?>
<main>
    <table class="table">
        <tbody>
            <tr>
                <th colspan="5">
                    Válaszható ügyletek
                </th>
            </tr>
            <tr>
                <td><button class="nagy" onclick="document.getElementById('id07').style.display='block'">Utalás</button></td>
                <td> <button class="nagy" onclick="document.getElementById('id03').style.display='block'">Felhasználó adatok megváltoztatása</button></td>
                <td><button class="nagy" onclick="document.getElementById('id05').style.display='block'">Ki-és befizetés</button></td>
                <td><button class="nagy" onclick="document.getElementById('id04').style.display='block'">Bankszámla nyitás</button></td>
<!--                <td><button class="nagy" onclick="document.getElementById('id06').style.display='block'">Bankszámla törlés</button></td>-->
            </tr>
        </tbody>
    </table>
</main>
</body>
</html>