<?php
// IMAGES 2014 PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
		<?php
		displayImages(2014);
		?>
		</div>
	</div>
</div>

<?php
include "footer.php";
?>