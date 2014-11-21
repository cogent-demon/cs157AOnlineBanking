<!-- F8L Exception Online Bank | Change Password -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | Change Password</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php 
        include 'includes/inc_header.php'; 
        ?>
	
</head>
<body>
        <hr />
        <h1>Change Password</h1>
<?php
include 'includes/inc_validatePassword.php';
include 'includes/inc_validateInput.php';
include 'includes/inc_validateLogin.php';

function changePassword($userName,$oldPassword,$newPassword) {
	global $errorCount;
	global $connection;
        
        //include 'includes/inc_dbConnect.php';
	
	// Select database.
        if ($connection->connect_error)
            echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p>";
        else {
            $result = queryMysql("UPDATE users SET password='$newPassword' WHERE username='$userName'");
        }
        /*
	if ($db_connect === FALSE)
		echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p>";
		
	else {
		if (!@mysql_select_db($db_name, $db_connect))
			echo "<p>Connection error. Please try again later.</p>";
		else {
			$sql = "UPDATE user SET password='$newPassword' WHERE username='$userName'";
			$result = mysql_query($sql);
		}
		mysql_close($db_connect);
	}
	return ($retval);
         * 
         */
}

function displayForm($userName) {
	global $errorMessage;
	echo $errorMessage;
	?>
	<form name="change_password" action="change_password.php" method="post">
	<p>User Name: <input type="text" name="userName" value="<?php echo $userName; ?>" /></p>
	<p>Old Password: <input type="password" name="oldPassword" value="" /></p>
	<p>New Password: <input type="password" name="newPassword" value="" /></p>
	<p>Confirm New Password: <input type="password" name="newPassword2" value="" /></p>
	
	<p><input type="submit" name="Submit" value="Submit" /></p>
	</form>
	<br /><br />
	
	<?php
	
}

$showForm = TRUE;
$errorCount = 0;
$errorMessage = "";
$userName = "";
$oldPassword = "";
$newPassword = "";
$newPassword2 = "";

// get input from form fields and validate input
if (isset($_POST['Submit'])) {
	$userName  = validateInput($_POST['userName'],"User Name");
	$oldPassword = $_POST['oldPassword'];
	$userName = validateLogin($userName,$oldPassword);
	$newPassword  = validatePassword($_POST['newPassword'],$_POST['newPassword2'],"Password");
	if($userName == $newPassword) {
		$errorMessage .= "Error: new password cannot be the same as user name<br />";
		$errorCount++;
	}
	if ($errorCount == 0)
		$showForm = FALSE;
	else
		$showForm = TRUE;
}

if ($showForm == TRUE) {
	if ($errorCount > 0) // if there were errors
		$errorMessage .= "<p>Please re-enter the form information below.</p>\n";
	displayForm ($userName);
}
else {
	// encrypt password here
	
	// change password in db
	changePassword($userName,$oldPassword,$newPassword);
    echo "<p>\nPassword has been changed!.</p><br /><br />\n";
	//include 'includes/inc_text_menu.php';
}	
?>

</body>
</html>