<!-- F8L Exception Online Bank | Open New Account -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | Open New Account</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php include 'includes/inc_header.php'; ?>
	
</head>
<body>
        <hr />
        <h1>Open a New Account</h1>
<?php
include 'includes/inc_validateInput.php';
include 'includes/inc_getNumberOfAccounts.php';

function openNewAccount($userName,$balance,$accountType) {
	global $errorCount;
	global $errorMessage;
        global $connection;

	// Select database.
        if ($connection->connect_error)
            echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p>";
        else {
            $SQLstring = "INSERT INTO account (username,balance,acctype) 
				VALUES ('$userName','$balance','$accountType')";
            $result = queryMysql($SQLstring);
        }
        /*
	if ($db_connect === FALSE)
		echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p>";
		
	else {
		if (!@mysql_select_db($db_name, $db_connect))
			echo "<p>Connection error. Please try again later.</p>";
		else {
			//$today = date("Ymd");
			//echo "sending insert query now.<br />";
			$SQLstring = "INSERT INTO account (username,balance,acctype) 
				VALUES ('$userName','$balance','$accountType')";
			
			$QueryResult = @mysql_query($SQLstring, $db_connect);
		}
		mysql_close($db_connect);
	}
	return ($retval);
         * 
         */
}

function displayForm() {
	global $errorMessage;
	echo $errorMessage;
	
	?>
	<form name="register" action="new_account.php" method="post">
	<p>Initial Deposit: <input type="text" name="balance"  /></p>
	<p>Account Type: <input type="radio" name="accountType" value="Checking" checked>Checking
	<input type="radio" name="accountType" value="Savings">Savings</p>
	<p><input type="submit" name="Submit" value="Submit" /></p>
	</form>
	<br /><br />
	<?php
}

$showForm = TRUE;
$errorCount = 0;
$errorMessage = "";
$userName = "";
$userName = $_SESSION['login'];

// if not logged in, redirect to login page
if ($userName == "") {
	echo "You must be logged in to open a new account.<br /><br />";
	$showForm = FALSE;
}
else {
	// check if user has already opened 2-account limit
	$numAccounts = getNumberOfAccounts($userName);
	if ($numAccounts > 1) {
		echo "You already have two accounts open. Each user is limited to two accounts.<br />";
		$showForm = FALSE;
	}

	else {
		echo "User Name: ".$userName."<br />";
		
		if (isset($_POST['Submit'])) {
			$balance  = validateInput($_POST['balance'],"Initial Deposit");
			$accountType  = $_POST['accountType'];
	
			if($balance < 0) {
				$errorMessage .= "You cannot open a new account with a negative balance.<br />";
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
			openNewAccount($userName,$balance,$accountType);
			echo "<p>Your account has been created!.</p><br /><br />\n";
		}
	}
}
?>

</body>
</html>