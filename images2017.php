<?php
// IMAGES 2017 PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
		<?php
		displayImages(" yearCreated = 2017 ORDER BY arrangement");
		?>
		</div>
	</div>
</div>

<?php
include "footer.php";
?>