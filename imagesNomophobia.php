<?php
// IMAGES NOMOPHOBIA PAGE

include "header.php";
require "../dbconfig/dbparams.php";
require "../dbconfig/dbconnect.php";
// nomophobiaImages
?>
<script src='./jrsArt.js'></script>

<div class='container'>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
		<?php
		// Database Retrieval of Titles/Filenames
		$query = "SELECT title, yearCreated, media, filename FROM imageData WHERE arrangement = -1;";
		$data = mysqli_query($db, $query);
		if(!$data) {
			print "Images could not be retrieved.";
		} else {
			echo "&nbsp;";
			// print "<div class='center-it text'><strong>-- Images from <em>#nomophobia</em> --</strong></div><br><br>";
			$numrows = mysqli_num_rows($data);
			for($i = 0; $i < $numrows; $i++) {
				$row = mysqli_fetch_assoc($data);
				if($row) {
					$filepath = "./nomophobiaImages/" . $row['filename'];
					print "<a href='$filepath'><img class='img-responsive' src='$filepath' alt='Image Loading Error'></a>";
					print "<div class='text' id='label'><strong>$row[title]</strong>, $row[yearCreated]<br>$row[media]</div><br><br>";					
				}
			}
			?>
			<div class="row">
				<div style="text-align:center;">
					<a href='#' id='toTop'>back to top</a>
				</div>
			</div>
			<br><br>
		<?php
		}
		?>
		
		</div>
	</div>
</div>


<?php
include "footer.php";
?>