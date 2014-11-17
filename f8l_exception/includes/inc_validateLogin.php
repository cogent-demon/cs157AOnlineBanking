<?php
include 'functions.php';
// checks user name and pw provided on login page against registered users in account table
// increments global $errorCount if login not approved.
function validateLogin ($myusername,$mypassword) {
	global $errorCount;
	global $errorMessage;
        global $connection;
	//mysql_select_db("$db_name")or die("cannot select DB");

	// To protect MySQL injection (more detail about MySQL injection)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	$myusername = $connection->real_escape_string($myusername);
	$mypassword = $connection->real_escape_string($mypassword);

	// check login and password for validity
	$sql = "SELECT * FROM users WHERE username='$myusername' and password='$mypassword'";
	$result = queryMysql($sql);

	// If result matched $myusername and $mypassword, table row must be 1 row
	$count = $result->num_rows;
	if($count == 1){
		// record login to login_history table
		//$sql2 = "INSERT INTO login_history (login) VALUES ('$myusername')";
		//$result = queryMysql($sql2);
	}
	else {
		$errorCount++;
		$errorMessage .= "Wrong User Name or Password.<br />\n";
	}
        $result->close();
	//mysql_close($db_connect);
	return $myusername;
}
?>