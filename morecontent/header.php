<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>James Secor</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	
	<link href="../jrsArt.css" rel="stylesheet">
	<!-- jQuery Modal -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
	<script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body onload='load()'>
<nav class="navbar navbar-dark navbar-expand-lg">
		<a class="navbar-brand" href="../index.php">James Secor</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-art" aria-controls="navbar-art" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>		
		<div class="collapse navbar-collapse" id="navbar-art">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item dropdown <?php echo $_SESSION['activetab'] == 'images' ? "active" : ""; ?>">
				<a class="nav-link dropdown-toggle" href="#" id="navbarImagesDropdownLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					images
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarImagesDropdownLink">
					<a class="dropdown-item" href="../availableWorks.php">available works</a>
					<a class="dropdown-item" href="../imagesAnimalMugDishGlass.php">mug.dish.glass</a>					
					<a class="dropdown-item" href="../imagesNomophobia.php">#nomophobia</a>
					<a class="dropdown-item" href="../imagesAsNotSeen.php">As Not Seen</a>
					<a class="dropdown-item" href="../imagesDigitallyEdited.php">Digital Edits</a>						
					<a class="dropdown-item" href="../../images2021.php">2021</a>
					<a class="dropdown-item" href="../images2020.php">2020</a>
					<a class="dropdown-item" href="../images2019.php">2019</a>
					<a class="dropdown-item" href="../images2018.php">2018</a>
					<a class="dropdown-item" href="../images2017.php">2017</a>
					<a class="dropdown-item" href="../images2016.php">2016</a>
					<a class="dropdown-item" href="../images2015.php">2015</a>
					<a class="dropdown-item" href="../images2014.php">2014</a>						
					<a class="dropdown-item" href="../images2013.php">2013</a>						
				</div>
			</li>
			<li class="nav-item <?php echo $_SESSION['activetab'] == 'cv' ? "active" : ""; ?>"><a class="nav-link" href="../cv.php">cv</a></li>
			<li class="nav-item <?php echo $_SESSION['activetab'] == 'store' ? "active" : ""; ?>"><a class="nav-link" href="../store.php">store</a></li>
			<li class="nav-item <?php echo $_SESSION['activetab'] == 'contact' ? "active" : ""; ?>"><a class="nav-link" href="../contact.php">contact</a></li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarMoreDropdownLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					more
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarMoreDropdownLink">
					<a class="dropdown-item" href="../morecontent/index.php">content</a>
					<a class="dropdown-item" href="../morecontent/dots.php">dots</a>
					<a class="dropdown-item" href="../morecontent/asnotseen.php">As Not Seen</a>
					<a class="dropdown-item" href="http://jamessecor.com/nomophobia" target="_blank"><em>#nomophobia site</em></a>
				</div>				
			</li>
			<?php 
			include "../checkLogin.php";
			if(isLoggedIn()) { ?>
				<li class="nav-item"><a href="../admin.php"><em>Admin</em></a></li>
			<?php } ?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="navbar-text">James Secor &copy; 2021</li>
		</ul>
		</div>
	</nav>




