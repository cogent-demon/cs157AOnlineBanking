<?php
include 'functions.php';
// get the number of checking and savings accounts for a user (max is 2)
// increments global $errorCount if errors encountered.
function getNumberOfAccounts ($userName) {
	global $errorCount;
	global $errorMessage;
	//mysql_select_db("$db_name")or die("cannot select DB");

	// get number of accounts
	$sql = "SELECT * FROM account WHERE username='$userName' and (acctype='Checking' or acctype='Savings')";
	$result = queryMysql($sql);
	$count = $result->num_rows;
	
	//mysql_close($db_connect);
	return $count;
	
}
?>