<?php 
// If no where or no orderBy, enter "1"
function selectQuery($db, $columns, $table, $where, $orderBy) {
	$query = "SELECT $columns FROM $table WHERE $where ORDER BY $orderBy;";
	return mysqli_query($db, $query);
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
		$query = "SELECT price, title, c_name, c_lastname
					FROM imageData i
					INNER JOIN contacts c
						ON i.buyerID = c.c_id
					WHERE buyerID is not null 
						and saleDate between '$_GET[periodBegin]' and '$_GET[periodEnd]' 
					";
		$result = mysqli_query($db, $query);
		while($sale = mysqli_fetch_assoc($result)) {
			if($sale['title'] != null && $sale['price'] != null) {
				$sales .= "$sale[title]__$sale[price]__$sale[c_name] $sale[c_lastname]___";			
			}		
		}
	}
	return $sales;
}

function getExpenses() {
	$expenses = "";
	if(isLoggedIn()) {
		global $db;
		$query = "SELECT expenseId, expenseDesc, cost, expenseDate, expenseFilename FROM expenses";
		// Add date range if dates are set
		if(isset($_GET['periodBegin']) && $_GET['periodBegin'] != "" && isset($_GET['periodEnd']) && $_GET['periodEnd'] != "") {
			$query .= " WHERE expenseDate between '$_GET[periodBegin]' and '$_GET[periodEnd]'"; 
		}
		$query .= ";";
		$result = mysqli_query($db, $query);
		while($expense = mysqli_fetch_assoc($result)) {
			if($expense['expenseDesc'] != null && $expense['cost'] != null && $expense['expenseDate'] != null) {
				$expensesFilename = $expense['expenseFilename'];
				if($expensesFilename == null) {
					$expensesFilename = " ";
				}
				$expenses .= "$expense[expenseId]__$expense[expenseDesc]__$expense[cost]__$expense[expenseDate]__${expensesFilename}___";
			}		
		}
	}
	return addslashes($expenses);
}

function addExpense($desc, $cost, $eDate) {
	if(isLoggedIn()) {
		global $db;
		$query = "INSERT INTO expenses (expenseDesc, cost, expenseDate) VALUES ('$desc', $cost, '$eDate');";
		$addResult = mysqli_query($db, $query);
	}
}
?>