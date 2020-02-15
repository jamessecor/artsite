<!doctype html>
<html lang="en">
<?php 
session_start();
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>James Secor</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="jrsArt.css" rel="stylesheet">
	<!-- jQuery Modal -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
	<script src="https://www.google.com/recaptcha/api.js"></script>
</head>
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
<body>
	<div id="left-col" class="col-md-1 side-cols"></div>
	<div id="right-col" class="col-md-1 side-cols"></div>
	<div id="wrapper">

	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type = "button" id="tbut" class = "navbar-toggle" 
			         data-toggle = "collapse" data-target = "#navbar-art">
			         <span class = "sr-only">Toggle navigation</span>
			         <span class = "icon-bar"></span>
			         <span class = "icon-bar"></span>
			         <span class = "icon-bar"></span>
			      </button>
			  <a class="navbar-brand" href="./index.php">James Secor</a>
			</div>
			<div class="navbar-collapse collapse" id="navbar-art">
			<ul class="nav navbar-nav">
				<li>
					<a class='dropdown-toggle' data-toggle="dropdown"><strong>images
					<span class="caret"></span></strong></a>
					<ul class="dropdown-menu">
						<li><a href="images2019.php"><strong>2019</strong></a></li>
						<li><a href="images2018.php"><strong>2018</strong></a></li>
						<li><a href="images2017.php"><strong>2017</strong></a></li>
						<li><a href="images2016.php"><strong>2016</strong></a></li>
						<li><a href="images2015.php"><strong>2015</strong></a></li>
						<li><a href="images2014.php"><strong>2014</strong></a></li>						
						<li><a href="images2013.php"><strong>2013</strong></a></li>						
						<li><a href="imagesAnimalMugDishGlass.php"><strong>mug.dish.glass</strong></a></li>
						<li><a href="imagesNomophobia.php"><strong>#nomophobia</strong></a></li>
						<li><a href="imagesAsNotSeen.php"><strong>As Not Seen</strong></a></li>
						<li><a href="imagesDigitallyEdited.php"><strong>Digital Edits</strong></a></li>						
					</ul>
				</li>
				<li <?php if(strpos($_SERVER['REQUEST_URI'], '/cv.php')) echo "class='active'";?>>
					<a  href="./cv.php"><strong>cv</strong></a>
				</li>
				<li <?php if(strpos($_SERVER['REQUEST_URI'], '/contact.php')) echo "class='active'";?> >
					<a href="./contact.php"><strong>contact</strong></a>
				</li>
				<li>
					<a href="http://jamessecor.com/nomophobia" target="_blank"><em><strong>#nomophobia site</strong></em></a>
				</li>
				<li>
					<a href="./asnotseen/index.php"><em><strong>As Not Seen</strong></em></a>
				</li>
				<li>
					<a href="./morecontent/index.php"><strong>more</strong></a>
				</li>
				<?php 
				include "checkLogin.php";
				if(isLoggedIn()) { ?>
				<li>
					<a href="./admin.php"><em><strong>Admin</strong></em></a>
				</li>
				<?php } ?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="navbar-text">James Secor &copy; 2017</li>
			</ul>
			</div>
		</div>
	</nav>


