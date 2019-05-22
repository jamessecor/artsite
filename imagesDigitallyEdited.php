<?php
// IMAGES Digitally Edited

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
	<?php
		displayImages(" grouping = 'digital_edits' ORDER BY arrangement");
	?>
</div>

<?php
include "footer.php";
?>