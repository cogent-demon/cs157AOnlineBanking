<!-- F8L Exception Online Bank | Loan Payment -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | Credit Card Payment</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php include 'includes/inc_header.php'; ?>
	
</head>
<body>
    <hr />
    <h1>Credit Card Payment</h1>
<?php
include 'includes/inc_validateInput.php';
include 'functions.php';

function makeCreditPayment($userName, $creditId, $amount) {
	global $errorCount;
	global $errorMessage;
        global $connection;
	$newBalance = 0;
	
	// Select database.
	if ($connection->connect_error){
            echo "<div class='error'><p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p></div>";
            $errorCount++;
        } else {
            $sql = "UPDATE creditcard 
                    SET balance=balance-'$amount', paymentDueDate=Now() + INTERVAL 30 DAY, paymentDate=Now()
                    WHERE creditid='$creditId'";
            $result = queryMysql($sql);

            $sql2 = "INSERT INTO transaction(username, accid, transtype, toID, acctype, amount)
                 SELECT username, NULL, 'Credit Card Payment', creditid, acctype, '$amount' FROM creditcard WHERE 
                 username='$userName'";
            $result = queryMysql($sql2);

            // get new balance
            $sql2 = "SELECT balance FROM creditcard WHERE creditid='$creditId'";
            $result = queryMysql($sql2);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $newBalance = $row['balance'];
	}
	return $newBalance;
}

function displayForm() {
	global $errorMessage;
	echo $errorMessage;
	
	?>
	<form action="credit_payment.php" method="post">
	<p>Credit Card Id: <input type="text" name="loanId"  /></p>
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
		$newBalance = makeCreditPayment($userName, $loanId, $amount);
		echo "<p>Loan payment of $".$amount." has been received for Loan Id ".$loanId."</p>";
		echo "<p>New balance is $".$newBalance."<br /><br />\n";
	}
}
?>

</body>
</html>