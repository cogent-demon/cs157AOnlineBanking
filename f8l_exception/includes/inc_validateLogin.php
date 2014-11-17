<?php
// checks user name and pw provided on login page against registered users in account table
// increments global $errorCount if login not approved.
function validateLogin ($myusername,$mypassword) {
	global $errorCount;
	global $errorMessage;
	include 'includes/inc_dbConnect.php';
	mysql_select_db("$db_name")or die("cannot select DB");

	// To protect MySQL injection (more detail about MySQL injection)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	$myusername = mysql_real_escape_string($myusername);
	$mypassword = mysql_real_escape_string($mypassword);

	// check login and password for validity
	$sql = "SELECT * FROM user WHERE username='$myusername' and password='$mypassword'";
	$result = mysql_query($sql);

	// If result matched $myusername and $mypassword, table row must be 1 row
	$count = mysql_num_rows($result);
	if($count == 1){
		// record login to login_history table
		$sql2 = "INSERT INTO login_history (login) VALUES ('$myusername')";
		$result = mysql_query($sql2);
	}
	else {
		$errorCount++;
		$errorMessage .= "Wrong User Name or Password.<br />\n";
	}
	mysql_close($db_connect);
	return $myusername;
}
?>