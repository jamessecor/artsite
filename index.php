<?php
// Landing PAGE

include "header.php";
include "./imagesTemplate.php";
?>

<div class='container'>
	<div id="colors">
		<?php 
		$rowCount = 40;
		$colCount = 12;
		for($i = 0; $i < $rowCount; $i++) { ?>
			<div class="row colors-row" id="colors-row-<?php echo $i; ?>">
				<?php for($j = 0; $j < $colCount; $j++) { ?>
					<div class="col-xs-1 colors-col" id="colors-col-<?php echo $i . '-' . $j;?>">&nbsp;</div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
	<div id="help-me-thru">Touch/Click anywhere to proceed to paintings.</div>
	<div id="images-main">
		<?php
		displayImages(" isHomePage = true ORDER BY arrangement");
		?>
	</div>
</div>
<script src='./jrsArt.js'></script>
<script>
var intervalTime = 500;
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

// Go to images
$(".colors-col").each(function() {
	$(this).on("click",function() {
		clearInterval(colorsInterval);
		$("#colors").hide();
		$("#help-me-thru").hide();
		$("#images-main").show();
	});
});

$("#help-me-thru").on("click",function() {
	clearInterval(colorsInterval);
	$("#colors").hide();
	$(this).hide();
	$("#images-main").show();
});

function colors() {	
	var createAndAddTemp = true;
	for(var i = 0; i < parseInt(<?php echo $rowCount; ?>); i++) {		
		for(var j = 0; j < parseInt(<?php echo $colCount; ?>); j++) {			
			createAndAddTemp = true;
			if(Math.random() * 300 < 2) {
				circles.forEach(circle => {
					if(circle.id == "colors-col-" + i + "-" + j) {
						createAndAddTemp = false;
					}
				});
				if(createAndAddTemp) {
					var r = Math.round(Math.random() * 100 + 100);
					var g = Math.round(Math.random() * 100 + 100);
					var b = Math.round(Math.random() * 100 + 100);
					var tempRGB = "rgb(" + r + "," + g + "," + b + ")";
					var tempObj = {
						rgb: tempRGB,
						timeAlive: 0,
						totalTimeOnEarth: 2,
						id: "colors-col-" + i + "-" + j
					};
					$("#" + tempObj.id).css("background-color",tempObj.rgb).hide();
					$("#" + tempObj.id).fadeTo(2000, 1);
					circles.push(tempObj);
				}
			} 
		}
	}
	for(var t = 0; t < circles.length; t++) {
		circles[t].timeAlive++;
		if(circles[t].timeAlive == circles[t].totalTimeOnEarth) {
			$("#" + circles[t].id).fadeTo(2000, 0);
			circles.splice(t - 1, 1);
		}
	}

	timesThruColors++;
	if(timesThruColors == 8) {
		$("#help-me-thru").fadeIn(1000);
	} else if(timesThruColors == 15) {
		$("#help-me-thru").fadeOut(1000);
	}
}
</script>
<?php
include "footer.php";
?>