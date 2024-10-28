<?php
function bank_csatlakozas(){
    try {
        $conn = new PDO("mysql:host=localhost;dbname=AdatbProject;charset=utf8", "root", "");
    } catch (PDOException $ex) {
        echo '<script>alert("Sikertelen csat!")</script>';
        echo "Csatlakozási hiba: " . $ex->getMessage();
        die();
    }

    return $conn;
}

if ( !($conn = bank_csatlakozas()) ) {
    echo '<script>alert("HIBA")</script>';
    die("Hiba a csatlakozásnál");
}
$sql7 = "SELECT * FROM bank";
$res7 = $conn->query($sql7);

if(isset($_POST["ujbankok"])){
    if(isset($_POST["ujbank"]) && isset($_POST["ujbankf"])) {
        $banknev = $_POST["bnev"];
        $bankszek = $_POST["bszek"];
        $bankfcim = $_POST["cim"];
        foreach ($res7 as $current_row2) {
            if ($current_row2["nev"] == $banknev) {
                echo '<script>alert("Ez a bank már létezik")</script>';
                echo '<meta http-equiv="Refresh" content="0;url=admin.php">';
                die();
            }
        }
        $stmt = $conn->prepare('BEGIN;
         INSERT INTO bank (nev, szekhely) VALUES (:nev, :szekhely);
         INSERT INTO bankfiok (nev, cim) VALUES (:nev, :cim);
         COMMIT;');
        $stmt->bindParam(':nev', $banknev, PDO::PARAM_STR, 256);
        $stmt->bindParam(':szekhely', $bankszek, PDO::PARAM_STR, 256);
        $stmt->bindParam(':cim', $bankfcim, PDO::PARAM_STR, 256);
        $stmt->execute();
        $conn = null;
        echo '<script>alert("Sikeres hozzáadás!")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=admin.php">';
    }else if(isset($_POST["ujbank"])){
        $banknev = $_POST["bnev"];
        $bankszek = $_POST["bszek"];
        foreach ($res7 as $current_row2) {
            if ($current_row2["nev"] == $banknev) {
                echo '<script>alert("Ez a bank már létezik")</script>';
                echo '<meta http-equiv="Refresh" content="0;url=admin.php">';
                die();
            }
        }
        $stmt = $conn->prepare('BEGIN;
         INSERT INTO bank (nev, szekhely) VALUES (:nev, :szekhely);
         COMMIT;');
        $stmt->bindParam(':nev', $banknev, PDO::PARAM_STR, 256);
        $stmt->bindParam(':szekhely', $bankszek, PDO::PARAM_STR, 256);
        $stmt->execute();
        $conn = null;
        echo '<script>alert("Sikeres hozzáadás!")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=admin.php">';
    }else if(isset($_POST["ujbankf"])){
        $bankfcim = $_POST["cim"];
        $bank = $_POST["bankn"];
        $stmt = $conn->prepare('BEGIN;
         INSERT INTO bankfiok (nev, cim) VALUES (:nev, :cim);
         COMMIT;');
        $stmt->bindParam(':nev', $bank, PDO::PARAM_STR, 256);
        $stmt->bindParam(':cim', $bankfcim, PDO::PARAM_STR, 256);
        $stmt->execute();
        $conn = null;
        echo '<script>alert("Sikeres hozzáadás!")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=admin.php">';
    }
}


?>
<div id="id10" class="modal">

    <form class="modal-content animate" name="lekeres3" onsubmit="return validateForm3()" method="POST" accept-charset="utf-8">
        <div class="container">
            <span onclick="document.getElementById('id10').style.display='none';" class="close" title="Close Modal">&times;</span>
            <h1>Új bank/bankfiók hozzáadása</h1>
                        <p>Új bank esetén egy bankfiók hozzáadás kötelező! </p>
            <hr>
            <label>
                <b>Új bank</b> <input id="ujbank" type="checkbox" onchange='handleClick3(this);' checked name="ujbank" style="margin-bottom:15px">
            </label>
            <div id="hoz4">
                <label for="bnev"><b>Banknév</b> <input id="nev" type="text" name="bnev" required style="margin-bottom:15px"></label<label for="bszek"><b>Székhely</b></label><input type="text" required name="bszek"/>
            </div>
            <label>
                <b>Új banfiók</b> <input id="ujbankf" type="checkbox" onchange='handleClick4(this);' name="ujbankf" style="margin-bottom:15px">
            </label>
            <div id="hoz5">

            </div>
            <div id="hoz6">

            </div>
            <button type="submit" class="nagy" name="ujbankok">Elküld</button>
        </div>
    </form>
</div>
<script>
    let ujbank = '<label for="bnev"><b>Banknév</b> <input id="nev" type="text" required name="bnev" style="margin-bottom:15px"></label<label for="bszek"><b>Székhely</b></label><input type="text" name="bszek" required/>';
    let ujbankf = '<label for="cim"><b>Bankfiók címe</b></label><input type="text" name="cim" required/>';
    let aktbankok = '<select name="bankn"><?php foreach ($res7 as $current_row) {
        echo '<option value="' . $current_row["nev"]. '">' . $current_row["nev"].'</option>';}?></select>';
    // let adott = '<label for="szamlaszam"><b>Bankfiókcím</b></label> <input type="text" name="szamlaszam"/>';
    function handleClick3(cb){
        if(!cb.checked){
            document.getElementById("hoz4").innerHTML = "";
            if(document.getElementById('ujbankf').checked){
                document.getElementById("hoz5").innerHTML = aktbankok;
            }
        }else {
            document.getElementById("hoz5").innerHTML = "";
            document.getElementById("hoz4").innerHTML = ujbank;

        }
    }
    function handleClick4(cb){
        if(!cb.checked){
            document.getElementById("hoz6").innerHTML = "";
            document.getElementById("hoz5").innerHTML = "";
        }else {
            document.getElementById("hoz6").innerHTML = ujbankf;
            if(!document.getElementById('ujbank').checked){
                document.getElementById("hoz5").innerHTML = aktbankok;
            }
        }
    }
    function validateForm3() {
        if (!document.getElementById('ujbank').checked && !document.getElementById('ujbankf').checked) {
            alert("A semmit nem lehet hozzáadni!");
            return false;
        }else if(document.getElementById('ujbank').checked && !document.getElementById('ujbankf').checked){
            alert("Adj hozzá bankfiókot is");
            return false;
        }
    }
</script>
