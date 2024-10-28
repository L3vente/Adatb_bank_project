<?php
session_start();
$page = "admin";
if (!isset($_SESSION["user"]) || $_SESSION["user"]["felhasznalonev"] != "admin") {
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <link rel="stylesheet" href="css/formStyle.css">
    <link rel="stylesheet" href="css/navStyle.css">
    <link rel="stylesheet" href="css/ugyStyle.css">

    <title>Admin</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF8" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/ikon.jpg">

</head>
<body>
<?php
include "menu.php";
include "augyfeletlekerForm.php";
include "abankszamlatlekerForm.php";
include "adminbankfiokForm.php";
include "abankdel.php";
?>
<main>
    <table class="table">
        <tbody>
        <tr>
            <th colspan="4" style="border-right: #332d2d; border-right-style: solid">
                Lekérdezések
            </th>
            <th colspan="2">
                Egyéb módosítások
            </th>
        </tr>
        <tr>
            <td><button onclick="document.getElementById('id08').style.display='block'" class="nagy"">Ügyfelek</button></td>
            <td><button onclick="document.getElementById('id09').style.display='block'" class="nagy">Bankszámlák</button></form></td>
            <td><form action="abankok.php" method="POST"><button class="nagy" name="banklista">Bankok és bankfiókok</button></form></td>
            <td style="border-right: #332d2d; border-right-style: solid"><form action="apenzforg.php" method="POST"><button class="nagy">Pénzforgalmak</button></form></td>
            <td><button type="submit" class="nagy" onclick="document.getElementById('id10').style.display='block';" >Bank/Bankfiók hozzáadása</button></td>
            <td><button type="submit" class="nagy" onclick="document.getElementById('id13').style.display='block';" >Bank/Bankfiók törlése</button></td>
        </tr>
        </tbody>
    </table>
</main>
<?php
include "footer.php";
?>
</body>
</html>