<?php
$page = "beszur";
function bank_csatlakozas()
{

    try {
        $conn = new PDO("mysql:host=localhost;dbname=AdatbProject;charset=utf8", "root", "");
    } catch (PDOException $ex) {
        echo "Csatlakozási hiba: " . $ex->getMessage();
    }

    return $conn;
}


if (isset($_POST["beszur"])) {
    if (!isset($_POST["felh"]) || trim($_POST["felh"]) === "" || !isset($_POST["pass"]) || trim($_POST["pass"]) === "" || !isset($_POST["phone"]) || trim($_POST["phone"]) === "" || !isset($_POST["email"]) || trim($_POST["email"]) === "") {

        echo '<script>alert("Hiba: Adj meg minden adatot!")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=home.php">';
        die();
    } else {
        if (isset($_POST["ceg"]) && isset($_POST["cegnev"]) && trim($_POST["cegnev"]) !== "" && isset($_POST["ado"]) && trim($_POST["ado"]) !== "" && isset($_POST["szek"]) && trim($_POST["szek"]) !== "") {
            $ceg = $_POST["cegnev"];
            $ado = $_POST["ado"];
            $szek = $_POST["szek"];
            $vez = null;
            $ker = null;
            $lak = null;
            $szemig = null;
        } else if (!isset($_POST["ceg"]) && (isset($_POST["vez"]) && trim($_POST["vez"]) !== "" && isset($_POST["ker"]) && trim($_POST["ker"]) !== "" && isset($_POST["cim"]) && trim($_POST["cim"]) !== "" && isset($_POST["szem"]) && trim($_POST["szem"]) !== "")) {
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


        $sikeres = ugyfelet_beszur($felh, $tel, $email, $jelszo, $vez, $ker, $lak, $szemig, $ceg, $ado, $szek);


        if ($sikeres) {
            echo '<script>alert("Sikeres beszúrás")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=home.php">';
        } else {
            echo '<script>alert("Sikertelen beszúrás!")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=home.php">';
        }
    }

}

function ugyfelet_beszur($felh, $tel, $email, $jelszo, $vez, $ker, $lak, $szemig, $ceg, $ado, $szek){

    if (!($conn = bank_csatlakozas())) {
        die("Hiba a csatlakozásnál");
    }
    $sql1 = "SELECT felhasznalonev FROM ugyfel WHERE felhasznalonev = '$felh'";
    $res1 = $conn->query($sql1);
    foreach ($res1 as $current_row) {
        if ($felh === $current_row["felhasznalonev"]) {
            echo '<script>alert("Ez a felhasználónév már létezik")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=home.php">';
            die();
        }

    }
    $conn = null;
    $conn = bank_csatlakozas();
    $sql2 = "SELECT ugyfelid FROM ugyfel ORDER BY ugyfelid";
    $res2 = $conn->query($sql2);
    for ($i = 1; $i < 101; $i++) {
        $idk[$i] = -1;
    }
    foreach ($res2 as $current_row) {
        for ($i = 0; $i < count($current_row) / 2; $i += 1) {
            if ($current_row[$i] != NULL) {
                $idk[(int)($current_row[$i])] = 1;

            }

        }
    }
    for ($i = 1; $i < 101; $i++) {
        if ($idk[$i] == -1) {
            $id = $i;
            break;
        }
    }
    $conn = null;
    $conn = bank_csatlakozas();
    $jelszo = password_hash($jelszo, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('BEGIN; 
    INSERT INTO ugyfel (ugyfelid, felhasznalonev, telefonszam, email, jelszo) VALUES (:ugyfelid, :felhasznalonev, :telefonszam, :email, :jelszo); 
    INSERT INTO maganszemely (ugyfelid, szemelyiszam, lakcim, vezeteknev, keresztnev) VALUES (:ugyfelid, :szemelyiszam, :lakcim, :vezeteknev, :keresztnev); 
    INSERT INTO jogiszemely (ugyfelid, cegnev, adoszam, szekhely) VALUES (:ugyfelid, :cegnev, :adoszam, :szekhely); COMMIT;');
    $stmt->bindParam(':ugyfelid', $id, PDO::PARAM_INT, 11);
    $stmt->bindParam(':felhasznalonev', $felh, PDO::PARAM_STR, 256);
    $stmt->bindParam(':telefonszam', $tel, PDO::PARAM_INT, 8);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR, 256);
    $stmt->bindParam(':jelszo', $jelszo, PDO::PARAM_STR, 256);
    $stmt->bindParam(':szemelyiszam', $szemig, PDO::PARAM_STR, 20);
    $stmt->bindParam(':lakcim', $lak, PDO::PARAM_STR, 20);
    $stmt->bindParam(':vezeteknev', $vez, PDO::PARAM_STR, 20);
    $stmt->bindParam(':keresztnev', $ker, PDO::PARAM_STR, 20);
    $stmt->bindParam(':cegnev', $ceg, PDO::PARAM_STR, 256);
    $stmt->bindParam(':adoszam', $ado, PDO::PARAM_STR, 256);
    $stmt->bindParam(':szekhely', $szek, PDO::PARAM_STR, 256);
    $stmt->execute();
    $stmt = null;
    $conn = null;
    return true;
}

?>
<div id="id02" class="modal">

    <form class="modal-content animate" method="POST" accept-charset="utf-8">
        <div class="container">
            <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
            <h1>Új ügyfél felvétele</h1>
            <p>Töltsd ki az alábbi mezőket, az összes megadása kötelező</p>
            <hr>
            <label for="felh"><b>Felhasználónév</b></label>
            <input type="text" name="felh" required/>
            <label for="pass"><b>Jelszó</b></label>
            <input type="password" name="pass" minlength="3" required/>
            <label for="email"><b>Email</b></label>
            <input type="email" name="email" required/>
            <label for="phone"><b>Telefon</b></label>
            <input type="tel" pattern="[0-9]{9}" name="phone" required/>
            <label>
                <b>Cég</b> <input type="checkbox" onchange='handleClick(this);' name="ceg" style="margin-bottom:15px">
            </label>
            <div id="elvesz">
                <label for="vez"><b>Vezetéknév</b></label>
                <input type="text" name="vez" required/>
                <label for="ker"><b>Keresztnév</b></label>
                <input type="text" name="ker" required/>
                <label for="szem"><b>Személyi igazolvány száma</b></label>
                <input type="text" name="szem" required/>
                <label for="cim"><b>Lakcím</b></label>
                <input type="text" name="cim" required/>
            </div>

            <div id="hozzad">

            </div>
            <button type="submit" class="nagy" name="beszur">Elküld</button>
        </div>
    </form>
</div>
<script>
    let egyik = '<label for="cegnev"><b>Cégnév</b></label><input type="text" name="cegnev"/><label for="ado"><b>Adószám</b></label><input type="text" name="ado"/><label for="szek"><b>Székhely</b></label><input type="text" name="szek"/>';
    let masik = document.getElementById("elvesz").innerHTML;

    function handleClick(cb) {

        if (cb.checked) {
            document.getElementById("hozzad").innerHTML = egyik;
            document.getElementById("elvesz").innerHTML = "";
        } else {
            document.getElementById("hozzad").innerHTML = "";
            document.getElementById("elvesz").innerHTML = masik;

        }
    }
</script>
