<?php
// IMAGES 2022 PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
	<?php
		displayImages(" yearCreated = 2022 ORDER BY arrangement");
	?>
</div>

<?php
include "footer.php";
?>