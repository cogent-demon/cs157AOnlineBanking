<?php
session_start(); ?>
<!-- F8L Exception Online Bank | Make a Loan Payment -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | Make a Loan Payment</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php include 'includes/inc_header.php'; ?>
	<h1>Make a Loan Payment -- Under construction</h1><hr />
</head>
<body>

<?php
include 'includes/inc_validatePassword.php';
include 'includes/inc_validateEmail.php';
include 'includes/inc_validateInput.php';
include 'includes/inc_validateUserName.php';

function createNewAccount($First,$Last,$Email,$Login,$Password) {
	global $errorCount;
	include 'includes/inc_dbConnect.php';
	
	// Select database.
	if ($db_connect === FALSE)
		echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p>";
		
	else {
		if (!@mysql_select_db($db_name, $db_connect))
			echo "<p>Connection error. Please try again later.</p>";
		else {
			$today = date("Ymd");
			$TableName = "account";
			$SQLstring = "INSERT INTO 
				$TableName (login,password,firstName,lastName,email,active,dateOpened) 
				VALUES ('$Login','$Password','$First','$Last','$Email',1,'$today')";
			
			$QueryResult = @mysql_query($SQLstring, $db_connect);
		}
		mysql_close($db_connect);
	}
	return ($retval);
}

function displayForm($First, $Last, $Email, $Login) {
	global $errorMessage;
	echo $errorMessage;
	?>
	<form name="register" action="register.php" method="post">
	<p>First Name: <input type="text" name="First" value="<?php echo $First; ?>" /></p>
	<p>Last Name: <input type="text" name="Last" value="<?php echo $Last; ?>" /></p>
	<p>Your E-Mail: <input type="text" name="Email" value="<?php echo $Email; ?>" /></p>
	<p>User Name: <input type="text" name="Login" value="<?php echo $Login; ?>" /></p>
	<p>Password: <input type="password" name="Password" value="" /></p>
	<p>Confirm Password: <input type="password" name="Password2" value="" /></p>
	
	<p><input type="submit" name="Submit" value="Register" /></p>
	</form>
	<br /><br />
	
	<?php
	include 'includes/inc_text_menu.php';
}

$showForm = TRUE;
$errorCount = 0;
$errorMessage = "";
$First = "";
$Last = "";
$Email = "";
$Login = "";
$Password = "";
$Password2 = "";

if (isset($_POST['Submit'])) {
	$First = validateInput($_POST['First'],"First Name");
	$Last = validateInput($_POST['Last'],"Last Name");
	$Email  = validateEmail($_POST['Email'],"E-mail");
	$Login  = validateUserName($_POST['Login'],"User Name");
	$Password  = validatePassword($_POST['Password'],$_POST['Password2'],"Password");
	if($Login == $Password) {
		$errorMessage .= "Password cannot be the same as user name<br />";
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
	displayForm ($First, $Last, $Email, $Login);
}
else {
	// encrypt password
	//$options = array('cost' => 11);
	//$password = password_hash($password, PASSWORD_BCRYPT, $options);
	
	// create account in db
	createNewAccount($First,$Last,$Email,$Login,$Password);

	// send confirmation email
	$SenderAddress = "$First <$Email>";
	$Headers = "From: $SenderAddress\nCC:$SenderAddress\n";
	
	$from = "PVault"; // sender
    $subject = "PVault Registration Confirmation";
    $message = $First . ",\nYou have successfully registered for PVault. Now you can Store your documents in the cloud, securely locked inside your own Personal Vault.\n\nThe PVault Team";
    // message lines should not exceed 70 characters (PHP rule), so wrap it
    $message = wordwrap($message, 70);
    // send mail
    mail($Email,$subject,$message,"From: $from\n");
	
    echo "<p>" . $First . "\nyour account has been created. Welcome to PVault!.</p><br /><br />\n";
	include 'includes/inc_text_menu.php';
}	
?>

</body>
</html>