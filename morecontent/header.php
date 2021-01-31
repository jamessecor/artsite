<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>James Secor</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="../jrsArt.css" rel="stylesheet">
	<script>
	$(document).ready(function(){
		$("#imgNav").hover(function(){
			$(".imgSubnav").toggle();
		});
	});
	</script>
</head>
<body onload='load()'>
	<div id="wrapper">

	<nav class="navbar navbar-fixed-top navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type = "button" id="tbut" class = "navbar-toggle" 
			         data-toggle = "collapse" data-target = "#navbar-art">
			         <span class = "sr-only">Toggle navigation</span>
			         <span class = "icon-bar"></span>
			         <span class = "icon-bar"></span>
			         <span class = "icon-bar"></span>
			      </button>
			  <a class="navbar-brand" href="../index.php">James Secor</a>
			</div>
			<div class="navbar-collapse collapse" id="navbar-art">
			<ul class="nav navbar-nav">
				<li>
					<a class='dropdown-toggle' data-toggle="dropdown"><strong>images
					<span class="caret"></span></strong></a>
					<ul class="dropdown-menu">
						<li><a href="../availableWorks.php"><strong>available works</strong></a></li>
						<li><a href="../imagesAnimalMugDishGlass.php"><strong>mug.dish.glass</strong></a></li>
						<li><a href="../imagesNomophobia.php"><strong>#nomophobia</strong></a></li>
						<li><a href="../imagesAsNotSeen.php"><strong>As Not Seen</strong></a></li>
						<li><a href="../imagesDigitallyEdited.php"><strong>Digital Edits</strong></a></li>						
						<li><a href="../images2021.php"><strong>2021</strong></a></li>
						<li><a href="../images2020.php"><strong>2020</strong></a></li>
						<li><a href="../images2019.php"><strong>2019</strong></a></li>
						<li><a href="../images2018.php"><strong>2018</strong></a></li>
						<li><a href="../images2017.php"><strong>2017</strong></a></li>
						<li><a href="../images2016.php"><strong>2016</strong></a></li>
						<li><a href="../images2015.php"><strong>2015</strong></a></li>
						<li><a href="../images2014.php"><strong>2014</strong></a></li>						
						<li><a href="../images2013.php"><strong>2013</strong></a></li>						
					</ul>
				</li>
				<li><a  href="../cv.php"><strong>cv</strong></a></li>
				<li><a href="../store.php"><strong>store</strong></a></li>
				<li><a href="../contact.php"><strong>contact</strong></a></li>				
				<li>
					<a class='dropdown-toggle' data-toggle="dropdown"><strong>more
					<span class="caret"></span></strong></a>
					<ul class="dropdown-menu">
						<li><a href="./index.php"><strong>content</strong></a></li>
						<li><a href="./dots.php"><strong>dots</strong></a></li>
						<li><a href="./asnotseen.php"><strong>As Not Seen</strong></a></li>
						<li><a href="http://jamessecor.com/nomophobia" target="_blank"><em><strong>#nomophobia site</strong></em></a></li>
					</ul>				
				</li>
				<?php 
				session_start();
				include "../checkLogin.php";
				if(isLoggedIn()) { ?>
					<li><a href="../admin.php"><em><strong>Admin</strong></em></a></li>
				<?php } ?>
			</ul>
			<ul class="nav navbar-nav navbar-right">				
				<li class="navbar-text">James Secor &copy; 2020</li>
			</ul>
			</div>
		</div>
	</nav>


