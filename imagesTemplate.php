<?php
require "../dbconfig/dbparams.php";
require "../dbconfig/dbconnect.php";

	function displayImages($year) 
	{
		global $db;
		// Database Retrieval of Titles/Filenames
		$query = "";
		// For homepage, year = 0
		if($year===0) {
			$whereClause = " isHomePage = true ORDER BY arrangement";
		} else {
			$whereClause = "yearCreated = '$year' AND NOT(arrangement = -1) ORDER BY arrangement";
		}
		$query = "SELECT title, yearCreated, media, filename, buyerID, price FROM imageData WHERE " . $whereClause . ";";
		
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
					
					$price = "";
					if($row['buyerID'] || $row['price'])
						$price = $row['buyerID'] ? "sold" : "$$row[price]";
					print "<div class='priceTag'><a href='$filepath' target='blank'><img class='img-responsive' src='$filepath' alt='Image Loading Error'></a>";
					print "<div class='text' ><strong>$row[title]</strong>, $row[yearCreated]<br>$row[media]";
					if($price !== "")
						print "<span class='priceTagText'>${price}</span>";
					print "</div></div><br><br>";
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