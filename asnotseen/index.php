<?php
// Landing PAGE

include "./header.php";
//include "../imagesTemplate.php";
?>
<script src='../jrsArt.js'></script>
<script language="JavaScript">
// Initialize balance for balance-amt in navbar
var balance = 0;
var receivedDebtMsg = false;

// List of nouns
var nouns = [ "antique china set", "croquet set", "old tv", "new tv", "golf stuff", "orange gatorade (50 pk)", "wood stove", "coffee table", "grandma's bedframe", "tea set", "ice skates", "beer-making kit", "bureau", "old lamps", "toolkit", "set of wrenches", "speakers" ];

// recursive function to get the next 
function animateBox(index, color) {
	var rowId = "#row" + index;
	var wordsId = "#words" + index;		
	var itemTextId = "#item-text" + index;
	var valueTextId = "#value-text" + index;
	$(rowId).css("display", "block").css("background-color", color); // Very different with "inline-block"
	var randomAmt = Math.ceil(Math.random() * 1000);
	$(itemTextId).html("Item " + (index + 1) + ": " + nouns[Math.floor(Math.random() * nouns.length)]);
	$(valueTextId).html("ONLY $" + randomAmt + "!");
	
	//=============================
	// 			Add To Unit
	// =============================
	$("#add-to-unit" + index).click(function() {
		balance = balance - randomAmt;
		if(balance < 0 && !receivedDebtMsg) {
			$("#balance-amt").css("border", "3px dotted #ff0")
			if(!confirm("Uh Oh! You're in debt. Continue Buying?")) {
				return 0;
			}
			receivedDebtMsg = true;
		} else if(balance < -2000) {
			
		}
		$("#balance-amt").html("Your Balance $" + balance);
		
		$(wordsId).animate({
			opacity: 0.25,
			left: "+=50",
			height: "toggle"
		}, 1000, function() {
			//$(".navbar.navbar-default").css("background-color", "red");
			if(index < Math.floor(Math.random() * 20)) {
			//if(false) {  // Debugging
				// get the new background-color
				var currentBorderCss = $(rowId).css("border-color");			
				var newBackgroundColor = currentBorderCss.substring(currentBorderCss.indexOf("rgb"));			
				console.log(newBackgroundColor);
				animateBox(index + 1, "");
			} else {
				if(confirm("You've won!!! Want to see your prize? Click cancel to continue buying.")) {
					$(".winner-images").animate({
						display:"inline",
						opacity: 0.25,
						left: "+=50",
						height: "toggle"
					}, 100, function() {
						$("#winner-msg").html("Congratulations! All your storage units are now full! You win.<br><a href=\"https://www.google.com/search?q=storage+units+near+me\" target=\"_blank\">Find Nearby Storage for My Stuff.</a>").css("display", "inline");
					});
				} else {
					animateBox(index + 1, newBackgroundColor);
				}				
			}
		});		
	});
	
	// =============================
	// 			Trash It
	// =============================
	$("#trash-it" + index).click(function() {
		$(wordsId).animate({
			opacity: 0.25,
			left: "+=50",
			height: "toggle"
		}, 1000, function() {
			animateBox(index + 1, "");
		});
	});
}
// End recursive function

// navbar color shifts
function transitionNavbar() {
    $(".navbar.navbar-default").css("background-color", "rgb(" + (Math.random() * 50 + 200) + "," + Math.random() * 30 + "," + (Math.random() * 40 + 100) + ")");
}

// ====================
// Document ready BEGIN
// ====================
$(document).ready(function() {	
	balance = 1000;
	$("#balance-amt").html("Your Balance $" + balance).css("border", "3px dotted #4e9").css("padding", "0 10px");
	$(".navbar").css("margin-bottom", "0").css("border", "none");

	// Hide winner-images
	$(".winner-images").css("display", "none");
	$("#winner-msg").css("display", "none");
	
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
	<div id="balance-bar">
		<span id="balance-amt"></span>
	</div>
	<?php 
	// Create Objects to buy
	for($i = 0; $i < 50; $i++) {
	?>
	<div id="row<?php echo $i; ?>" height="5em" class="row flashingRow">
		<div id="words<?php echo $i; ?>" align="center">
			<div class="sale-text" id="item-text<?php echo $i; ?>"></div>
			<div class="sale-text" id="value-text<?php echo $i; ?>"></div>		
			<button class="decision-buttons" id="add-to-unit<?php echo $i; ?>">Add to Storage Unit</button>
			<button class="decision-buttons" id="trash-it<?php echo $i; ?>">Trash It</button>
		</div>
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
			<div id="winner-msg"></div>
		</div>		
	</div>
<!--</div>-->

<?php
include "../footer.php";
?>