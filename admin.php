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

function getSales() {
	$sales = "";
	if(isLoggedIn() && isset($_GET['periodBegin'])) {
		global $db;
		$query = "SELECT price, title 
					FROM imageData 
					WHERE buyerID is not null 
						and saleDate between '$_GET[periodBegin]' and '$_GET[periodEnd]' 
					";
		$result = mysqli_query($db, $query);
		while($sale = mysqli_fetch_assoc($result)) {
			if($sale['title'] != null && $sale['price'] != null) {
				$sales .= "$sale[title]__$sale[price]___";			
			}		
		}
	}
	return $sales;
}

function getExpenses() {
	$expenses = "";
	if(isLoggedIn()) {
		global $db;
		$query = "SELECT expenseDesc, cost, expenseDate FROM expenses";
		if(isset($_GET['periodBegin']) && isset($_GET['periodEnd'])) {
			$query .= " WHERE expenseDate between '$_GET[periodBegin]' and '$_GET[periodEnd]'"; 
		}
		$query .= ";";
		$result = mysqli_query($db, $query);
		while($expense = mysqli_fetch_assoc($result)) {
			if($expense['expenseDesc'] != null && $expense['cost'] != null && $expense['expenseDate'] != null) {
				$expenses .= "$expenses[expenseDesc]__$expenses[cost]__$expenses[expenseDate]___";			
			}		
		}
	}
	return $expenses;
}
?>
<script>
function updateSales() {
	var totalSales = 0;
	var sales = '<?php echo getSales(); ?>';
	
	// This is an array of individual sales
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
	}
	salesString += "Total: " + totalSales + "<br>";
	var taxesDue = totalSales * .06;
	salesString += "Taxes Due: " + taxesDue;
	$(".sales").html(salesString);
}

function updateExpenses() {
	var expenses = "<?php echo getExpenses(); ?>";
	// This is an array of individual sales
	var expensesSplit = expenses.split("___");
	var descs = new Array(expensesSplit.length);
	var costs = new Array(expensesSplit.length);	
	var dates = new Array(expensesSplit.length);	
	var expensesString = "";

	// length - 1 because the last element is empty
	for(var i = 0; i < expensesSplit.length - 1; i++) {
		var descCostDateArray = expensesSplit[i].split("__");
		totalExpenses += parseInt(descCostDateArray[1]);
		descs[i] = descCostDateArray[0];
		costs[i] = descCostDateArray[1];
		dates[i] = descCostDateArray[2];
		salesString += descs[i] + "; " + costs[i] + "; " + dates[i] + "<br>";
	}
	salesString += "Total: " + totalExpenses + "<br>";
	$("#expenses").html(expensesString);
}
$(document).ready(function() {
	// Sales
	updateSales();
	
	// Expenses
	updateExpenses();

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
		<h1 id='contactHeading' class="center-it"><strong>Admin Page</strong></h1>
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
				//include "editcontacts.php";
				?>
				&nbsp;
				<div class="row">
					<div class="col-md-3 col-md-offset-1">						
						<button class="showPeeps">SHOW emails</button>
						<div style="display:none;" class="peeps"></div>
					</div>
					<!-- Sales -->
					<div class="col-md-3">						
						<div><strong>sales</strong></div>
						<form method="get" name="saleYearForm"> 
							<div>Period Beginning<br><input type="date" name="periodBegin" value="<?php if(isset($_GET['periodBegin'])) echo $_GET['periodBegin']; ?>"/></div>
							<div>Period Ending<br><input type="date" name="periodEnd" value="<?php if(isset($_GET['periodEnd'])) echo $_GET['periodEnd']; ?>"/></div>
							<br><input type="submit" class="showSales" value="Show Sales"/>
						</form>
						<div class="sales"></div>
					</div>
					<div class="col">
						<!--
							create table expenses (
								expenseId int not null AUTO_INCREMENT,
								expenseDesc varchar(150) not null,
								cost double not null,
								expenseDate date not null,
								PRIMARY KEY(expenseId)
							);
						-->
						<div><strong>expenses</strong></div>
						<form method="get" name="expensesForm">
							<input type="text" name="expense-description" placeholder="Drawing Board supplies"/>
							<input type="text" name="expense-amount" placeholder="13.75"/>
							<input type="submit" name="add-expense" value="Add"/>
						</form>
						<div id="expenses"></div>
					</div>
				</div>
				<?php
				} ?>					
			</div>
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
