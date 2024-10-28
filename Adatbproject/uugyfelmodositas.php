<?php
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


if (isset($_POST["modosit"])) {
    if (!isset($_POST["felh"]) || trim($_POST["felh"]) === "" || !isset($_POST["pass"]) || trim($_POST["pass"]) === "" || !isset($_POST["phone"]) || trim($_POST["phone"]) === ""
        || !isset($_POST["email"]) || trim($_POST["email"]) === "") {

        echo '<script>alert("Hiba: Adj meg minden adatot!")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=home.php">';
        die();
    } else {
        if ($_SESSION["user"]["cegnev"] != NULL && !(!isset($_POST["cegnev"]) || trim($_POST["cegnev"]) === "" || !isset($_POST["ado"]) || trim($_POST["ado"]) === "" || !isset($_POST["szek"]) || trim($_POST["szek"]) === "")) {
            $ceg = $_POST["cegnev"];
            $ado = $_POST["ado"];
            $szek = $_POST["szek"];
            $vez = null;
            $ker = null;
            $lak = null;
            $szemig = null;
        } else if ($_SESSION["user"]["cegnev"] == NULL && isset($_POST["vez"]) && trim($_POST["vez"]) !== "" && isset($_POST["ker"]) && trim($_POST["ker"]) !== "" && isset($_POST["cim"]) && trim($_POST["cim"]) !== "" && isset($_POST["szem"]) && trim($_POST["szem"]) !== "") {
            $vez = $_POST['vez'];
            $ker = $_POST['ker'];
            $lak = $_POST['cim'];
            $szemig = $_POST["szem"];
            $ceg = null;
            $ado = null;
            $szek = null;
        } else {
            echo '<script>alert("Hiba: Adj meg minden adatot! specs")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=home.php">';
            die();
        }
        $felh = $_POST['felh'];
        $tel = $_POST['phone'];
        $email = $_POST['email'];
        $jelszo = $_POST['pass'];
        $uj1 = $_POST["pass1"];
        $uj2 = $_POST["pass2"];
        if (!(isset($_POST["pass1"]) && trim($_POST["pass1"]) !== "" && isset($_POST["pass2"]) && trim($_POST["pass2"]) !== "")) {
            if ($uj1 !== $uj2) {
                echo '<script>alert("A két új jelszó nem egyezik")</script>';
                echo '<meta http-equiv="Refresh" content="0;url=uugyintezes.php">';
                die();
            }
        }
        if (!password_verify($jelszo, $_SESSION["user"]["jelszo"])) {
            echo '<script>alert("Hibás régi jelszó")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=uugyintezes.php">';
            die();
        }
        $jelszo = $uj2;

        $sikeres = ugyfelet_modosit($felh, $tel, $email, $jelszo, $vez, $ker, $lak, $szemig, $ceg, $ado, $szek);


        if ($sikeres) {
            echo '<script>alert("Sikeres módosítás")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=logout.php">';
            die();
        } else {
            echo '<script>alert("Sikertelen módosítás!")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=home.php">';
            die();
        }
    }

}
if (isset($_POST["torles"])) {
    if (!isset($_POST["pass"]) || trim($_POST["pass"]) === "") {
        echo '<script>alert("Add meg a jelenlegi jelszavad")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=uugyintezes.php">';
        die();
    } else {
        $jelszo = $_POST["pass"];
        if (!password_verify($jelszo, $_SESSION["user"]["jelszo"])) {
            echo '<script>alert("Hibás régi jelszó")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=uugyintezes.php">';
            die();
        }
        $sikeres = ugyfelet_torol();
        if ($sikeres) {
            echo '<script>alert("Sikeres törlés")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=logout.php">';
            $conn = null;
            die();
        } else {
            echo '<script>alert("Sikertelen törlés!")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=uugyintezes.php">';
            $conn = null;
            die();
        }
    }

}
function ugyfelet_torol()
{
    $ugyfeid = $_SESSION["user"]["ugyfelid"];
    if (!($conn = bank_csatlakozas())) {
        echo '<script>alert("HIBA")</script>';
        die("Hiba a csatlakozásnál");
    }
    $stmt = $conn->prepare('BEGIN;
		DELETE FROM bankszamla WHERE bankszamla.szamlaszam IN (SELECT bankszamla.szamlaszam FROM bankszamla,tulajdona,ugyfel,penzforgalom WHERE bankszamla.szamlaszam = tulajdona.szamlaszam AND ugyfel.ugyfelid = tulajdona.ugyfelid AND ugyfel.ugyfelid = :ugyfelid AND penzforgalom.megbizoszamlaszam = bankszamla.szamlaszam GROUP BY bankszamla.szamlaszam ORDER BY bankszamla.szamlaszam);
		DELETE  FROM ugyfel WHERE ugyfelid = :ugyfelid;
		COMMIT;');
    $stmt->bindParam(':ugyfelid', $ugyfeid, PDO::PARAM_INT, 11);
    $stmt->execute();
    return true;
}

function ugyfelet_modosit($felh, $tel, $email, $jelszo, $vez, $ker, $lak, $szemig, $ceg, $ado, $szek)
{

    if (!($conn = bank_csatlakozas())) {
        echo '<script>alert("HIBA")</script>';
        die("Hiba a csatlakozásnál");
    }
    $sql2 = "SELECT felhasznalonev FROM ugyfel";
    $res2 = $conn->query($sql2);
    foreach ($res2 as $current_row) {
        if ($_SESSION["user"]["felhasznalonev"] != $felh && $current_row["felhasznalonev"] == $felh) {
            echo '<script>alert("Ez a felhasználónév már létezik)</script>';
            echo '<meta http-equiv="Refresh" content="0;url=uugyintezes.php">';
            die();
        }
    }
    $conn = null;
    $conn = bank_csatlakozas();
    if (isset($_POST["pass1"]) && trim($_POST["pass1"]) !== "" && isset($_POST["pass2"]) && trim($_POST["pass2"]) !== "") {
        $stmt = $conn->prepare('BEGIN;
        UPDATE ugyfel SET felhasznalonev=:felhasznalonev, telefonszam=:telefonszam, email=:email, jelszo=:jelszo WHERE ugyfelid=:ugyfelid; 
		UPDATE jogiszemely SET cegnev=:cegnev, adoszam=:adoszam, szekhely=:szekhely WHERE ugyfelid=:ugyfelid;
		UPDATE maganszemely SET szemelyiszam=:szemelyiszam, lakcim=:lakcim, vezeteknev=:vezeteknev, keresztnev=:keresztnev WHERE ugyfelid=:ugyfelid;
		COMMIT;');
        $jelszo = password_hash($jelszo, PASSWORD_DEFAULT);
        $stmt->bindParam(':ugyfelid', $_SESSION["user"]["ugyfelid"], PDO::PARAM_INT, 11);
        $stmt->bindParam(':felhasznalonev', $felh, PDO::PARAM_STR, 256);
        $stmt->bindParam(':telefonszam', $tel, PDO::PARAM_INT, 8);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR, 256);
        $stmt->bindParam(':jelszo', $jelszo, PDO::PARAM_STR, 256);
        $stmt->bindParam(':cegnev', $ceg, PDO::PARAM_STR, 256);
        $stmt->bindParam(':adoszam', $ado, PDO::PARAM_STR, 256);
        $stmt->bindParam(':szekhely', $szek, PDO::PARAM_STR, 256);
        $stmt->bindParam(':szemelyiszam', $szemig, PDO::PARAM_STR, 20);
        $stmt->bindParam(':lakcim', $lak, PDO::PARAM_STR, 20);
        $stmt->bindParam(':vezeteknev', $vez, PDO::PARAM_STR, 20);
        $stmt->bindParam(':keresztnev', $ker, PDO::PARAM_STR, 20);
        $stmt->execute();

    } else {
        $stmt = $conn->prepare('BEGIN;
		UPDATE ugyfel SET felhasznalonev=:felhasznalonev, telefonszam=:telefonszam, email=:email WHERE ugyfelid=:ugyfelid; 
		UPDATE jogiszemely SET cegnev=:cegnev, adoszam=:adoszam, szekhely=:szekhely WHERE ugyfelid=:ugyfelid;
		UPDATE maganszemely SET szemelyiszam=:szemelyiszam, lakcim=:lakcim, vezeteknev=:vezeteknev, keresztnev=:keresztnev WHERE ugyfelid=:ugyfelid;
		COMMIT;');
        $stmt->bindParam(':ugyfelid', $_SESSION["user"]["ugyfelid"], PDO::PARAM_INT, 11);
        $stmt->bindParam(':felhasznalonev', $felh, PDO::PARAM_STR, 256);
        $stmt->bindParam(':telefonszam', $tel, PDO::PARAM_INT, 8);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR, 256);
        $stmt->bindParam(':cegnev', $ceg, PDO::PARAM_STR, 256);
        $stmt->bindParam(':adoszam', $ado, PDO::PARAM_STR, 256);
        $stmt->bindParam(':szekhely', $szek, PDO::PARAM_STR, 256);
        $stmt->bindParam(':szemelyiszam', $szemig, PDO::PARAM_STR, 20);
        $stmt->bindParam(':lakcim', $lak, PDO::PARAM_STR, 20);
        $stmt->bindParam(':vezeteknev', $vez, PDO::PARAM_STR, 20);
        $stmt->bindParam(':keresztnev', $ker, PDO::PARAM_STR, 20);
        $stmt->execute();
    }
    $stmt = null;
    $conn = null;
    return true;
}
?>
<div id="id03" class="modal">

    <form class="modal-content animate" method="POST" accept-charset="utf-8">
        <div class="container">
            <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
            <h1>Ügyfél adatok módosítása</h1>
            <p>Módosítsd az alábbi mezőket, a régi jelszó megadása mindig kötelező, ha módosítani szeretnél!</p>
            <hr>
            <label for="felh"><b>Felhasználónév</b></label>
            <input type="text" name="felh" value="<?php echo $_SESSION["user"]["felhasznalonev"] ?>" required/>
            <label for="pass"><b>Régi jelszó</b></label>
            <input type="password" name="pass" required/>
            <label for="pass"><b>Új jelszó</b></label>
            <input type="password"  minlength="3" name="pass1"/>
            <label for="pass"><b>Új jelszó megegyszer</b></label>
            <input type="password" minlength="3" name="pass2"/>
            <label for="email"><b>Email</b></label>
            <input type="email" name="email" value="<?php echo $_SESSION["user"]["email"] ?>" required/>
            <label for="phone"><b>Telefon</b></label>
            <input type="tel" pattern="[0-9]{9}" name="phone" value="<?php echo $_SESSION["user"]["telefonszam"] ?>"
                   required/>
            <?php if ($_SESSION["user"]["cegnev"] != NULL) {
                echo '<label for="cegnev"><b>Cégnév</b></label><input type="text" name="cegnev" value=';
                echo '"' . $_SESSION["user"]["cegnev"] . '"';
                echo '/><label for="ado"><b>Adószám</b></label><input type="text" name="ado" value=';
                echo '"' . $_SESSION["user"]["adoszam"] . '"';
                echo '/><label for="szek"><b>Székhely</b></label><input type="text" name="szek" value=';
                echo '"' . $_SESSION["user"]["szekhely"] . '"';
                echo '/>';
            } else {
                echo '<label for="vez"><b>Vezetéknév</b></label><input type="text" name="vez" value=';
                echo '"' . $_SESSION["user"]["vezeteknev"] . '"';
                echo ' required/><label for="ker"><b>Keresztnév</b></label>
                <input type="text" name="ker" value=';
                echo '"' . $_SESSION["user"]["keresztnev"] . '"';
                echo ' required/>
                <label for="szem"><b>Személyi igazolvány száma</b></label>
                <input type="text" name="szem" value=';
                echo '"' . $_SESSION["user"]["szemelyiszam"] . '"';
                echo ' required/>
                <label for="szem"><b>Lakcím</b></label>
                <input type="text" name="cim" value=';
                echo '"' . $_SESSION["user"]["lakcim"] . '"';
                echo ' required/>';
            } ?>
            <button type="submit" class="nagy" name="modosit">Elküld</button>
            <button type="submit" class="torles" name="torles">Fiók törlése</button>
        </div>
    </form>
</div>