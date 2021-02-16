<?php
// DOTS

include "header.php";
?>

<div class='container-fluid'>
	<div id="colors">
		<?php 
		$rowCount = 20;
		$colCount = 12;
		for($i = 0; $i < $rowCount; $i++) { ?>
			<div class="row no-gutters colors-row" id="colors-row-<?php echo $i; ?>">
				<?php for($j = 0; $j < $colCount; $j++) { ?>
					<div class="col-1 colors-col" id="colors-col-<?php echo $i . '-' . $j;?>">&nbsp;</div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
	<!--<div id="help-me-thru">Touch/Click anywhere to proceed to paintings.</div>-->
</div>
<script src='./jrsArt.js'></script>
<script>
var intervalTime = 50;
var colorsInterval;
var timesThruColors = 0;
var circles = [];
$(document).ready(function() {	
	$("#images-main").hide();
	$("#help-me-thru").hide();
	$(".navbar").css("margin","0");
	var rowHeight = $(".colors-col").css("width");
	$("#colors").children().css("height",rowHeight);
	colors();
	colorsInterval = setInterval(colors,intervalTime);
});

function colors() {	
	var createAndAddTemp = true;
	for(var i = 0; i < parseInt(<?php echo $rowCount; ?>); i++) {		
		for(var j = 0; j < parseInt(<?php echo $colCount; ?>); j++) {			
			createAndAddTemp = true;
			if(Math.random() * 275 < 2) {
				circles.forEach(circle => {
					if(circle.id == "colors-col-" + i + "-" + j) {
						createAndAddTemp = false;
					}
				});
				if(createAndAddTemp) {
					var r = Math.round(Math.random() * 100 + 50);
					var g = Math.round(Math.random() * 100 + 100);
					var b = Math.round(Math.random() * 100 + 155);
					var tempRGB = "rgb(" + r + "," + g + "," + b + ")";
					var tempObj = {
						rgb: tempRGB,
						timeAlive: 0,
						totalTimeOnEarth: Math.random() * 3 + 1,
						id: "colors-col-" + i + "-" + j
					};
					$("#" + tempObj.id).css("background-color",tempObj.rgb).hide();
					$("#" + tempObj.id).fadeTo(5000, 1);
					circles.push(tempObj);
				}
			} 
		}
	}
	
	for(var t = 0; t < circles.length; t++) {
		circles[t].timeAlive++;
		if(circles[t].timeAlive >= circles[t].totalTimeOnEarth) {
			$("#" + circles[t].id).fadeTo(2500, 0, "", function() {
				circles.splice(t, 1);
			});			
		}
	}
	
	timesThruColors++;
//	if(timesThruColors == 150) {
//		$("#help-me-thru").fadeIn(1000);
//	} else if(timesThruColors == 225) {
//		$("#help-me-thru").fadeOut(1000);
//	}
}
</script>
<?php
include "../footer.php";
?>