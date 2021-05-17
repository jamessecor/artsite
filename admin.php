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
	$password = "";
	if(!empty($_POST['password'])) {
		$password = addslashes(($_POST['password']));
		/* Debugging Password Hash /
			echo $password . "<br>";
			echo password_hash($password, PASSWORD_DEFAULT);
			echo "<br>" . $adminP;
			echo "<br>";		
		//	die();
		//*/
	} 
	
	// Check them
	// if($username===$adminU) { // For local testing
	if($username===$adminU && password_verify($password, $adminP)) {
		$_SESSION['artsiteusername'] = $username;
	}
}
// Log out button
if(isset($_POST['logout'])) {
	logout();	
}

// Add Expense
if(isset($_GET['add-expense']) && $_GET['add-expense'] == 'Add') {
	if(isset($_GET['expense-description']) && $_GET['expense-description'] != "" &&
			isset($_GET['expense-amount']) && $_GET['expense-amount'] != "" && 
			isset($_GET['expense-date']) && $_GET['expense-date'] != "") {	
		$desc = addslashes($_GET['expense-description']);
		$cost = addslashes($_GET['expense-amount']);
		$eDate = addslashes($_GET['expense-date']);
		addExpense($desc, $cost, $eDate);
	}
}

// Add Receipt
if((isset($_POST['receiptexpenseid']) && is_numeric($_POST['receiptexpenseid'])) && !empty($_FILES['receiptfile']['name'])) {
	include "uploadProcessing.php";
	print_r($_FILES);
	$target_dir = "./receipts/";
	if(uploadFile($target_dir, "receiptfile")) {
		// Insert query
		global $db;
		$receiptFilename = $_FILES['receiptfile']['name'];
		$query = "UPDATE expenses SET expenseFilename = '$receiptFilename' WHERE expenseId='$_POST[receiptexpenseid]';";		
		$result = mysqli_query($db, $query);
	}
} elseif(isset($_POST['deleteExpense'])) {
	$query = "DELETE FROM expenses WHERE expenseId='$_POST[deleteExpense]';";		
	$result = mysqli_query($db, $query);
	if($result) {
		$desc = stripslashes($_POST['desc']);
		echo "<div class='center-it text'>Successfully Deleted $desc.</div>";
	}	
}
?>
<script>
function updateSales() {
	var totalSales = 0;
	var taxesUnpaid = 0;
	// This is an array of individual sales as json objects
	var sales = <?php echo getSales(); ?>;
	console.log(sales);

	var taxCss = "";
	var salesString = "<div class='cv-text'>";
	
	// length - 1 because the last element is empty	
	for(var i = 0; i < sales.length; i++) {
		let sale = sales[i];
		totalSales += parseInt(sale.saleRevenue);
		if(sale['taxStatus'] !== "paid") {
			taxesUnpaid += parseInt(sale.saleRevenue);
		}
		taxCss = "";
		taxCss = sale.taxStatus == 'paid' ? "background-color:#4a4;color:#7ff" : "background-color:red;color:#7ff"
		// on click add paid
		salesString += "<span><input type=\"hidden\" value=\"" + sale.imgID + "\"><strong><span id=\"sales-title\">" + sale.title + "</span></strong> (" + sale.fullname + ", " + sale.saleDate + "): <span id='sales-price' style='"+taxCss+";'><strong>" + sale.saleRevenue + "(" + sale.salePrice + ")" + "</strong></span></span><br>";
	}
	salesString += "<br><strong>Total</strong>: " + totalSales + "<br>";
	salesString += "<strong>Total Unpaid Taxes</strong>: " + taxesUnpaid + "<br>";
	var taxesDue = taxesUnpaid * .06;
	taxesDue = Math.round(taxesDue * 100)/100;
	salesString += "Taxes Due: <span style='background-color:red;color:#7ff';>" + taxesDue + "</span></div>";
	$(".sales").html(salesString);
}

function updateExpenses() {
	let expenses = <?php echo getExpenses(); ?>;
	let totalExpenses = 0;
	let expensesString = "";
	console.log(expenses);
	// Loop over expenses
	$.each(expenses, function(i, expense) {
		totalExpenses += parseFloat(expense.cost);
		if(i==0) {
			expensesString += "<tr><th>Desc(view img)</th><th>Amount(upload/delete)</th><th>Date</th></tr>";	
		}		
		// TODO: Add image on hover or click
		if(expense.expenseFilename !== null) {
			expensesString += "<tr id='expense-row-" + i + "'>"
				+ "<td><a class='badge badge-success text-light' data-toggle='modal' data-target='#expense-receipt-" + i + "'>" + expense.expenseDesc + "</a></td>"
				+ "<td><a class='badge badge-secondary text-light' data-toggle='modal' data-target='#expense-modal-" + i + "'>" + expense.cost + "</a></td>"
				+ "<td>" + expense.expenseDates + "</a></td></tr>";
		} else {
			expensesString += "<tr id='expense-row-" + i + "'>"
				+ "<td>" + expense.expenseDesc + "</td>"
				+ "<td><a class='badge badge-success text-light' data-toggle='modal' data-target='#expense-modal-" + i + "'>" + expense.cost + "</a></td>"
				+ "<td>" + expense.expenseDate + "</td></tr>";
		}		
	});
	expensesString += "<tr><td><span class='badge badge-primary text-light'>Total</span></td><td><span class='badge badge-primary text-light'>" + Math.round(totalExpenses*100)/100 + "</span></td></tr>";
	expensesString = "<table id='expenses-table'>" + expensesString + "</table>";
	$("#expenses").html(expensesString);
}

function changeHeaderCss(header, data) {
	if($(data).css("display") == "none") {
		$(header).css("color","#aec");
		$(header).css("background-color","#644");
	} else {
		$(header).css("color","");
		$(header).css("background-color","");
	}
}

function updateURL() {
	var url = window.location.href;
	var urlArray = url.split("&");
	var newURL = "";
	for(var i = 0; i < urlArray.length; i++) {
		if(!urlArray[i].includes("add-expense")) {
			newURL += urlArray[i] + "&";
		}
	}
	newURL = newURL.substring(0, newURL.length - 1);
	window.history.replaceState({}, "", newURL);
}

function updateTaxInfo(imageId, element) {
  var xhttp;
  if (imageId == "") {
    console.log("No Id")
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		if(this.responseText) {
			location.reload();			
		}
    }
  };
  xhttp.open("GET", "updateTaxInfo.php?imageId="+imageId, true);
  xhttp.send();
}

$(document).ready(function() {
	// Stop Duplicate Expenses
	updateURL();

	// Sales
	updateSales();
	$("#sales-header").click(function() {
		$(".sales").toggle();
		changeHeaderCss("#sales-header", ".sales");
	});
	
	// Expenses
	updateExpenses();
	$("#expenses-header").click(function() {
		$("#expenses").toggle();
		changeHeaderCss("#expenses-header", "#expenses");
	});

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

	// Span
	$("span").on("click", function() {
		var imageId = $(this).children("input[type=hidden]")[0].value;
		var title = $(this).find("#sales-title")[0].innerHTML;
		console.log($(this).find("#sales-title")[0].innerHTML);
		if(confirm("Update Tax Info for " + title + "?")) {
			updateTaxInfo(imageId, this);
		}		
	});
});
</script>

	<div class='row no-gutters container-fluid'>
		<div class="col-lg-10 offset-lg-1">
		<h1 id='contactHeading' class="center-it"><strong>Admin Page</strong></h1>
		<div id='success'>
			<div class='row'>
				<?php 
				// Not Logged In
				if(!isLoggedIn()) { 
				?>
				<form id="login" method="post" action="" autocomplete='off'>
					<div class="form-row justify-content-center col-lg-12 offset-lg-2">
						<div class="form-group full">
							<label for="artsiteusername">Username</label>
							<input type="text" name="artsiteusername">
						</div>
						<div class="form-group full">
							<label for="password">Password</label>
							<input type="password" name="password">
						</div>
						<div class="form-group full">
							<input type="submit" name="login" value="Log In">
						</div>
					</div>
				</form>
				<?php 
				} else { 
					?><div class="p-2">php version: <?php echo phpversion(); ?></div><?php
				// Logged In
				include "editartwork.php";
				print "<hr>";
				//include "editcontacts.php";
				?>
				&nbsp;
				<div class="row container-fluid">
					<div class="col-lg-8 offset-lg-2">						
						<div><strong>emails</strong></div>
						<button class="showPeeps">SHOW emails</button>
						<div style="display:none;" class="peeps"></div>
					</div>
				</div>
				<hr>
				<div class="row container-fluid">
					<!-- Sales -->
					<div class="col-lg-2 offset-lg-2">						
						<div id="sales-header"><strong>sales</strong></div>
						<form method="get" name="saleYearForm"> 
							<div>Period Beginning<br><input type="date" name="periodBegin" value="<?php if(isset($_GET['periodBegin'])) echo $_GET['periodBegin']; ?>"/></div>
							<div>Period Ending<br><input type="date" name="periodEnd" value="<?php if(isset($_GET['periodEnd'])) echo $_GET['periodEnd']; ?>"/></div>
							<br><input type="submit" class="showSales" value="Show Sales"/>
						</form>
					</div>
					<div class="col-lg-7 offset-lg-1">						
						<div class="sales"></div>
					</div>
				</div>
				<hr>
				<div class="row container-fluid">
					<div class="col-lg-8 offset-lg-2">
						<div id="expenses-header"><strong>expenses</strong></div>
						<form method="get" name="expensesForm">
							<input type="text" name="expense-description" placeholder="Drawing Board supplies"/>
							<input type="text" name="expense-amount" placeholder="13.75"/>
							<input type="date" name="expense-date" value="<?php echo date("Y-m-d"); ?>"/>
							<input type="hidden" name="periodBegin" value="<?php if(isset($_GET['periodBegin'])) echo $_GET['periodBegin']; ?>"/>
							<input type="hidden" name="periodEnd" value="<?php if(isset($_GET['periodEnd'])) echo $_GET['periodEnd']; ?>"/>
							<input type="submit" name="add-expense" value="Add"/>
						</form>
						<div id="expenses"></div>
					</div>					
				</div>
				<div class='row'>
				<?php
				$expenses = json_decode(getExpenses(), true);
				for($i = 0; $i < count($expenses); $i++) { ?>
					<div class="modal fade" id="<?php echo "expense-modal-$i";?>" tabindex="-1" aria-labelledby="<?php echo "expense-modal-$i-label";?>" aria-hidden="true">
						<div class="modal-dialog">
							<div class="p-2 modal-content">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<strong>Add Receipt Image</strong><br/>
								<?php 
								$expense = $expenses[$i];
								echo "$expense[expenseDesc] $expense[cost] $expense[expenseDate]";
								?>
								<form name='add-expense-image' method='post' onsubmit="return confirm('Continue?');" class="center-it" action="" enctype="multipart/form-data">
									<input type="file" name="receiptfile"/>
									<input type="hidden" name="periodBegin" value="<?php if(isset($_GET['periodBegin'])) echo $_GET['periodBegin']; ?>"/>
									<input type="hidden" name="periodEnd" value="<?php if(isset($_GET['periodEnd'])) echo $_GET['periodEnd']; ?>"/>
									<input type="hidden" name="desc" value="<?php echo $expense[1]; ?>"/>
									<div>&nbsp;</div>
									<div>
										<button name="receiptexpenseid" value="<?php echo $expense['expenseId']; ?>">Submit Receipt</button>							
										<button name="deleteExpense" value="<?php echo $expense['expenseId']; ?>">Delete Expense</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<?php if(!is_null($expense['expenseFilename'])) { ?>
						<div class="modal fade" id="<?php echo "expense-receipt-$i";?>" tabindex="-1" aria-labelledby="<?php echo "expense-receipt-$i-label";?>" aria-hidden="true">
							<div class="modal-dialog">
								<div class="p-2 modal-content">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<div><?php echo "$expense[expenseDesc] $expense[cost] $expense[expenseDate]";?></div>
									<div><?php echo "$expense[expenseFilename]";?></div>
									<img class="img-responsive" src="./receipts/<?php echo $expense['expenseFilename'];?>" alt="Receipt unavailable"/>
								</div>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
					
				</div>
				<?php
				} ?>					
			</div>
		</div>
	</div>
	<!-- <div class='row'>-->
		<div class='col-lg-2 offset-lg-8 center-it'>
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
