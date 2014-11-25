<?php
session_start(); ?>
<!-- F8L Exception Online Bank | Loan Payment -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | Loan Payment</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php include 'includes/inc_header.php'; ?>
	<h1>Loan Payment</h1><hr />
</head>
<body>

<?php
include 'includes/inc_validateInput.php';

function makeLoanPayment($userName, $loanId, $amount) {
	global $errorCount;
	global $errorMessage;
	$newBalance = 0;
	include 'includes/inc_dbConnect.php';
	
	// Select database.
	if ($db_connect === FALSE)
		echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p>";
		
	else {
		if (!@mysql_select_db($db_name, $db_connect))
			echo "<p>Connection error. Please try again later.</p>";
		else {
			$today = date("Ymd");
			$dueDate = date('Y-m-d', strtotime("+30 days")); // set due date to 30 days after today
			$SQLstring = "UPDATE loan 
				SET balance=balance-'$amount', paymentDueDate='$dueDate', paymentDate='$today'
				WHERE loanId='$loanId'";
			$QueryResult = @mysql_query($SQLstring, $db_connect);
			
			// get new balance
			$SQLstring2 = "SELECT balance FROM loan WHERE loanId='$loanId'";
			$QueryResult2 = @mysql_query($SQLstring2, $db_connect);
			$row = mysql_fetch_assoc($QueryResult2);
			$newBalance = $row['balance'];
		}
		mysql_close($db_connect);
	}
	return $newBalance;
}

function displayForm() {
	global $errorMessage;
	echo $errorMessage;
	
	?>
	<form name="loan_payment" action="loan_payment.php" method="post">
	<p>Loan Id: <input type="text" name="loanId"  /></p>
	<p>Payment Amount: <input type="text" name="amount"  /></p>	
	<p><input type="submit" name="Submit" value="Submit" /></p>
	</form>
	<br /><br />
	
	<?php
	//include 'includes/inc_text_menu.php';
}

$showForm = TRUE;
$errorCount = 0;
$errorMessage = "";
$userName = "";
$userName = $_SESSION['login'];

// if not logged in, redirect to login page
if ($userName == "") {
	echo "You must be logged in to make a loan payment.<br /><br />";
	$showForm = FALSE;
}
else {	
	echo "User Name: ".$userName."<br />";
	
	if (isset($_POST['Submit'])) {
		$loanId  = validateInput($_POST['loanId'],"Loan Id");
		$amount  = validateInput($_POST['amount'],"Payment Amount");

		if($amount < 0) {
			$errorMessage .= "Loan payment must be a positive number.<br />";
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
		// make payment in db	
		$newBalance = makeLoanPayment($userName, $loanId, $amount);
		echo "<p>Loan payment for ".$amount." has been received for Loan Id ".$loanId."</p>";
		echo "<p>New balance is ".$newBalance."<br /><br />\n";
	}
}
include 'includes/inc_text_menu.php';
?>

</body>
</html>