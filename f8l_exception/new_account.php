<?php
session_start(); ?>
<!-- F8L Exception Online Bank | Open New Account -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | Open New Account</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php include 'includes/inc_header.php'; ?>
	<h1>Open a New Account</h1><hr />
</head>
<body>

<?php
include 'includes/inc_validateInput.php';
include 'includes/inc_getNumberOfAccounts.php';

function openNewAccount($userName,$balance,$accountType) {
	global $errorCount;
	global $errorMessage;
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
	
	// figure out how to make a checkbox for savings or checking in this form.
	?>
	<form name="register" action="register.php" method="post">
	<p>Initial Deposit: <input type="text" name="balance"  /></p>	
	<p>Account Type: <input type="text" name="accountType" /></p>
	
	<p><input type="submit" name="Submit" value="Submit" /></p>
	</form>
	<br /><br />
	
	<?php
	//include 'includes/inc_text_menu.php';
}

$errorCount = 0;
$errorMessage = "";
$userName = $_SESSION['login'];
$numAccounts = getNumberOfAccounts($userName);

if ($numAccounts > 1)
	echo "You already have two accounts open. Each user is limited to two accounts.";
else {
	$showForm = TRUE;
	if (isset($_POST['Submit'])) {
		$balance  = validateInput($_POST['balance'],"Initial Deposit");
		$accountType  = validateInput($_POST['accountType'],"Account Type");
// gotta finish coding all this stuff below.
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
		displayForm ();
	}
	else {
		// create account in db
		createNewAccount($userName,$balance,$accountType);

		echo "<p>Your account has been created!.</p><br /><br />\n";
	}
}
include 'includes/inc_text_menu.php';
?>

</body>
</html>