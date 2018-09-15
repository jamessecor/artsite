<?php
// IMAGES 2018 PAGE

include "header.php";
include "./imagesTemplate.php";
?>
<script src='./jrsArt.js'></script>

<div class='container'>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
		<?php
		displayImages(" yearCreated = 2018 ORDER BY arrangement");
		?>
		</div>
	</div>
</div>

<?php
include "footer.php";
?>