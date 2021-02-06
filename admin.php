<?php
session_start();
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
	//if($username===$adminU) { // For local testing
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
	var sales = '<?php echo getSales(); ?>';
	
	// This is an array of individual sales
	var salesSplit = sales.split("___");

	var titles = new Array(salesSplit.length);
	var prices = new Array(salesSplit.length);	
	var names = new Array(salesSplit.length);
	var saleDates = new Array(salesSplit.length);	
	var ids = new Array(salesSplit.length);	
	var taxStatus = new Array(salesSplit.length);	
	var taxCss = "";
	var salesString = "<div class='cv-text'>";
	
	// length - 1 because the last element is empty	
	for(var i = 0; i < salesSplit.length - 1; i++) {
		var titlePriceNameArray = salesSplit[i].split("__");
		totalSales += parseInt(titlePriceNameArray[1]);
		titles[i] = titlePriceNameArray[0];
		prices[i] = titlePriceNameArray[1];
		names[i] = titlePriceNameArray[2];
		saleDates[i] = titlePriceNameArray[3];
		ids[i] = titlePriceNameArray[4];
		taxStatus[i] = titlePriceNameArray[5];
		if(taxStatus[i] == 'none') {
			taxesUnpaid += parseInt(titlePriceNameArray[1]);
		}
		taxCss = "";
		console.log(taxStatus[i]);
		taxCss = updateSalePriceCss(taxStatus[i]);
		// on click add paid
		salesString += "<span><input type=\"hidden\" value=\"" + ids[i] + "\"><strong><span id=\"sales-title\">" + titles[i] + "</span></strong> (" + names[i] + ", " + saleDates[i] + "): <span id='sales-price' style='"+taxCss+";'><strong>" + prices[i] + "</strong></span></span><br>";
	}
	salesString += "<br><strong>Total</strong>: " + totalSales + "<br>";
	salesString += "<strong>Total Unpaid Taxes</strong>: " + taxesUnpaid + "<br>";
	var taxesDue = taxesUnpaid * .06;
	taxesDue = Math.round(taxesDue * 100)/100;
	salesString += "Taxes Due: <span style='background-color:red;color:#7ff';>" + taxesDue + "</span></div>";
	$(".sales").html(salesString);
}

function updateSalePriceCss(status) {
	var taxCss = "";
	if(status == 'none') {
		taxCss = "background-color:red;color:#7ff";
	} else if(status == 'front') {
		taxCss = "background-color:#55f;color:#7ff";
	} else if(status == 'paid') {
		taxCss = "background-color:#4a4;color:#7ff";
	}
	return taxCss;
}

function updateExpenses() {
	var expenses = '<?php echo getExpenses(); ?>';
	var totalExpenses = 0;
	// This is an array of individual sales
	var expensesSplit = expenses.split("___");
	var ids = new Array(expensesSplit.length);	
	var descs = new Array(expensesSplit.length);
	var costs = new Array(expensesSplit.length);	
	var dates = new Array(expensesSplit.length);	
	var filenames = new Array(expensesSplit.length);
	var expensesString = "";
	<?php
	// Add receipt img
	if(isset($_GET['expenseId'])) {
		echo "var formExpenseId = " . $_GET['expenseId'] . ";";		
	}
	?>
	// length - 1 because the last element is empty
	for(var i = 0; i < expensesSplit.length - 1; i++) {
		var descCostDateArray = expensesSplit[i].split("__");
		totalExpenses += parseFloat(descCostDateArray[2]);
		ids[i] = descCostDateArray[0];
		descs[i] = descCostDateArray[1];
		costs[i] = descCostDateArray[2];
		dates[i] = descCostDateArray[3];
		filenames[i] = descCostDateArray[4];
		if(i==0) {
			expensesString += "<tr><th>Desc(view img)</th><th>Amount(upload/delete)</th><th>Date</th></tr>";	
		}		
		// TODO: Add image on hover or click
		if(filenames[i] !== ' ') {
			expensesString += "<tr id='expense-row-" + i + "'>"
				+ "<td><a href='#expense-receipt-" + i + "' rel='modal:open'>" + descs[i] + "</a></td>"
				+ "<td><a href='#expense-modal-" + i + "' rel='modal:open'>" + costs[i] + "</a></td>"
				+ "<td>" + dates[i] + "</a></td></tr>";
		} else {
			expensesString += "<tr id='expense-row-" + i + "'>"
				+ "<td>" + descs[i] + "</td>"
				+ "<td><a href='#expense-modal-" + i + "' rel='modal:open'>" + costs[i] + "</a></td>"
				+ "<td>" + dates[i] + "</td></tr>";
		}		
	}
	expensesString += "<tr><td>Total</td><td>" + Math.round(totalExpenses*100)/100 + "</td></tr>";
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

<div class='container-fluid'>
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
				<div class="row container-fluid">
					<div class="col-md-8 col-md-offset-2">						
						<div><strong>emails</strong></div>
						<button class="showPeeps">SHOW emails</button>
						<div style="display:none;" class="peeps"></div>
					</div>
				</div>
				<hr>
				<div class="row container-fluid">
					<!-- Sales -->
					<div class="col-md-2 col-md-offset-2">						
						<div id="sales-header"><strong>sales</strong></div>
						<form method="get" name="saleYearForm"> 
							<div>Period Beginning<br><input type="date" name="periodBegin" value="<?php if(isset($_GET['periodBegin'])) echo $_GET['periodBegin']; ?>"/></div>
							<div>Period Ending<br><input type="date" name="periodEnd" value="<?php if(isset($_GET['periodEnd'])) echo $_GET['periodEnd']; ?>"/></div>
							<br><input type="submit" class="showSales" value="Show Sales"/>
						</form>
					</div>
					<div class="col-md-7 col-md-offset-1">						
						<div class="sales"></div>
					</div>
				</div>
				<hr>
				<div class="row container-fluid">
					<div class="col-md-8 col-md-offset-2">
						<!--
							create table expenses (
								expenseId int not null AUTO_INCREMENT,
								expenseDesc varchar(150) not null,
								cost double not null,
								expenseDate date not null,
								PRIMARY KEY(expenseId)
							);
						-->
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
				$expenses = getExpenses();
				$exSplit = explode("___", $expenses);
				for($i = 0; $i < count($exSplit) - 1; $i++) { ?>
					<div id="<?php echo "expense-modal-$i";?>" class="modal">
						<a href="#close-modal" rel="modal:close" class="close-modal ">Close</a>
						<strong>Add Receipt Image</strong><br/>
						<?php 
						$exData = explode("__", $exSplit[$i]);
						echo "$exData[1] $exData[2] $exData[3]";
						?>
						<form name='add-expense-image' method='post' onsubmit="return confirm('Continue?');" class="center-it" action="" enctype="multipart/form-data">
							<input type="file" name="receiptfile"/>
							<input type="hidden" name="periodBegin" value="<?php if(isset($_GET['periodBegin'])) echo $_GET['periodBegin']; ?>"/>
							<input type="hidden" name="periodEnd" value="<?php if(isset($_GET['periodEnd'])) echo $_GET['periodEnd']; ?>"/>
							<input type="hidden" name="desc" value="<?php echo $exData[1]; ?>"/>
							<div>&nbsp;</div>
							<div>
								<button name="receiptexpenseid" value="<?php echo $exData[0]; ?>">Submit Receipt</button>							
								<button name="deleteExpense" value="<?php echo $exData[0]; ?>">Delete Expense</button>
							</div>
						</form>
					</div>
					<div id="<?php echo "expense-receipt-$i";?>" class="modal">
						<a href="#close-modal" rel="modal:close" class="close-modal">Close</a>
						<span><?php echo "$exData[1] $exData[2] $exData[3]";?></span>
						<img class="img-responsive" src="./receipts/<?php echo $exData[4];?>" alt="Receipt unavailable"/>
					</div>
				<?php } ?>
					
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
