<?php
// IMAGES 2021 PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
	<?php
		displayImages(" yearCreated = 2021 ORDER BY arrangement");
	?>
</div>

<?php
include "footer.php";
?>