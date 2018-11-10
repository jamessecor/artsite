<?php
// IMAGES 2013 PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
	<?php
		displayImages(" yearCreated = 2013 ORDER BY arrangement");
	?>	
</div>

<?php
include "footer.php";
?>