<?php
// IMAGES mug,dish,glass PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
	<?php
		displayImages(" grouping = 'mug_dish_glass' ORDER BY arrangement");
	?>
</div>

<?php
include "footer.php";
?>