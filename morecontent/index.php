<?php
// Landing PAGE

include "./header.php";
?>
<script src='../jrsArt.js'></script>
<div class='container'>    
    <?php
    $totalCircles = 166;
    for($i = 0; $i < $totalCircles; $i++) {
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
<script>
    $(document).ready(function() {
        for(var i = 0; i < <?php echo $totalCircles; ?>; i++) {            
            $("#circle-loader-" + i).css("background-color", getRGB());
        }        
    });
    function getRGB() {
        var r = Math.round((Math.random() * 255),1);
        var g = Math.round((Math.random() * 255),1);
        var b = Math.round((Math.random() * 255),1);
        
        return "rgb(" + r + "," + g + "," + b + ")";
    }
</script>
<?php
include "../footer.php";
?>