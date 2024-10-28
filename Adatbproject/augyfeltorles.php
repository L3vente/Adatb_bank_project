<?php
function ugyfelet_torol(){
    $ugyfeid = $_POST["ugyfelid"];
    if ( !($conn = bank_csatlakozas()) ) {
        echo '<script>alert("HIBA")</script>';
        die("Hiba a csatlakozásnál");
    }
    $stmt = $conn->prepare('BEGIN;
		DELETE FROM bankszamla WHERE bankszamla.szamlaszam IN (SELECT bankszamla.szamlaszam FROM bankszamla,tulajdona,ugyfel,penzforgalom WHERE bankszamla.szamlaszam = tulajdona.szamlaszam AND ugyfel.ugyfelid = tulajdona.ugyfelid AND ugyfel.ugyfelid = :ugyfelid AND penzforgalom.megbizoszamlaszam = bankszamla.szamlaszam GROUP BY bankszamla.szamlaszam ORDER BY bankszamla.szamlaszam);
		DELETE FROM ugyfel WHERE ugyfelid = :ugyfelid;
		COMMIT;');
    $stmt->bindParam(':ugyfelid',$ugyfeid, PDO::PARAM_INT,11);
    $stmt->execute();
    return true;
}
if(isset($_POST["torles"])){

        $sikeres = ugyfelet_torol();
        if ($sikeres) {
            echo '<script>alert("Sikeres törlés")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=admin.php">';
            $conn = null;
            die();
        } else {
            echo '<script>alert("Sikertelen törlés!")</script>';
            echo '<meta http-equiv="Refresh" content="0;url=admin.php">';
            $conn = null;
            die();
        }
    }
?>
