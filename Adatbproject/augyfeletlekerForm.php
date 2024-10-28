<?php
?>
<div id="id08" class="modal">

    <form class="modal-content animate" action="augyfelek.php" name="lekeres" method="POST" accept-charset="utf-8">
        <div class="container">
            <span onclick="document.getElementById('id08').style.display='none';" class="close" title="Close Modal">&times;</span>
            <h1>Ügyfél kiválasztása</h1>
            <p>Adott ügyfél esetén csak egy mezőt tölts ki! <br> Ha üresen hagyod a mezőket akkor vagy a jogi személyeket, vagy a magánszemélyeket lehet lekérdezni(cég checkbox)</p>
            <hr>
            <label>
                <b>Összes ügyfél</b> <input id="osszeset" type="checkbox" onchange='handleClick(this);' checked name="osszes" style="margin-bottom:15px">
            </label>
            <div id="osszes">

            </div>

            <div id="elvesz">

            </div>

            <div id="hozzad">

            </div>
            <div id="fix">

            </div>
            <button type="submit" class="nagy" name="leker">Elküld</button>
        </div>
    </form>
</div>
<script>
    let egyik = '<label for="cegnev"><b>Cégnév</b></label><input type="text" name="cegnev"/><label for="szekhely"><b>Székhely</b></label><input type="text" name="szekhely"/>';
    let masik = '<label for="szem"><b>Személyi igazolvány száma</b></label> <input type="text" name="szem"/> <label for="lakcim"><b>Lakcím</b></label> <input type="text" name="lakcim" />';
    let osszes = '<label> <b>Cég</b> <input type="checkbox" id="cegg" onchange="handleClick1(this);" name="ceg" style="margin-bottom:15px"></label>';
    let fix = '<label for="szamlaszam"><b>Számlaszám</b></label><input type="text" name="szamlaszam"/>';
   function handleClick(cb){
       if(!cb.checked){
            document.getElementById("osszes").innerHTML = osszes;
            document.getElementById("elvesz").innerHTML = masik;
            document.getElementById("fix").innerHTML = fix;
       }else {
           document.getElementById("hozzad").innerHTML = "";
           document.getElementById("elvesz").innerHTML = "";
           document.getElementById("osszes").innerHTML = "";
           document.getElementById("fix").innerHTML = "";
       }
   }
    function handleClick1(cb) {

        if(cb.checked){

            document.getElementById("hozzad").innerHTML = egyik;
            document.getElementById("elvesz").innerHTML = "";
        }else {

            document.getElementById("hozzad").innerHTML = "";
            document.getElementById("elvesz").innerHTML = masik;

        }
    }
</script>
