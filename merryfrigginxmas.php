<?php
// Landing PAGE

include "header.php";
?>
<script src='./jrsArt.js'></script>
<script>

$(document).ready(function() {
	$("#success").css("background-color", "green")
		.css("color", "#a00")
		.css("font-weight","bold");
	
	$("#link-button").css("border", ".1em solid red")
		.css("border-radius", ".2em")
		.css("font-weight", "bold")
		.css("text-decoration", "none")
		.css("background-color", "#f00")
		.css("color", "#0f0");
	
	$("#link-button").hover(
		function() {
			$(this).css("background-color","black");
		}, function() {
			$(this).css("background-color", "red");
		}
	);
		
	setInterval(function() {
        $("#success").css("background-color", "green");
    }, 1000);	
	
});

</script>
<div class="container" style="width:100%;">
<div class="row">
	<div class="col-md-11">
		<div id="success" class="xmas-box cv-text center-it" style="font-size:2em;">
			Hi Kevin &amp; Betsy.
			<br>
			<h1>&iexcl;&iexcl;&iexcl;&iexcl;&iexcl;&iexcl;&iexcl;Merry Christmas!!!!!!!</h1>
			<iframe src="https://giphy.com/embed/C9o0hV1zdqHwQ" width="100%" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
			<br>
			Don't look so grumpy.
			<br>
			Get ready for a serious adventure. 
			<br>
			<a id="link-button" href="https://stonecutterspirits.com/adventure-dinner">Click here to see what's in store for you.</a>
		</div>
	</div>
</div>
</div>
<?php
include "footer.php";
?>