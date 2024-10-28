<?php
if ( !($conn = bank_csatlakozas()) ) {
    echo '<script>alert("HIBA")</script>';
    die("Hiba a csatlakozásnál");
}
$sql8 = "SELECT * FROM bank";
$res8 = $conn->query($sql8);

if(isset($_POST["banktoles"])){
    if(isset($_POST["bnkt"])){
        $banknev = $_POST["banknt"];
        $stmt = $conn->prepare('BEGIN;
         DELETE FROM bank WHERE nev = :nev;
         COMMIT;');
        $stmt->bindParam(':nev', $banknev, PDO::PARAM_STR, 256);
        $stmt->execute();
        $conn = null;
        echo '<script>alert("Sikeres törlés!")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=admin.php">';
    }else if(isset($_POST["ujbnkt"])){
        $bankfszam = $_POST["bfiok"];
        $stmt = $conn->prepare('BEGIN;
        DELETE FROM bankfiok WHERE bfiokszam = :bfiokszam;
        COMMIT;');
        $stmt->bindParam(':bfiokszam', $bankfszam, PDO::PARAM_INT, 11);
        $stmt->execute();
        $conn = null;
        echo '<script>alert("Sikeres törlés!")</script>';
        echo '<meta http-equiv="Refresh" content="0;url=admin.php">';
    }
}


?>
<div id="id13" class="modal">

    <form class="modal-content animate" name="lekeres4" onsubmit="return validateForm41();" method="POST" accept-charset="utf-8">
        <div class="container">
            <span onclick="document.getElementById('id13').style.display='none';" class="close" title="Close Modal">&times;</span>
            <h1>Bank/bankfiók törlése</h1>
            <p>Egyszerre csak egy bankot/fiókot lehet törölni!</p>
            <hr>
            <label>
                <b>Bank</b> <input id="bnkt" type="checkbox" onchange='handleClick5(this);' checked name="bnkt" style="margin-bottom:15px">
            </label>
            <br>


            <div id="hoz41">
                <label for="banknt"><b>Válaszd ki a bankot:</b></label>
                <select name="banknt"><?php $res8 = $conn->query($sql8); foreach  ($res8 as $current_row3) {
                        echo '<option value="' . $current_row3["nev"]. '">' . $current_row3["nev"].'</option>';}?>
                </select>
            </div>
            <label>
                <b>Banfiók</b> <input id="ujbnkt" type="checkbox" onchange='handleClick6(this);' name="ujbnkt" style="margin-bottom:15px">
            </label>
            <div id="hoz51">

            </div>
            <button type="submit" class="torles" name="banktoles">Törlés</button>
        </div>
    </form>
</div>
<script>
    let aktfiokok = '<label for="bfiok"><b>Válaszd ki a bankfiókot:</b></label><select name="bfiok"><?php $sql = "SELECT bank.nev as bnev,bank.szekhely,bankfiok.bfiokszam,bankfiok.cim as bankfiokcim FROM bank, bankfiok WHERE bank.nev = bankfiok.nev ORDER BY bankfiok.bfiokszam";
        $res = bank_csatlakozas()->query($sql); foreach ($res as $current_row) {
        echo '<option value="' . $current_row["bfiokszam"]. '">' . $current_row["bfiokszam"]."-".$current_row["bankfiokcim"]."-".$current_row["bnev"].'</option>';}?></select>';
    let aktbankok1 = '<label for="banknt"><b>Válaszd ki a bankot:</b></label><select name="banknt"><?php $res8 = $conn->query($sql8); foreach ($res8 as $current_row3) {
        echo '<option value="' . $current_row3["nev"]. '">' . $current_row3["nev"].'</option>';}?></select>';

    function handleClick5(cb){
        if(!cb.checked){
            document.getElementById("hoz41").innerHTML = "";
        }else {
            document.getElementById("hoz41").innerHTML = aktbankok1;

        }
    }
    function handleClick6(cb){
        if(!cb.checked){
            document.getElementById("hoz51").innerHTML = "";
        }else {
            document.getElementById("hoz51").innerHTML = aktfiokok;
        }
    }
     function validateForm41() {
         if (!document.getElementById('bnkt').checked && !document.getElementById('ujbnkt').checked) {
             alert("A semmit nem lehet törölni!");
             return false;
         }else if(document.getElementById('bnkt').checked && document.getElementById('ujbnkt').checked){
            alert("Egyszerre csak egyet lehet törölni!");
             return false;
         }
     }
</script>
