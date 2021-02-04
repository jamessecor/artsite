<!doctype html>
<html lang="en">
<?php 
session_start();
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>James Secor</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	
	<link href="jrsArt.css" rel="stylesheet">
	<!-- jQuery Modal -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
	<script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
	<div class="container-fluid">
	<script>
	$(document).ready(function(){
		$("#imgNav").hover(function(){
			$(".imgSubnav").toggle();
		});			
		
		// Make arrows light up when hovering
		$(".arrows").each(function() {
			var side = $(this).attr("id").split("-")[0];
			var thisElem = $(this)[0];			
			if(side === "left") {				
				$(this).hover(function() {
					$("a#real-arrow-left").css("color","#77f");					
				}, function() {
					$("a#real-arrow-left").css("color","rgba(30,30,70,.2)"); 		
				});			
			} else if(side === "right") {
				$(this).hover(function() {
					$("a#real-arrow-right").css("color","#77f");
				}, function() {
					$("a#real-arrow-right").css("color","rgba(30,30,70,.2)"); 		
				});			
			}			
		});

		// Make left and right arrows work for modal
		$(document).keydown(function(event) {
			var modalIsVisible = false;
			
			// Check that the modal is visible
			$(".modal").each(function() {
				if($(this).is(":visible")) {
					modalIsVisible = true;
					//console.log($(this).position());
				}
			});
			
			if(modalIsVisible) {
				// Get class modal
				var ourModalIndex = $(".modal").length - 1;
				console.log(ourModalIndex);
				
				// Get the currently active modal
				// For some reason, it's at the end
				var ourModal = $(".modal")[ourModalIndex];
				console.log(ourModal);
				
				// Get our good buddy's id
				var ourModalId = ourModal.id;
				console.log("ourModal.id = " + ourModal.id);
				
				// Grab that number off the end
				var ourNum = ourModalId.split("-")[2];
				console.log(ourModalId.split("-")[2]);

				// Only move if not first or last
				console.log("length of modal = ");
				console.log($(".modal").length);
				if(ourNum !== 0 && ourNum !== $(".modal").length) {
						
					// Use that id to figure out what left and right do
					// Get arrows class 			
					var idToClick = "";
					console.log(event.which + "pressed");
					if(event.which == 37 || event.which == 39) {
						//console.log($(this).attr("id"));
						if(event.which == 37) {
							idToClick = "#left-arrow-" + ourNum;
						} else if(event.which == 39) {
							idToClick = "#right-arrow-" + ourNum;
						}				
						
						// Do not click if at the beginning or end to avoid errors
						var endId = "#right-arrow-" + ($(".modal").length - 1);
						if(idToClick !== "#left-arrow-0" && idToClick !== endId) {
							$(idToClick).trigger("click");
							console.log("clicking " + idToClick);
						} else {
							console.log("idToClick = " + idToClick + "...no click");
						}
					}
				}
			}
		});
		
	});
	</script>

	<nav class="navbar navbar-expand-lg">
		<a class="navbar-brand" href="./index.php">James Secor</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-art" aria-controls="navbar-art" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>		
		<div class="collapse navbar-collapse" id="navbar-art">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarImagesDropdownLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					images
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarImagesDropdownLink">
					<a class="dropdown-item" href="availableWorks.php">available works</a>
					<a class="dropdown-item" href="imagesAnimalMugDishGlass.php">mug.dish.glass</a>					
					<a class="dropdown-item" href="imagesNomophobia.php">#nomophobia</a>
					<a class="dropdown-item" href="imagesAsNotSeen.php">As Not Seen</a>
					<a class="dropdown-item" href="imagesDigitallyEdited.php">Digital Edits</a>						
					<a class="dropdown-item" href="images2021.php">2021</a>
					<a class="dropdown-item" href="images2020.php">2020</a>
					<a class="dropdown-item" href="images2019.php">2019</a>
					<a class="dropdown-item" href="images2018.php">2018</a>
					<a class="dropdown-item" href="images2017.php">2017</a>
					<a class="dropdown-item" href="images2016.php">2016</a>
					<a class="dropdown-item" href="images2015.php">2015</a>
					<a class="dropdown-item" href="images2014.php">2014</a>						
					<a class="dropdown-item" href="images2013.php">2013</a>						
				</div>
			</li>
			<li class="nav-item"><a class="nav-link" href="./cv.php">cv</a></li>
			<li class="nav-item"><a class="nav-link" href="./store.php">store</a></li>
			<li class="nav-item"><a class="nav-link" href="./contact.php">contact</a></li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarMoreDropdownLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					more
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarMoreDropdownLink">
					<a class="dropdown-item" href="./morecontent/index.php">content</a>
					<a class="dropdown-item" href="./morecontent/dots.php">dots</a>
					<a class="dropdown-item" href="./morecontent/asnotseen.php">As Not Seen</a>
					<a class="dropdown-item" href="http://jamessecor.com/nomophobia" target="_blank"><em>#nomophobia site</em></a>
				</div>				
			</li>
			<?php 
			include "checkLogin.php";
			if(isLoggedIn()) { ?>
				<li class="nav-item"><a href="./admin.php"><em>Admin</em></a></li>
			<?php } ?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="navbar-text">James Secor &copy; 2020</li>
		</ul>
		</div>
	</nav>


