<?php
// AVAILABLE WORKS PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
	<?php
		displayImages(" buyerId is null and saleDate is null ORDER BY arrangement");
	?>	
</div>

<?php
include "footer.php";
?>