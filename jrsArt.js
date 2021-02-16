var numOfCircles = 0;
function move() {
	$("#pourcentage").html("");							
	$("#cent-pourcent").css("display","");
	$("#cicle-loader").css("display","none");
	var fullBar;
	var moreContent;	
	var firstLoop = true;
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
					moreContent = setInterval(function() {						
						if(firstLoop) {
							$("#cent-pourcent").css("display","none");						
							$("#circle-loader-" + numOfCircles).css("display","");
							numOfCircles++;						
						}
						else {
							firstLoop = true;
							elem.style.width = width + "%";						
							$("#pourcentage-chiffre").html("Load More Content Now");
							$("#cent-pourcent").css("display","");
							clearInterval(moreContent);
						}														
						firstLoop = false;
					}, 1500); // 1500
				}, 250);
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