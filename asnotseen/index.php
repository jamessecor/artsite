<?php
// Landing PAGE

include "./header.php";
//include "../imagesTemplate.php";
?>
<script src='../jrsArt.js'></script>
<script language="JavaScript">

// recursive function to get the next 
function animateBox(index, color) {
	var rowId = "#row" + index;
	// Style and show next box
	if(index > 0) {
		

		
	}
	var wordsId = "#words" + index;		
	$(rowId).css("display", "block").css("background-color", color); // Very different with "inline-block"
	$(wordsId).css("font-size", "5em");// height:2em; color:blue;
	$(wordsId).click(function() {
		$(this).animate({
			opacity: 0.25,
			left: "+=50",
			height: "toggle"
		}, 1000, function() {
			//$(".navbar.navbar-default").css("background-color", "red");
			if(index < Math.floor(Math.random() * 20)) {
				// get the new background-color
				var currentBorderCss = $(rowId).css("border");			
				var newBackgroundColor = currentBorderCss.substring(currentBorderCss.indexOf("rgb"));			
				animateBox(index + 1, newBackgroundColor);
			} else {
				if(confirm("You've won!!! Want to see your prize? Click cancel to continue buying.")) {
					$(".winner-images").animate({
						display:"inline",
						opacity: 0.25,
						left: "+=50",
						height: "toggle"
					}, 100, function() {
						//$(this).css("display", "inline");
					});
				} else {
					animateBox(index + 1, newBackgroundColor);
				}				
			}
		});
	});
}
// End recursive function
// Begin navbar changes
function transitionNavbar() {
    $(".navbar.navbar-default").css("background-color", "rgb(" + (Math.random() * 50 + 200) + "," + Math.random() * 30 + "," + (Math.random() * 40 + 100) + ")");
}
// end navbar changes


$(document).ready(function() {
	$(".navbar").css("margin-bottom", "0").css("border", "none");
	
	// Hide winner-images
	$(".winner-images").css("display", "none");
	
	// Navbar color change
	setInterval(transitionNavbar, 400);

	$("div.row.flashingRow").each(function(index) {
		var colors = [ Math.floor(Math.random() * 255),Math.floor(Math.random() * 255),Math.floor(Math.random() * 255),Math.random() ];
		var borderCss = "rgb(" + colors[0] + "," + colors[1] + "," + colors[2] + ")";
		$(this).css("display", "none").css("border-width", "2em 4em").css("border-style", "solid").css("border-color", borderCss);
	});
	
	this.very = false;
	$(".storageImg").click(function() {
		onOff();
	});
	
	
	// Call recursive function
	animateBox(0, "#aaf");

	
	function onOff() {
		var counter = 5;
		while(counter > 0) {
			if(this.very) {
				$(".flash").html("GO TI");
				this.very = false;
			} else {
				$(".flash").html("OG IT");
				this.very = true;
			}
			counter = counter - 1;
		}
	}
})

</script>
<!--<div class='container'>-->
	<?php 
	// Create Objects to buy
	for($i = 0; $i < 50; $i++) {
	?>
	<div id="row<?php echo $i; ?>" height="5em" class="row flashingRow">
		<div id="words<?php echo $i; ?>" align="center">[Click to Buy]</div>
	</div>
	<?php
	}
	?>	
	<div class="row">
		<div class="col-md">
			<?php 
			$imageSrc = "../../img/mcD.jpg";
			for($i = 0; $i < 30; $i++){
				echo "<img class=\"winner-images\" style=\"width:20%; position:absolute; top:${i}em; right:${i}em\" src=\"$imageSrc\" alt=\"Buy NOW!\">";
			}
			?>
			<img style="width:100%; position:fixed; top:7em; right:0; z-index:-1;" src="<?php echo $imageSrc; ?>" alt="nope">
			
			
		</div>		
	</div>
<!--</div>-->

<?php
include "../footer.php";
?>