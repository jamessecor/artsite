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
	<script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
	<nav class="navbar navbar-dark sticky-top navbar-expand-lg">
		<a class="navbar-brand" href="../index.php">James Secor</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-art" aria-controls="navbar-art" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>		
		<div class="collapse navbar-collapse" id="navbar-art">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item dropdown <?php echo strpos($_SERVER['REQUEST_URI'], 'images') ? "active" : ""; ?>">
				<a class="nav-link dropdown-toggle" href="#" id="navbarImagesDropdownLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					images
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarImagesDropdownLink">
					<a class="dropdown-item" href="../availableWorks.php">available works</a>
					<a class="dropdown-item" href="../imagesAnimalMugDishGlass.php">mug.dish.glass</a>					
					<a class="dropdown-item" href="../imagesNomophobia.php">#nomophobia</a>
					<a class="dropdown-item" href="../imagesAsNotSeen.php">As Not Seen</a>
					<a class="dropdown-item" href="../imagesDigitallyEdited.php">Digital Edits</a>						
					<a class="dropdown-item" href="../images2021.php">2021</a>
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
			<li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'cv') ? "active" : ""; ?>"><a class="nav-link" href="../cv.php">cv</a></li>
			<li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'store') ? "active" : ""; ?>"><a class="nav-link" href="../store.php">store</a></li>
			<li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'contact') ? "active" : ""; ?>"><a class="nav-link" href="../contact.php">contact</a></li>
			<li class="nav-item dropdown <?php echo strpos($_SERVER['REQUEST_URI'], 'morecontent') ? "active" : ""; ?>">
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
		<ul class="nav navbar-nav navbar-right d-flex align-items-center">
			<li class="nav-item">
				James Secor &copy; 2021
			</li>
			<li class="nav-item">
				<a href="https://www.instagram.com/jamessecor/" class="nav-link instagram-icon">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
						<path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
					</svg>
				</a>
			</li>
		</ul>
		</div>
	</nav>

