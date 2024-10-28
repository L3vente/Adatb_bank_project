<div  class="topnav" id="myTopnav">
    <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["felhasznalonev"]==="admin") { ?>
        <a href="admin.php" class="<?php if($page=="admin"){?>active<?php } ?>">Admin</a>
        <a href="logout.php" style="width:auto; float: right; height: auto" class="login">Kijelentkezés</a>
    <?php } else if(isset($_SESSION["user"])) { ?>
        <a href="home.php" class="<?php if($page=="home"){?>active<?php } ?>">Főoldal</a>
        <a href="uugyintezes.php" class="<?php if($page=="ugyintezes"){?>active<?php } ?>">Ügyintézés</a>
        <a href="uszamla.php" class="<?php if($page=="szamla"){?>active<?php } ?>">Számlák</a>
        <a href="logout.php" style="width:auto; float: right; height: auto" class="login">Kijelentkezés</a>
    <?php } else { ?>
        <a href="home.php" class="<?php if($page=="home"){?>active<?php } ?>">Főoldal</a>
        <button onclick="document.getElementById('id01').style.display='block'" style="float: right; width:auto" class="login nagy">Bejelentkezés</button>
        <button class="nagy" onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Ügyfél regisztráció</button>
    <?php } ?>
</div>
<div class="bgimg"></div>
<?php
include "footer.php";
