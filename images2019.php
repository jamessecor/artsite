<?php
// IMAGES 2019 PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
	<?php
		displayImages(" yearCreated = 2019 ORDER BY arrangement");
	?>
</div>

<?php
include "footer.php";
?>