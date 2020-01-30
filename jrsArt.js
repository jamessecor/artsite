function move() {
	$("#pourcentage").html("");							
	var fullBar;
	var moreContent;
	var flashes = 0;
	var textIsOn = true;
	var i = 0;
	var id;
	var id2;
	var id3;
	var stall = (Math.random() * 25);
	stall = Math.round(stall);
	var stallCnt = (Math.random() * 10);
	stallCnt = Math.round(stallCnt);
	if (i == 0) {
		i = 1;
		var elem = document.getElementById("pourcentage");
		var width = 0;
		id = setInterval(frame, 50);
		function frame() {
			clearTimeout(fullBar);				
			clearInterval(moreContent);				
			if (width >= 100) {
				clearInterval(id);
				clearInterval(id2);
				clearInterval(id3);
				i = 0;				
				$("#pourcentage-chiffre").html(width + "% Complete");
				fullBar = setTimeout(function() {
					width = 0;					
					$("#pourcentage").html("Content Here Now");									
					moreContent = setInterval(function() {						
						flashes++;						
						if(textIsOn) {
							$("#pourcentage").html("");									
							textIsOn = false;
							if(flashes >= 6) {
								elem.style.width = width + "%";						
								$("#pourcentage-chiffre").html("Load Now");
								clearInterval(moreContent);
							}
						} else {
							$("#pourcentage").html("Content Here Now");									
							textIsOn = true;
						}						
					}, 500);
				}, 1500);
			} else {
				width++;
				if(width == stall) {
					clearInterval(id);					
					id2 = setInterval(frame, 1111); //1111
				} else if(width == stall + stallCnt) {
					clearInterval(id2);
					id3 = setInterval(frame, 10);
				}
				elem.style.width = width + "%";
				$("#pourcentage-chiffre").html(width + "% Complete");
			}
		}
	}
}

function load() {
	// Next Button
	document.getElementById('nextImg').addEventListener("click", function() {
		nextImg();
	})
	
	// Previous Button
	document.getElementById('prevImg').addEventListener("click", function() {
		prevImg();
	})
}

// Images and image labels
var images = document.getElementsByClassName('imgs');
var labels = 
	[
	'<em>Intersection</em>, 2016<br>acrylic on board', 
	'<em>Morse Block</em>, 2015<br>acrylic on board', 
	'<em>Trademore Shopping Center</em>, 2017<br>mixed media on paper', 
	'<em>Morehead, KY</em>, 2015<br>acrylic on canvas', 
	'<em>Trees on the North Branch</em>, 2016<br>acrylic on board', 
	'<em>Companion Objects</em>, 2016<br>mixed media on paper', 
	'<em>I Have a Cat, You Have a Cat, We All Have Cats</em>, 2016<br>mixed media on paper', 
	'<em>Watching by the River</em>, 2015<br>acrylic on paper', 
	'<em>Mobile</em>, 2016<br>acrylic on paper', 
	'<em>Mystery Cow</em>, 2015<br>mixed media on canvas', 
	'<em>Worthen Block</em>, 2016<br>acrylic on canvas'
	];

	// TODO: Instead of recreating all of this, make a class
	// Something like the following ???
class imagePages {
	constructor(year, imageLabels) {
		
	}
}
var images2017 = document.getElementsByClassName('imgs2017');	
var labels2017 = 
	[
	'<em>Intersection</em><br>2016<br>acrylic on board', 
	'<em>Trademore Shopping Center</em><br>2017<br>mixed media on paper'
	];
	
var index = 0;

// Next Function
function nextImg() {
	images[index].style.display = 'none';
	index++;
	if(index >= images.length)
		index = 0;
	images[index].style.display = 'inline';
	document.getElementById('label').innerHTML = labels[index];
}

// Previous Function
function prevImg() {
	images[index].style.display = 'none';
	index--;
	if(index < 0)
		index = images.length - 1;
	images[index].style.display = 'inline';
	document.getElementById('label').innerHTML = labels[index];
}







/*
function loading() {
	// EventListener to heading buttons
	document.getElementById('paintingsButton').addEventListener("click", function() {
		paintings();
	}
	
	document.getElementById('contactButton').addEventListener("click", function() {
		contact();
	}
	
	document.getElementById('cvButton').addEventListener("click", function() {
		cv();
	}
}

function cv() {
	document.getElementById('cv').style.display = 'inline';
}

function activateNavbar() {
	document.getElementById('
	*/