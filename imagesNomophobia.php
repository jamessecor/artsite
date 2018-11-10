<?php
// IMAGES 2017 PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
	<?php
		displayImages(" grouping = 'NOMO' ORDER BY arrangement");
	?>
</div>

<?php
include "footer.php";
?>