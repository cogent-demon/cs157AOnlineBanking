<?php
// get the number of checking and savings accounts for a user (max is 2)
// increments global $errorCount if errors encountered.
function getNumberOfAccounts ($userName) {
	global $errorCount;
	global $errorMessage;
	include($_SERVER['DOCUMENT_ROOT']."/f8l_exception/includes/inc_dbConnect.php");
	mysql_select_db("$db_name")or die("cannot select DB");

	// get number of accounts
	$sql = "SELECT * FROM account WHERE username='$userName' and accounttype='Checking' or 'Savings'";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	
	mysql_close($db_connect);
	return $count;
}
?>