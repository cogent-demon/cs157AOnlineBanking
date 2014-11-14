<!-- F8L Exception Online Bank | Deposit -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | Deposit</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php include 'includes/inc_header.php'; ?>
	
</head>
<body>
        <hr />
        <h1>Deposit</h1>
<?php
include 'includes/inc_validateInput.php';
include 'includes/inc_validateLogin.php';

function deposit($userName,$accountId,$amount) {
	global $errorCount;
	global $errorMessage;
	include 'includes/inc_dbConnect.php';
		
	// Select database.
	if ($db_connect === FALSE) {
		$errorMessage .= "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p>";
		$errorCount++;
	}	
	else {
		if (!@mysql_select_db($db_name, $db_connect)) {
			$errorMessage .= "<p>Connection error. Please try again later.</p>";
			$errorCount++;
		}	
		else {
			// verify the account belongs to the user
			$sql = "SELECT * FROM account WHERE username='$userName' and accountid='$accountId'";
			$result = mysql_query($sql);

			// If result matched $myusername and $mypassword, table row must be 1 row
			$count = mysql_num_rows($result);
			if($count == 1){
				// record login to login_history table
				$sql2 = "UPDATE account SET balance=balance+'$amount' WHERE username='$userName' and accountid='$accountId'";
				$result = mysql_query($sql2);
				$errorMessage .= "<p>Deposit completed.</p>";
			}
			else {
				$errorCount++;
				$errorMessage .= "Invalid user name/account number.<br />";
			}
		}
		mysql_close($db_connect);
	}
}

function displayForm() {
?>
	<h3>Enter account number and deposit amount.</h3>
	<?php 
	global $errorMessage;
	echo $errorMessage ?>
	<form method="POST" action="deposit.php">
		<p>Account Number: <input type="text" name="accountNumber" /></p>
		<p>Deposit Amount: <input type="amount" name="amount" /></p>
		<p><input type="submit" name="Submit" value="Submit" /></p>
	</form>
	<br /><br />
	
	<?php
}

$showForm = TRUE;
$errorCount = 0;
$errorMessage = "";
$accountNumber = 0;
$amount = 0;
$userName = "";
$userName = $_SESSION['login'];
echo "User Name: ".$userName."<br />";

// if submit button is clicked, get accountNumber and amount
if (isset($_POST['Submit'])) {
	$accountNumber  = validateInput($_POST['accountNumber'],"Account Number");
	$amount  = validateInput($_POST['amount'],"Deposit Amount");
	
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
	if ($showForm == TRUE) {
		displayForm();		// new page load
	}
	else {					// make deposit
		deposit($userName,$accountNumber,$amount);
		echo $errorMessage."<br />";
	}
}
?>

</body>
</html>