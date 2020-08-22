<?php
// IMAGES 2019 PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
    <div class="row">
        <div class="col center-it">
            <form action="availableWorks.php">
                <input type="submit" value="view works available for purchase" />
            </form>
        </div>
    </div>
    <?php
        displayImages(" isHomePage = true ORDER BY arrangement");
    ?>
</div>

<?php
include "footer.php";
?>