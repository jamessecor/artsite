<?php
require "../dbconfig/dbparams.php";
require "../dbconfig/dbconnect.php";

	function displayImages($year) 
	{
		global $db;
		// Database Retrieval of Titles/Filenames
		$query = "";
		if($year===0) {
			$query = "SELECT title, yearCreated, media, filename, buyerID FROM imageData WHERE isHomePage = true ORDER BY arrangement;";
		} else {
			$query = "SELECT title, yearCreated, media, filename, buyerID FROM imageData WHERE yearCreated = '$year' AND arrangement > 0 ORDER BY arrangement;";
		}
		$data = mysqli_query($db, $query);
		if(!$data) {
			print "Images could not be retrieved.";
		} else {
			echo "&nbsp;";
			// print "<div class='center-it text'><strong>Images from ${year}</strong></div><br><br>";
			$numrows = mysqli_num_rows($data);
			for($i = 0; $i < $numrows; $i++) {
				$row = mysqli_fetch_assoc($data);
				if($row) {
					$filepath = "../img/" . $row['filename'];
					print "<a href='$filepath' target='blank'><img class='img-responsive' src='$filepath' alt='Image Loading Error'></a>";
					print "<div class='text' id='label'><strong>$row[title]</strong>, $row[yearCreated]<br>$row[media]";
					/*
					// New Code
					if($row[buyerID]) != NULL) {
						print "sold";
					} // else {
						// print "$row[price]";
					// }
					// End New Code
					*/
					print "</div><br><br>";
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
	}
		
		?>