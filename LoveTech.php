<?php
// Landing PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>
<div class='container'>    
    <?php
    for($i=0;$i<166;$i++) {
    ?>    
        <div id="circle-loader-<?php echo $i; ?>" style="display:none" class="loader love-tech"></div>
    <?php
    }
    ?>    
    <div class="row center-it">
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