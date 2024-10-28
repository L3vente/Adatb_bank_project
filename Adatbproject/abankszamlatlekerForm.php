<?php
?>
<div id="id09" class="modal">

    <form class="modal-content animate" action="abankszamlak.php" name="lekeres2" onsubmit="return validateForm2()" method="POST" accept-charset="utf-8">
        <div class="container">
            <span onclick="document.getElementById('id09').style.display='none';" class="close" title="Close Modal">&times;</span>
            <h1>Bankszámlák kiválasztása</h1>
<!--            <p>Adott ügyfél esetén csak egy mezőt tölts ki!</p>-->
            <hr>
            <label>
                <b>Összes Bankszámla</b> <input id="osszeset" type="checkbox" onchange='handleClick2(this);' checked name="osszes" style="margin-bottom:15px">
            </label>
            <div id="hoz"></div>
            <div id="hoz1"></div>
            <button type="submit" class="nagy" name="leker">Elküld</button>
        </div>
    </form>
</div>
<script>
    let atlag = '<label><b>Átlag feletti egyenleg</b> <input id="atlag" type="checkbox" onchange="handleClick21(this);" name="atlag" style="margin-bottom:15px"></label';
    let adott = '<label for="szamlaszam"><b>Számlaszám</b></label> <input type="text" name="szamlaszam"/>';
    function handleClick2(cb){
        if(!cb.checked){
            document.getElementById("hoz").innerHTML = atlag;
            document.getElementById("hoz1").innerHTML = adott;
        }else {
            document.getElementById("hoz").innerHTML = "";
            document.getElementById("hoz1").innerHTML = "";
        }
    }
    function handleClick21(cb){
        if(cb.checked){
            document.getElementById("hoz1").innerHTML = "";
        }else {
            document.getElementById("hoz1").innerHTML = adott;
        }
    }
        function validateForm2() {
            let szamlaszam = document.forms["lekeres2"]["szamlaszam"].value;
            if (!document.getElementById('atlag').checked && szamlaszam == "") {
                alert("Valamelyik mezőt töltsd ki!");
                return false;
            }
        }
</script>

