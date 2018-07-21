<?php 
function selectQuery($db, $columns, $table, $where, $orderBy) {
	$query = "SELECT $columns FROM $table WHERE $where ORDER BY $orderBy;";
	return mysqli_query($db, $query);
}
?>