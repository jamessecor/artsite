<?php
// editartwork.php
// author jrs
// 2018

$errors = array();
$selected = "";
$selectedTitle = ""; 
$selectedID = 0;
$selectWork = "";
$disabled="";
$validWork=false;
		
// Get member's artwork info from database
$artworkResult = selectQuery($db, "*", "imageData", "1", "title");

if(!$artworkResult) {
	die("Connection error: select query. " . mysqli_connect_error());
} else { // got artwork
	// Dropdown showing pieces to edit and edit button
	?>
<div class="container-fluid">
	<form id="selectwork" method="post" action="">
		<table align="center">
			<tr>
				<td>Select a work to edit</td>
			</tr>
			<tr>
				<td><select id="piece" name="workSelected" >
					<option value="newWork">*Add New Work*</option>						
				<?php
				// Populate drop-down
				if(isset($_POST['editwork']) || isset($_POST['deletework'])) {
					if(!empty($_POST['workSelected'])) {
						global $selectedTitle;
						$s = $_POST['workSelected'];
						$selectedID = $_POST['workSelected'];
					} else {
						$errors['validwork'] = "Choose a work to edit or delete.";
					}
					
				}
				
				// Work is selected 
				//if(count($errors) == 0)
					$validWork = true;
				
				
				while($work = mysqli_fetch_assoc($artworkResult)) {
					$n = $work['title'];
					$id = $work['imgID'];
					// Correct Updated Artwork for dropdown and display
					if(isset($_POST['updatework']) && ($n == $_POST['oldtitle'])) {
						$n = $_POST['updatetitle'];
					}						
					
					// Only display on Dropdown menu if not deleted
					if(!(isset($_POST['submitdeletion']) && $n == $_POST['oldtitle'])) {
						if(isset($_POST['workSelected']) && $_POST['workSelected'] === $n)
							print "<option value=\"${id}\" selected>$n</option>";
						else
							print "<option value=\"${id}\">$n</option>";
					}
				}
				?>
				</select>
				</td>
			</tr>
			<tr>
				<td><small class='errorText'><?php echo array_key_exists('validwork',$errors) ? $errors['validwork'] : ''; ?></small></td>
			</tr>
			<tr>
				<td><input type="submit" value="Add/Edit Work" name="editwork">
				<input type="submit" value="Delete Work" name="deletework"></td>
			</tr>
		</table>
	</form>	
</div>
	<?php 					
	if($validWork && (isset($_POST['editwork']) || isset($_POST['deletework']))) {
		// TODO: validate entry
		$isNew = false;
		if(isset($_POST['workSelected']) && $_POST['workSelected'] === "newWork") 
			$isNew = true;
			
		
		$editResult = selectQuery($db, "*", "imageData", "imgID = '$selectedID'", "1");
		if(!$editResult) {
			die("Database error here.");
		} else {
			// This is the current info, to be edited
			$editWork = mysqli_fetch_assoc($editResult);
			
			// Get $workID, the artworkID to update
			$workID = $editWork['imgID'];	
			$imgLocation = $editWork['filename'];
			if(isset($_POST['editwork']) || isset($_POST['deletework'])) {
				if(isset($_POST['deletework']))
					$disabled="disabled";
			
			// =========================================================
			// ================ EDIT or ADD NEW Form ===================
			// =========================================================
			if(!$isNew) { 
				$path="";
				if($editWork['arrangement'] == -1)
					$path = "./nomophobiaImages/";
				else
					$path = "./img/";
				
				// Enable "" in title and media
				$htmlTitle = htmlentities($editWork['title']);
				$htmlMedia = htmlentities($editWork['media']);
				?>
				&nbsp;	
				<div><img class="img-responsive center-it thumbnail" src="<?php echo "$path$imgLocation"; ?>" alt="Image Loading Error"></div>				
			<?php } ?>
			
			<form id="updateform" class="container-fluid" method="post" action="" enctype="multipart/form-data">
				<table align="center">
					<?php if($disabled !== "disabled") { ?>
					<tr>
						<th>Filename</th>
					</tr>
					<tr>
						<td>
							<input type='file' name='updatefilename'>
							<input type="checkbox" name="bypassupload" <?php echo $isNew ? "" : "checked" ?>>Bypass Image Upload							
						</td>
					</tr>
					<?php } ?>
					<tr>
						<th>Title</th>
					</tr>
					<tr>
						<td><input type="text" name="updatetitle" value="<?php echo $isNew ? "" : $htmlTitle;?>" <?php echo $disabled; ?>></td>
						<td><small class='errorText'><?php echo array_key_exists('updatetitle',$errors) ? $errors['updatetitle'] : ''; ?></small></td>
					</tr>
					<tr>
						<th>Medium</th>
					</tr>
					<tr>
						<td><input type="text" name="updatemedium" value="<?php echo $isNew ? "" : $htmlMedia;?>" <?php echo $disabled; ?>></td>
					</tr>
					<tr>
						<th>Year</th>
					</tr>
					<tr>
						<td><input type="text" name="updateyear" value="<?php echo $isNew ? "" : "$editWork[yearCreated]";?>" <?php echo $disabled; ?>></td>
					</tr>
					<tr>
						<th>Arrangement</th>
					</tr>
					<tr>
						<td><input type="text" name="updatearrangement" value="<?php echo $isNew ? "" : "$editWork[arrangement]";?>" <?php echo $disabled; ?>></td>
					</tr>
					<tr>
						<th>Grouping</th>
					</tr>
					<tr>
						<td>
							(Available Groupings: 
							<?php
							$groupingsResult = selectQuery($db, "DISTINCT grouping", "imageData", "1", "1");
							if(!$groupingsResult) {
								echo ("couldn't find grouping");
							} else {
								while($group = mysqli_fetch_array($groupingsResult)) {
									echo " ${group[0]} ";
								}
							}							
							?>
							)
						</td>
					</tr>
					<tr>
						<td><input type="text" name="updategrouping" value="<?php echo $isNew ? "" : "$editWork[grouping]";?>" <?php echo $disabled; ?>></td>
					</tr>
					<tr>
						<th>Price</th>
					</tr>
					<tr>
						<td><input type="text" name="updateprice" value="<?php echo $isNew ? "" : "$editWork[price]";?>" <?php echo $disabled; ?>></td>
					</tr>
					<tr>
						<th>Buyer</th>
					</tr>
					<tr>
						<td>
							<select name="updatebuyer" <?php echo " $disabled "; ?>>
							<option value="">Select...</option>
							<?php 
							$contactResults = selectQuery($db, "c_id,c_name,c_lastname", "contacts", "1", "c_name");
							if(!$contactResults) {
								die("Contacts could not be retrieved");
							} else {
								while($contact = mysqli_fetch_assoc($contactResults)) {									
									$contactID = $contact['c_id'];									
									$firstname = $contact['c_name'];
									$lastname = $contact['c_lastname'];
									if($editWork['buyerID'] === $contactID)
										echo "<option value='$contactID' selected>$firstname $lastname</option>";
									else
										echo "<option value='$contactID'>$firstname $lastname</option>";
								}
							}							
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" name="ishomepage" <?php echo $editWork['isHomePage'] ? "Checked" : ""; echo " $disabled "; ?>>Put on homepage
						</td>
					</tr>
					<?php 
					$ok = "	<tr>
								<td><small class='errorText'>Selecting \"Delete\" will remove this piece from the database.</small></td>
							</tr>";
					if(isset($_POST['deletework'])) {
						$value = "Delete";
						$name = "submitdeletion";
						echo $ok;
					} else {
						$value = "Update";
						$name = "updatework";
					}
					?>
					<tr>
						<td><input type="submit" value="<?php echo "$value"; ?>" name="<?php echo "$name"; ?>"></td>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="artworkid" value="<?php echo $workID; ?>">
							<input type="hidden" name="oldtitle" value="<?php echo $editWork['title']; ?>">
							<input type="hidden" name="oldfilename" value="<?php echo $editWork['filename']; ?>">
							<input type="hidden" name="isnew" value="<?php echo $isNew; ?>">
						</td>
						
					</tr>
				</table>
			</form>
			<?php		
			} 
		}
	} elseif(isset($_POST['updatework'])) {
		// ===========================================================
		// ===================== INSERT or UPDATE ====================
		// ===========================================================
		// Set bypassUpload if it's set
		$bypassUpload = isset($_POST['bypassupload']);
		
		// If not bypassed
		if(!$bypassUpload) {
			// Validate filename
			if(empty($_FILES['updatefilename']['name'])) {
				$errors['filename'] = "Please Select a File.";
			} else {
				$newFilename = $_FILES["updatefilename"]["name"];
			}
		}
						
		// Validate Title
		if(!empty($_POST['updatetitle'])) {
			$newTitle = addslashes(trim($_POST['updatetitle']));
			if(strlen($newTitle) == 0)
				$errors['updatetitle'] = "Enter a title";
		} else {
			$errors['updatetitle'] = "Enter a title";						
		}
		// Validate Medium
		if(!empty($_POST['updatemedium'])) {
			$newMedium = addslashes(trim($_POST['updatemedium']));
			if(strlen($newMedium) == 0)
				$errors['updatemedium'] = "Enter a medium";
		} else {
			$errors['updatemedium'] = "Enter a medium";						
		}
		
		// Validate Year
		if(!empty($_POST['updateyear'])) {
			$newYear = $_POST['updateyear'];
			if(strlen($newYear) == 0)
				$errors['updateyear'] = "Enter a year";
		} else {
			$errors['updateyear'] = "Enter a year";						
		}
		
		// Validate arrangement
		if(!empty($_POST['updatearrangement'])) {
			$newArrangement = $_POST['updatearrangement'];
			if(strlen($newArrangement) == 0)
				$errors['updatearrangement'] = "Enter an arrangement";
		} else {
			$errors['updatearrangement'] = "Enter an arrangement";						
		}
		
		// Validate Price
		$hasPrice = false;
		if(!empty($_POST['updateprice'])) {
			$newPrice = $_POST['updateprice'];
			$hasPrice = true;
		} 
		
		// Validate Buyer
		$hasBuyer = false;
		if(!empty($_POST['updatebuyer'])) {
			$newBuyer = $_POST['updatebuyer'];
			$hasBuyer = true;
		} 
		
		// Validate Grouping
		$hasGrouping = false;
		if(!empty($_POST['updategrouping'])) {
			$newGrouping = $_POST['updategrouping'];
			$hasGrouping = true;
		}
		
		// Set isHomePage if it's set
		$isHomePage = isset($_POST['ishomepage']) ? 1 : 0;

								
		$artworkID = $_POST['artworkid'];
		
		$validUpdate = false;
		if(count($errors) === 0) {
			// Upload image if not bypassed
			if(!$bypassUpload) {
				include "uploadProcessing.php";
				$target_dir = "./img/";
				uploadFile($target_dir, "updatefilename");
			}
			$query = "";
			$isNew = $_POST['isnew'];
			if(!$isNew) {
				// Update Query
				$query = "UPDATE imageData SET	title = '$newTitle', 
												media = '$newMedium',
												yearCreated = '$newYear', 
												arrangement = '$newArrangement',
												isHomePage = '$isHomePage'";
				
				// Insert new filename unless bypassed
				if(!$bypassUpload) $query .= ", filename = '$newFilename'";
				
				// Insert new price if has price
				if($hasPrice) $query .= ", price = '$newPrice'";	

				// Insert new buyer if has buyer
				if($hasBuyer) $query .= ", buyerID = '$newBuyer'";	
				
				// Insert new buyer if has buyer
				if($hasGrouping) $query .= ", grouping = '$newGrouping'";	
				
				// WHERE clause
				$query .= " WHERE imgID = $artworkID;";
			} else {
				// Insert Query, filename is required
				$query = "INSERT INTO imageData (title, media, yearCreated, filename, arrangement, isHomePage";
				if($hasPrice) $query .= ", price";
				if($hasBuyer) $query .= ", buyerID";
				if($hasGrouping) $query .= ", grouping";
				$query .= ") VALUES ('$newTitle', '$newMedium', '$newYear', '$newFilename', '$newArrangement', '$isHomePage'";
				if($hasPrice) $query .= ", '$newPrice'";
				if($hasBuyer) $query .= ", '$newBuyer'";
				if($hasGrouping) $query .= ", '$newGrouping'";
				$query .= ");";
				
			}
			$queryResult = mysqli_query($db, $query);
			if(!$queryResult) {
				die("Update Error. Unable to access the database." . mysqli_error($db));
			} else {
				?>
				<table align="center">
					<tr>
						<td>Artwork <?php echo $isNew ? "Inserted" : "Updated"; ?> Successfully!</td>
					</tr>
				</table>										
			<?php
				if($hasPrice && is_numeric($newPrice)) {
					$newPrice = "$$newPrice";
					$newTitle = str_replace("\'", "'", $newTitle);
					$newMedium = str_replace("\'", "'", $newMedium);
				}
				// Only show image if uploaded
				if($bypassUpload) $newFilename = $_POST['oldfilename'];
				?><table align="center"><tr><td><?php
				print "<img class='img-responsive center-it thumbnail' src='./img/$newFilename' alt='Image Loading Error'>";
				print "<p>$newTitle, $newYear</br>$newMedium</br>";
				if($hasPrice)
					echo "$newPrice";
				if($hasBuyer) {
					$nameResult = selectQuery($db, "c_name,c_lastname", "contacts", "c_id = $newBuyer", "1");
					if($nameResult) {
						$names = mysqli_fetch_array($nameResult);
						echo (count($names) > 1) ? "</br>(Purchased by $names[0] $names[1])" : "</br>(Purchased by $names[0])";
					}					
				}
				if($hasGrouping) {
					echo "</br>Grouping: $newGrouping";
				}
				echo "</p>";
				?></td></tr></table><?php
			}
		} else {
			print_r($errors);
		}
	} elseif(isset($_POST['submitdeletion'])) {
		// ===========================================================
		// ========================= DELETE ==========================
		// ===========================================================
		$artworkID = $_POST['artworkid'];
		$title = $_POST['oldtitle'];
		
		// Query for deletion
		$deletionQuery = "DELETE FROM imageData WHERE imgID = '$artworkID';";
		
		// Delete Work
		$deleteWork = mysqli_query($db, $deletionQuery);
		
		// Tell user what happened
		if(!$deleteWork)
			die("Deletion Failed. Try again or contact label people");
		else {
		?>
			<table align="center">
				<tr>
					<td>Deleted<?php echo " <em>$title</em>"; ?> Successfully!</td>
				</tr>
			</table>	
		<?php
		}
	}
}
?>