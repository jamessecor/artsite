<?php
include "header.php";
?>
<script>
	$(document).ready(function() {
		$(".cv-items").each(function() {
			$(this).hide();			
		});

		$(".cv-headers").each(function() {
			$(this).on("click",function() {
				var group_id = $(this).attr('id');
				var items_id = group_id.substring(0,group_id.indexOf("-"));
				var group_html = $("#" + group_id).html();
				
				// Toggle Items
				$("#" + items_id).fadeToggle();

				// Switch Arrows
				if(group_html.indexOf("▶") > -1) {
					group_html = group_html.replace("▶","▼");
				} else {
					group_html = group_html.replace("▼","▶");					
				}
				$("#" + group_id).html(group_html);
			});			
		});
	});
</script>
<div class="spacer-row"></div>
<div class="row">
	<div class="col-10 offset-1" id='success'>
		<div class="cv-text">
			<div class="cv-headers" id="solo-header">
				<p>&#x25B6; Solo Exhibitions</p>
			</div>
			<div class="cv-items" id="solo">
				<p>
					<span class="show-titles">Peanut Butter Garlic Toast</span> <a href="https://www.morseblockdeli.com/" class="press-links" target="blank">Morse Block Deli</a> - Barre, VT Dec 2019-Sept 2020				
					<br><span class="show-titles">animal mug, dish, and glass, etc</span> <a href="https://www.norwichlibrary.org/nplexhibits/" class="press-links" target="blank">Norwich Public Library</a> - Norwich, VT Dec 2019-
					<br><span class="show-titles">As Not Seen</span> <a href="https://cal-vt.org/" class="press-links" target="blank">Center for Arts and Learning</a> - Montpelier, VT Dec 2018-Jan 2019
					<br><span class="show-titles">Driving Up a Chimney</span> Brown Library - Craftsbury, VT, Nov 2018-Jan 2019
					<br><span class="show-titles">As Not Seen</span> Art Hop (Site 43) - Burlington, VT Sept 2018
					<br><span class="show-titles">Untitled</span> <a href="https://www.aldrichpubliclibrary.org/" class="press-links" target="blank">Aldrich Public Library</a> - Barre, VT, April 2018-
					<br><span class="show-titles">#nomophobia</span> <a href="https://studioplacearts.com/" class="press-links" target="blank">Studio Place Arts</a> - Barre, VT, Mar-Apr 2017
					<br><span class="show-titles">In the Cracks</span> The Blinking Light Gallery - Plainfield, VT, Jan-Feb 2017
					<br><span class="show-titles">Untitled</span> <a href="http://dailyplanetvt.com/" class="press-links" target="blank">The Daily Planet</a> - Burlington, VT, Nov 2016-Jan 2017
					<br><span class="show-titles">Local Scenery</span> <a href="https://www.greensborofreelibrary.org/" class="press-links" target="blank">Greensboro Free Library</a> - Greensboro, VT. March-May 2016
					<br><span class="show-titles">Recent Work</span> Skinny Pancake - Montpelier, VT, 2013
					<br><span class="show-titles">Senegal-France-Syracuse</span> Westcott Art Gallery - Syracuse, NY, 2011
				</p>
			</div>
			<div class="cv-headers" id="group-header">	
				<p>&#x25B6; Selected Group Exhibitions</p>
			</div>
			<div class="cv-items" id="group">
				<p>
					<span class="show-titles">Screen Time</span> River Arts, Morrisville VT, Nov 2020-Jan 2021
					<br><span class="show-titles">Futures</span> Studio Place Arts, Barre, VT, 2020
					<br><span class="show-titles">Contemporary American Regionalism: Vermont Perspectives</span> Southern Vermont Art Center, Manchester, VT, 2019
					<br><span class="show-titles">Summer Juried Show</span> T.W. Wood Gallery, Montpelier, VT, 2017
					<br><span class="show-titles">Encountering Yellow</span> Studio Place Arts, Barre, VT, 2016
					<br><span class="show-titles">Ongoing Member Shows</span> The Front, Montpelier, VT, 2015-2017
					<br><span class="show-titles">CELEBRATE!</span> Studio Place Arts, Barre, VT, 2015 &amp; 2016
					<br><span class="show-titles">The Montpelier Project</span> City Center, Montpelier, VT, 2015
					<br><span class="show-titles">HeArt &amp; Home: Celebrating Inclusive Neighborhoods for Fair Housing Month</span>  North End Studios, Burlington, VT, 2015
					<br><span class="show-titles">GallerySIX Group Show</span>  Montpelier, VT, 2015
					<br><span class="show-titles">Art Resource Association Group Shows</span>  Montpelier, VT, 2012-2013
					<br><span class="show-titles">20-30, 2D-3D</span>  Chandler Center for the Arts Gallery, Randolph, VT, 2013
					<br><span class="show-titles">Senior Show</span>  Houghton House, Geneva, NY, 2010
				</p>
			</div>	
			<div class="cv-headers" id="residency-header">		
				<p>&#x25B6; Residency Participation</p>
			</div>
			<div class="cv-items" id="residency">
				<p>
					VT Artists Week, Vermont Studio Center, Johnson, VT, 2018 
				</p>
			</div>
			<div class="cv-headers" id="ed-header">
				<p>&#x25B6; Education</p>	
			</div>
			<div class="cv-items" id="ed">
				<p>
					Hobart and William Smith Colleges, Geneva, NY - Honors project and Minor in Studio Art, 2010
				</p>
			</div>
			<div class="cv-headers" id="press-header">
				<p>&#x25B6; Press</p>			
			</div>
			<div class="cv-items" id="press">
				<p>
					<a class="press-links" href="./press/as-not-seen.pdf" target="_blank">&nbsp;As Not Seen: Review&nbsp;</a>
					<br/><a class="press-links" href="./press/artistToWatch.jpg" target="_blank">&nbsp;Artist to Watch, Vermont Art Guide #3&nbsp;</a>
					<br/><a class="press-links" href="./press/companions.jpg" target="_blank">&nbsp;Companions, Vermont Art Guide #3&nbsp;</a>
					<br/><a class="press-links" href="./press/7_best_2017__7Days.pdf" target="_blank">&nbsp;Our Seven Favorite Vermont Art Shows of 2017&nbsp;</a>
					<br/><a class="press-links" href="./press/nomophobia_MegBrazill.pdf" target="_blank">&nbsp;Art Review: James Secor, Studio Place Arts&nbsp;</a>			
				</p>
			</div>
			<div class="cv-headers" id="links-header">			
				<p>&#x25B6; Links</p>			
			</div>
			<div class="cv-items" id="links">			
				<p>
					<a class="press-links" href="https://shop.kasinihouseartshop.com/product/vermont-art-guide-3" target="_blank">&nbsp;Where to get your own Vermont Art Guide&nbsp;</a>
					<br/><a class="press-links" href="https://janicemorganauthor.com/suspended-sentence/portraits/" target="_blank">&nbsp;Suspended Sentence by author Janice Morgan&nbsp;</a>
				</p>
			</div>
		</div>
	</div>
	&nbsp;
</div>
<?php
include "footer.php";
?>