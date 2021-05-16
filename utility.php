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
	$sales = array();
	if(isLoggedIn()) {
		global $db;
		$query = "SELECT COALESCE(salePrice, price) as salePrice, COALESCE(saleRevenue, salePrice, price) as saleRevenue, title, concat(c_name, ' ', c_lastname) as fullname, saleDate, imgID, taxStatus
			FROM imageData i INNER JOIN contacts c ON i.buyerID = c.c_id WHERE buyerID is not null ";
		if(!empty($_GET['periodBegin']) && !empty($_GET['periodEnd'])) {
			$query .= "and saleDate between '$_GET[periodBegin]' and '$_GET[periodEnd]'";
		}		
		$query .= " ORDER BY saleDate;";
		$result = mysqli_query($db, $query);
		while($sale = mysqli_fetch_assoc($result)) {
			$sales[] = array(
				'title' => $sale['title'],
				'imgID' => $sale['imgID'],
				'saleDate' => $sale['saleDate'],
				'saleRevenue' => $sale['saleRevenue'],
				'salePrice' => $sale['salePrice'],
				'fullname' => $sale['fullname'],
				'taxStatus' => $sale['taxStatus']
			);
		}
	}
	return json_encode($sales);
}

function getExpenses() {
	$expenses = "";
	if(false && isLoggedIn()) {
		global $db;
		$query = "SELECT expenseId, expenseDesc, cost, expenseDate, expenseFilename FROM expenses";
		// Add date range if dates are set
		if(isset($_GET['periodBegin']) && $_GET['periodBegin'] != "" && isset($_GET['periodEnd']) && $_GET['periodEnd'] != "") {
			$query .= " WHERE expenseDate between '$_GET[periodBegin]' and '$_GET[periodEnd]'"; 
		}
		$query .= " ORDER BY expenseDate;";
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