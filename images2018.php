<?php
// IMAGES 2018 PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
	<?php
		displayImages(" yearCreated = 2018 ORDER BY arrangement");
	?>
</div>

<?php
include "footer.php";
?>