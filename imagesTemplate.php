<?php
require "../dbconfig/dbparams.php";
require "../dbconfig/dbconnect.php";
include "./utility.php";

// Not Logged In
if(isLoggedIn()) { 
	// Log out button
	if(isset($_POST['logout'])) {
		logout();	
	}
?>
	<div class='col-md col-md-offset-6 center-it'>
		<form method="post" action="">
			<table>
				<tr>
					<td>
						<input type="submit" name="logout" value="Log Out">
					</td>
				</tr>
			</table>
		</form>
	</div>

	<?php
	// ================= Process Updates =================
	// Must be logged in
	if(isset($_GET['imgID'])) {
		$updates = array();
		
		// Title
		if(isset($_GET['new-title'])) {
			$newTitle = mysqli_real_escape_string($db, $_GET['new-title']);
			$updates[] = " title = '$newTitle'"; 
		}	
		
		// YearCreated
		if(isset($_GET['new-year'])) {
			$newYear = mysqli_real_escape_string($db, $_GET['new-year']);
			$updates[] = " yearCreated = '$newYear'"; 
		}	
		
		// Media
		if(isset($_GET['new-media'])) {
			$newMedia = mysqli_real_escape_string($db, $_GET['new-media']);
			$updates[] = " media = '$newMedia'"; 
		}	
		
		// Price
		if(isset($_GET['new-price'])) {
			$newPrice = mysqli_real_escape_string($db, $_GET['new-price']);
			$updates[] = " price = '$newPrice'"; 
		}		
		
		// Position
		if(isset($_GET['new-position'])) {
			$newArrangement = mysqli_real_escape_string($db, $_GET['new-position']);
			$updates[] = " arrangement = '$newArrangement'";
		}
		
		// Buyer
		if(isset($_GET['new-buyer'])) {
			$newBuyer = mysqli_real_escape_string($db, $_GET['new-buyer']);
			if($newBuyer === "") {
				$updates[] = " buyerID = NULL";		
			} else {
				$updates[] = " buyerID = '$newBuyer'";		
			}			
		}
		
		// Sale Date
		if(!empty($_GET['new-saleDate'])) {
			$newSaleDate = mysqli_real_escape_string($db, $_GET['new-saleDate']);
			$updates[] = " saleDate = '$newSaleDate'";
		}

		// Generate Update Statement
		$imgID = $_GET['imgID'];
		$updateArrangement = "UPDATE imageData SET ";
		$first = true;
		$updateStr = "";
		foreach($updates as $update) {
			if($first) {
				$first = false;
			} else {
				$updateArrangement .= ", ";
			}			
			$updateArrangement .= $update;
		}		
		$updateArrangement .= " WHERE imgID='$imgID';";
		$result = mysqli_query($db, $updateArrangement);
		if(!$result)
			die("unable to update arrangement");	
		
		print($updateArrangement);
	}
	// ================== End Update Processing ======================
}

	function displayImages($whereClause) 
	{
		global $db;
		// Database Retrieval of Titles/Filenames
		$query = "SELECT imgID, title, yearCreated, media, filename, buyerID, price, saleDate, arrangement FROM imageData WHERE " . $whereClause . ";";
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
					// TODO: make filepath a parameter so you can use different folders
					$filepath = "./img/" . $row['filename'];
					
					$price = "";
					if($row['buyerID'] || $row['price'])
						$price = $row['buyerID'] ? "NFS" : "$$row[price]";
					else
						$price = "POR";
					
					// Sort out rows / columns
					if($i % 3 === 0) {
						print "<div class=\"row img-row\">";
					}
					
					switch($i % 3) {
						case(0): 
							print "<div class=\"col-md-4 col-left\">";
							break;
						case(1):
							print "<div class=\"col-md-4 col-middle\">";
							break;
						case(2):
							print "<div class=\"col-md-4 col-right\">";
							break;
					}
					
					
					//NEW BEGINS ************************************
					//print "<div class='priceTag'><a href='$filepath' target='blank'><img class='img-responsive' src='$filepath' alt='Image Temporarily Unavailable'></a>";
					
					?>		
					
					<div class="priceTag">
					<div id="modal-img-<?php echo $i;?>" class="modal">
						<a href="#close-modal" rel="modal:close" class="close-modal ">Close</a>
						<img class="img-responsive" id="inner-img-<?php echo $i; ?>" src="<?php echo $filepath; ?>" alt="Image unavailable"/>

						<?php if($i !== 0) { ?>
							<a id="left-arrow-<?php echo $i;?>" class="arrows" href="#modal-img-<?php echo $i - 1;?>" rel="modal:open" >&nbsp;</a>
							<a id="real-arrow-left" class="real-arrows" href="#modal-img-<?php echo $i - 1;?>" rel="modal:open">&#x25C0;</a>
						<?php } 
						if($i !== $numrows -1) { ?>
							<a id="right-arrow-<?php echo $i;?>" class="arrows" href="#modal-img-<?php echo $i + 1;?>" rel="modal:open" >&nbsp;</a>
							<a id="real-arrow-right" class="real-arrows" href="#modal-img-<?php echo $i + 1;?>" rel="modal:open">&#x25B6;</a>
						<?php } ?>

					</div>
					
					<!-- Link to open the modal -->
					<!-- This is the image displayed prior to clicking -->
					<a href="#modal-img-<?php echo $i;?>" rel="modal:open"><img class="img-responsive" src="<?php echo $filepath; ?>" alt="Image unavailable"/></a>
					
					<?php
					// NEW ENDS ************************************
					
					print "<div style='height:.5em'>&nbsp;</div>";
					// Image Info
					$info = "<div class='text' ><strong>$row[title]</strong>, $row[yearCreated]<br>$row[media]";
					if($price !== "")
						$info .= "<br>${price}";
					print $info;
					if(isLoggedIn()) {
						$peeps = selectQuery($db, "c_id,c_name,c_lastname", "contacts", "1", "1");								
					?>
						<br>
						<form name="update-arrangement" method="get" action="">
							<input type="text" name="new-title" value="<?php echo $row['title']; ?>" />
							<input type="text" name="new-year" value="<?php echo $row['yearCreated']; ?>" />
							<input type="text" name="new-medium" value="<?php echo $row['media']; ?>" />
							<input type="text" name="new-price" value="<?php echo $row['price']; ?>" />
							<input type="text" name="new-position" value="<?php echo $row['arrangement']; ?>" />
							<select name="new-buyer">
								<option value="">Select...</option>
							<?php 
								if($peeps) {									
									while($peep = mysqli_fetch_assoc($peeps)) {										
										$selected = "";										
										if($peep['c_id'] === $row['buyerID']) {
											$selected = "selected";
										}
										echo "<option value=\"$peep[c_id]\" $selected >$peep[c_name] $peep[c_lastname]</option>";
									}
								}								
							?>
							</select>
							<input type="date" name="new-saleDate" value="<?php echo $row['saleDate']; ?>" />
							<input type="hidden" name="imgID" value="<?php echo $row['imgID']; ?>" />
							<input type="submit" value="Update" />								
						</form>
					<?php
					}
					print "</div></div></div>";
					
					if($i === $numrows - 1) {
						print "</div>";
					} elseif($i % 3 === 2) {
						print "</div><div class=\"row\">&nbsp;</div>";
					}
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