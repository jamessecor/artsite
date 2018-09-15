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
		displayImages(" yearCreated = 2014 ORDER BY arrangement");
		?>
		</div>
	</div>
</div>

<?php
include "footer.php";
?>