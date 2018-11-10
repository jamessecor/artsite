<?php
// IMAGES AS NOT SEEN PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
	<?php
		displayImages(" grouping = 'storage' ORDER BY arrangement");
	?>
</div>

<?php
include "footer.php";
?>