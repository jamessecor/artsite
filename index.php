<?php
// IMAGES 2019 PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
    <?php
        displayImages(" isHomePage = true ORDER BY arrangement");
    ?>
</div>

<?php
include "footer.php";
?>