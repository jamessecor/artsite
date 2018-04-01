<?php
function uploadFile() {
	$target_dir = "./img/";
	$target_file = $target_dir . basename($_FILES["updatefilename"]["name"]);
	$uploadOk = 1;
	
	$path_parts = pathinfo($target_file);  // new line added by JDS
	//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);   original code. 
	$imageFileType = $path_parts['extension'];
	// line above was suggested in PHP manual pages online. pathinfo returns an array!		
	
	// Check if image file is a actual image or fake image		
	$tmp_file = $_FILES["updatefilename"]["tmp_name"];
	$check = getimagesize($_FILES["updatefilename"]["tmp_name"]);
	//print "Checking image size of $tmp_file. Size is $check[0]<br>";
	
	if($check !== false) {
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}
	
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "File already exists.";
		$uploadOk = 0;
	}
	
	// Check file size
	if ($_FILES["updatefilename"]["size"] > 10000000) {           // I changed this to 10 MB to accomodate hi res images. 
		echo "Your file is too large.";              // I also had to change the setting in PHP.ini for max upload size
		$uploadOk = 0;
	}

	// Allow certain file formats    // JDS: I had to change these to uppercase. 
	$imageFileType = strtoupper($imageFileType);
	if($imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG"
	&& $imageFileType != "GIF" ) {
		echo "Image File type is $imageFileType. Only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	
	// Additional Error Checking Added by Joan: 
	if ($_FILES['updatefilename']['error'] > 0) {
		$uploadOk = 0;
		switch ($_FILES['updatefilename']['error']) {
			case 1:
				echo "File exceeded upload_max_filesize";   break;  
			case 2:
				echo "File exceeded max_file_size.";     break;
			case 3: 
				echo "File ony partially uploaded.";  break;
			case 4:
				echo "No file uploaded.";  break;     
			case 6: 
				echo "No temp directory specified.";  break;
			case 7:
				echo "Upload failed. Cannot write to disk";    break;          
			case 8:
				echo "A PHP extension blocked the file upload.";   break;
		}
	}

			
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["updatefilename"]["tmp_name"], $target_file)) {
			$filename = basename($_FILES["updatefilename"]["name"]);
			$imgLocation = "./img/" . $filename;			
		} else {
			echo "There was an error uploading your file.";
		}
	}
}
?>