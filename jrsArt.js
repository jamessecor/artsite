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