<?php
// Landing PAGE

include "header.php";
include "./imagesTemplate.php";
?>

<div class='container'>
	<div id="colors">
		<?php 
		$rowCount = 20;
		for($i = 0; $i < $rowCount; $i++) { ?>
			<div class="row colors-row" id="colors-row-<?php echo $i; ?>">
				<?php for($j = 0; $j < 12; $j++) { ?>
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
var colorsInterval;
var timesThruColors = 0;
var idToPause = "colors-col-3-3";
$(document).ready(function() {	
	$("#images-main").css("display","none");	
	$("#help-me-thru").css("display","none");
	var rowHeight = $(".colors-col").css("width");
	$(".navbar").css("margin","0");
	$("#colors").children().css("height",rowHeight);
	colors();
	colorsInterval = setInterval(colors,1500);
});

// Go to images
$(".colors-col").each(function() {
	if($(this).attr("id") != idToPause) {
		$(this).on("click",function() {
			clearInterval(colorsInterval);
			$("#colors").css("display","none");
			$("#images-main").css("display","");
		});
	}
});

$("#help-me-thru").on("click",function() {
	clearInterval(colorsInterval);
	$("#colors").css("display","none");
	$(this).css("display","none");
	$("#images-main").css("display","");
});

// Pause Everything
$("#" + idToPause).on("click",function() {
	if(colorsInterval == null) {
		colorsInterval = setInterval(colors,1500);
	} else {
		clearInterval(colorsInterval);
		colorsInterval = null;
	}
});

function colors() {
	var coords = [];
	var transparency;
	for(var i = 0; i < parseInt(<?php echo $rowCount; ?>); i++) {		
		for(var j = 0; j < 12; j++) {			
			if(Math.random() * 10 < 2) {
				coords.push(i + "-" + j);
			} else {
				$("#colors-col-" + i + "-" + j).css("display","").fadeOut(7000);			
			}
		}
	}
	coords.forEach(thisCircle => {
		transparency = Math.round(Math.random() * 2) ? Math.random() : "0";
		var r = Math.round(Math.random() * 255);
		var g = Math.round(Math.random() * 255);
		var b = Math.round(Math.random() * 255);
		var rgb = "rgb(" + r + "," + g + "," + b + ")";
		$("#colors-col-" + thisCircle).css("background-color",rgb);			
		$("#colors-col-" + thisCircle).fadeIn(5000);
	});
	
	timesThruColors++;
	if(timesThruColors == 2) {
		$("#help-me-thru").fadeIn(1000);
	}
}
</script>
<?php
include "footer.php";
?>