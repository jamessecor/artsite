<?php
// Landing PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
    <div class="row center-it">
        <div class="loader love-tech"></div>
        <div class="mx-auto" id="cent-pourcent">
            <div id="pourcentage"></div>
            <div id="pourcentage-chiffre">0% Complete</div>
            <button id="load-content-button" onclick="move()">Load Content</button>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>