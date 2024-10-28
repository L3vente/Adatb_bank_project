<?php
session_start();
$page="home";
?>
<!DOCTYPE html>
<html lang="hu">
<head>

    <link rel="stylesheet" href="css/formStyle.css">
    <link rel="stylesheet" href="css/navStyle.css">
    <title>Főoldal</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF8" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/ikon.jpg">
</head>
<body>
<?php
include "menu.php";
include "ugyfelbeszuras.php";
include "login.php";
?>
<div id="home">
    <br>
    <br>
    <br>
    <br>
    <br>
    <h1 style="color:white; background-color: black">Üdvözöllek a Home-Bankban!</h1>
</div>
</body>
</html>

