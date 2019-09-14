<?php
include "header.php";
include "utility.php";
require "../includes/artsiteConfig.php";
require "../includes/artsiteConnect.php";

if(isset($_POST['login'])) {
	// Username
	if(!empty($_POST['artsiteusername'])) {
		$username = addslashes(trim(($_POST['artsiteusername'])));
	}
	
	// Password
	if(!empty($_POST['password'])) {
		$password = addslashes(trim(($_POST['password'])));
		/* Debugging Password Hash /
			echo $password . "<br>";
			echo password_hash($password, PASSWORD_DEFAULT);
			echo "<br>" . $adminP;
			echo "<br>";		
		//	die();
		//*/
	}	
	
	// Check them
	if($username===$adminU && password_verify($password, $adminP)) {
		$_SESSION['artsiteusername'] = $username;
	}
}
// Log out button
if(isset($_POST['logout'])) {
	logout();	
}

// Returns an array of email addresses
function getEmailAddr() {
	global $db;
	$query = "SELECT c_email FROM contacts;";
	$result = mysqli_query($db, $query);
	$emails = "";
	while($email = mysqli_fetch_array($result))
		$emails .= "$email[0]; ";	
	return $emails;
}

function getSales($year) {
	$sales = "";
	if(isLoggedIn()) {
		global $db;
		$query = "SELECT price, title 
					FROM imageData 
					WHERE buyerID is not null 
						and saleDate between '$_GET[periodBegin]' and '$_GET[periodEnd]' 
					";
		$result = mysqli_query($db, $query);
		$sales = "";	
		while($sale = mysqli_fetch_assoc($result)) {
			if($sale['title'] != null && $sale['price'] != null) {
				$sales .= "$sale[title]__$sale[price]___";			
			}		
		}
	}
	return $sales;
}
?>
<script>
function updateSales() {
	// Sales
	var totalSales = 0;
	// TODO: make user entry year and get sales per year
	var sales = '<?php echo getSales($_GET['saleYear']); ?>';
	// This is each sale
	var salesSplit = sales.split("___");
	var titles = new Array(salesSplit.length);
	var prices = new Array(salesSplit.length);	
	var salesString = "";
	// length - 1 because the last element is empty
	for(var i = 0; i < salesSplit.length - 1; i++) {
		var titlePriceArray = salesSplit[i].split("__");
		totalSales += parseInt(titlePriceArray[1]);
		titles[i] = titlePriceArray[0];
		prices[i] = titlePriceArray[1];
		salesString += titles[i] + ": " + prices[i] + "<br>";
		//console.log(i + "   " + titlePriceArray[1] + "   " + totalSales);
	}
	salesString += "Total " + "<?php echo $_GET['saleYear']; ?>" + ": " + totalSales;
	//$(".sales").html(year + ": " + totalSales);	
	$(".sales").html(salesString);
}
$(document).ready(function() {
	// Sales
	updateSales();

	// Emails
	$(".peeps").html("<?php echo getEmailAddr(); ?>");
	var emailShowing = false;
	$(".showPeeps").click(function() {
		if(!emailShowing) {
			$(".peeps").css("display","block");
			emailShowing = true;
		} else {
			$(".peeps").css("display","none");
			emailShowing = false;
		}		
	});
});
</script>

<div class='container'>
	<div class='row'>
		<div class='col-md-8 col-md-offset-2 center-it'>
			<h1 id='contactHeading'><strong>Admin Page</strong></h1>
			<div id='success'>
				<div class='row'>
					<?php 
					// Not Logged In
					if(!isLoggedIn()) { 
					?>
					<form id="login" method="post" action="" autocomplete='off'>
						<table align="center">
							<tr><td>Username</td></tr>
							<tr><td><input type="text" name="artsiteusername"></td></tr>						
							<tr><td>Password</td></tr>
							<tr><td><input type="password" name="password"></td></tr>
							<tr><td>&nbsp;</td></tr>
							<tr><td><input type="submit" name="login" value="Log In"></td></tr>							
						</table>
					</form>
					<?php 
					} else { 
					// Logged In
					include "editartwork.php";
					print "<hr>";
					include "editcontacts.php";
					?>
					&nbsp;
					<div class="row">
						<div class="col-md-4 col-md-offset-2">						
							<button class="showPeeps">SHOW emails</button>
							<div style="display:none;" class="peeps"></div>
						</div>
						<div class="col-md-6 col-md">						
							<!--
								ALTER TABLE imagedata ADD (
									saleDate date
								);
							-->
							<form method="get" name="saleYearForm"> 
								<input type="date" name="periodBegin" value="<?php if(isset($_GET['periodBegin'])) echo $_GET['periodBegin']; ?>"/>
								<input type="date" name="periodEnd" value="<?php if(isset($_GET['periodEnd'])) echo $_GET['periodEnd']; ?>"/>
								<input name="saleYear" value="<?php if(isset($_GET['saleYear'])) echo $_GET['saleYear']; ?>" placeholder="2020" type="text"/>
								<input type="submit" class="showSales" value="Show Sales"/>
							</form>
							<div class="sales"></div>
						</div>
					</div>
					<?php
					} ?>					
				</div>
			</div><!-- End success -->	
		</div>
	</div>
	<!-- <div class='row'>-->
		<div class='col-md-2 col-md-offset-8 center-it'>
			<form method="post" action="">
				<table>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td>
							<input type="submit" name="logout" value="Log Out">
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
				</table>
			</form>
		</div>
</div>
<?php
include "footer.php";
?>
