<!-- F8L Exception Online Bank | Withdraw -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | Credit</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php include 'includes/inc_header.php'; ?>
	
</head>
<body>
        <hr />
        <h1>Credit</h1>
<?php
include 'includes/inc_validateInput.php';
include 'includes/inc_validateLogin.php';

function credit($userName,$accountId,$amount) {
	global $errorCount;
	global $errorMessage;
        global $connection;
        
	// Select database.
        if ($connection->connect_error){
            echo "<div class='error'><p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p></div>";
            $errorCount++;
        } else {
            $sql2 = "UPDATE creditcard SET balance=balance+'$amount' WHERE username='$userName' and creditid='$accountId'";
            $result = queryMysql($sql2);

            $sql2 = "INSERT INTO transaction(username, accid, transtype, toID, acctype, amount)
                     SELECT username, NULL, 'Credit', creditid, acctype, '$amount' FROM creditcard WHERE 
                     creditid='$accountId'";
            $result = queryMysql($sql2);

            $errorMessage .= "<p>Credit completed.</p>";
	}
}

function displayForm() {
?>
	<h3>Enter account number and credit amount.</h3>
	<?php 
	global $errorMessage;
	echo $errorMessage ?>
	<form method="POST" action="credit.php">
		<p>Account Number: <input type="text" name="accountNumber" /></p>
		<p>Credit Amount: <input type="amount" name="amount" /></p>
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
	$amount  = validateInput($_POST['amount'],"Credit Amount");
	
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
	else {					// make withdraw
		credit($userName,$accountNumber,$amount);
		echo $errorMessage."<br />";
	}
}
?>

</body>
</html>