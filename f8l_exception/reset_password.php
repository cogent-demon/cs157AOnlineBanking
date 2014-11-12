<?php
session_start(); ?>
<!-- F8L Exception Online Bank | Reset Password -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | Reset Password</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php include 'includes/inc_header.php'; ?>
	<h1>Reset Password</h1><hr />
</head>
<body>

<?php
include 'includes/inc_generatePassword.php';
include 'includes/inc_validateInput.php';

function resetPassword($userName) {
	global $errorCount;
	global $errorMessage;
	global $email;
	include 'includes/inc_dbConnect.php';
	
	// Select database.
	if ($db_connect === FALSE)
		echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p>";
	else {
		if (!@mysql_select_db($db_name, $db_connect))
			echo "<p>Connection error. Please try again later.</p>";
		else {
			// check login for validity
			$sql = "SELECT * FROM user WHERE username='$userName' and email='$email'";
			$result = mysql_query($sql);

			// Mysql_num_row is counting table rows
			$count = mysql_num_rows($result);

			// If result matched $userName, table row must be 1 row. Get Email address, and Reset PW
			if($count == 1){
				$row = mysql_fetch_row($result);
				//$email = $row[5];
				$newPassword = generatePassword();
				$sql = "UPDATE user SET password='$newPassword' WHERE username='$userName'";
				$result = mysql_query($sql);
			}
			else {
				$errorCount++;
				$errorMessage .= "Account not found. Please re-enter your User Name and Email.<br />\n";
			}
			mysql_close($db_connect);
			
			return $newPassword;
		}
	}
}
function displayForm() {
	global $errorMessage;
	echo $errorMessage;
	?>
	<form name="reset_password" action="reset_password.php" method="post">
	<p>User Name: <input type="text" name="userName" /></p>
	<p>Email: <input type="text" name="email" /></p>
	<p><input type="submit" name="Reset" value="Reset" /></p>
	</form>
	<br /><br />
	
	<?php
	include 'includes/inc_text_menu.php';
}

$ShowForm = TRUE;
$errorCount = 0;
$errorMessage = "";
$email = "";
$userName = "";

if (isset($_POST['Reset'])) {
	$userName  = validateInput($_POST['userName'],"User Name");
	$email = validateInput($_POST['email'],"Email");
	if ($errorCount == 0) {
		$ShowForm = FALSE;
	}
	else
		$ShowForm = TRUE;
}

if ($ShowForm == TRUE) {
	if ($errorCount > 0) // if there were errors
		$errorMessage .= "<p>Please re-enter the form information below.</p>\n";
	displayForm ();
}
else {
	$newPassword = resetPassword($userName);
	if ($errorCount > 0) { // if there were errors
		$errorMessage .= "<p>Please re-enter the form information below.</p>\n";
		displayForm ();
	}
	else {
		echo "<p>\nPassword has been reset!. A new password has been emailed to you.</p><br /><br />\n";
		include 'includes/inc_text_menu.php';
		
		// send confirmation email
		$SenderAddress = "<$email>";
		$Headers = "From: $SenderAddress\nCC:$SenderAddress\n";
		
		$from = "F8L Exception Online"; // sender
		$subject = "F8L Exception Online Bank Password Reset";
		$message = "Your new password is $newPassword\nWe recommend you login using this password and change it to a new password of your choosing.\n\nF8L Exception Online Bank";
		// message lines should not exceed 70 characters (PHP rule), so wrap it
		$message = wordwrap($message, 70);
		// send mail
		mail($email,$subject,$message,"From: $from\n");
	}	
}	
?>

</body>
</html>