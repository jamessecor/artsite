<?php
// IMAGES 2014 PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
	
		<?php
		displayImages(" yearCreated = 2014 ORDER BY arrangement");
		?>
	
</div>

<?php
include "footer.php";
?>