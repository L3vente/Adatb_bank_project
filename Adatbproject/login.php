<?php
if (isset($_POST["login"])) {
    if (!isset($_POST["felh"]) || trim($_POST["felh"]) === "" || !isset($_POST["pass"]) || trim($_POST["pass"]) === ""){
        echo '<script>alert("Hiba: Adj meg minden adatot!")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=home.php">';
        die();
    }else {
        $felh = $_POST['felh'];
        $jelszo = $_POST['pass'];
        $sql = "SELECT ugyfel.ugyfelid, felhasznalonev, telefonszam, email, jelszo, szemelyiszam, lakcim, vezeteknev, keresztnev, cegnev, adoszam, szekhely FROM ugyfel,maganszemely,jogiszemely where ugyfel.ugyfelid = maganszemely.ugyfelid AND ugyfel.ugyfelid = jogiszemely.ugyfelid";
        $conn = bank_csatlakozas();
        $res = $conn->query($sql);
        foreach ($res as $current_row) {
            if ($felh == $current_row["felhasznalonev"]) {
                    if(password_verify($jelszo,$current_row["jelszo"])){
                        $_SESSION["user"]=$current_row;
                        $conn=null;
                        echo '<script>alert("Sikeres bejelentkezés")</script>';
                        if($_SESSION["user"]["felhasznalonev"] === "admin"){
                            echo '<meta http-equiv="Refresh" content="0;url=admin.php">';
                        }else{

                            echo '<meta http-equiv="Refresh" content="0;url=uszamla.php">';
                        }
                        die();
                    }else{
                        echo '<script>alert("Hibás jelszó")</script>';
                        echo '<meta http-equiv="Refresh" content="0;url=home.php">';
                        die();
                    }
                 }
            }
        echo '<script>alert("Nincs ilyen ügyfél")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=home.php">';
        }
    }
?>
<div id="id01" class="modal">
    <form class="modal-content animate" method="POST" accept-charset="utf-8">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
        <h1>Bejelentkezés</h1>
        <hr>
        <div class="container">
            <label for="felh"><b>Felhasználónév</b></label>
            <input type="text" name="felh" required />
            <br>
            <label for="pass"><b>Jelszó</b></label>
            <input type="password" name="pass" required />
            <br>
            <button type="submit" class="nagy" name="login">Elküld</button>
        </div>
    </form>
</div>


