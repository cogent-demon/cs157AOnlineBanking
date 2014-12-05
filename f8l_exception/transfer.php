<!-- F8L Exception Online Bank | Transfer -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | Transfer</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php include 'includes/inc_header.php'; ?>
	
</head>
<body>
        <hr />
        <h1>Transfer</h1>
<?php
include 'includes/inc_validateInput.php';
include 'includes/inc_validateLogin.php';

function transfer($userName,$fromAccountId,$toAccountId,$amount) {
	global $errorCount;
	global $errorMessage;
        global $connection;
        
	// Select database.
	if ($connection->connect_error){
            echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p>";
            $errorCount++;
        } else {
            // verify the account belongs to the user
            $query = "SELECT * FROM account WHERE username='$userName' and accID='$fromAccountId'";
            $result = queryMysql($query);

            // If result matched $myusername and $accountId, table rows must be 1 row
            $count = $result->num_rows;

            if($count == 1){
                // record transfer to both accounts
                $sql2 = "UPDATE account SET balance=balance-'$amount' WHERE username='$userName' and accID='$fromAccountId'";
                $result = queryMysql($sql2);
                $sql3 = "UPDATE account SET balance=balance+'$amount' WHERE accID='$toAccountId'";
                $result = queryMysql($sql3);
                
                $sql2 = "INSERT INTO transaction(username, accid, transtype, toID, acctype, amount)
                         SELECT username, '$fromAccountId','Transfer', '$toAccountId', acctype, '$amount' FROM account WHERE 
                         accID='$fromAccountId'";
                $result = queryMysql($sql2);

                $sql2 = "INSERT INTO transaction(username, accid, transtype, toID, acctype, amount)
                         SELECT username, '$fromAccountId','Transfer', accid, acctype, '$amount' FROM account WHERE 
                         accID='$toAccountId'";
                $result = queryMysql($sql2);
                
                $errorMessage .= "<p>Transfer completed.</p>";
            }
            else {
                $errorCount++;
                $errorMessage .= "Invalid user name/account number.<br />";
            }
	}
}

function displayForm() {
?>
	<h3>Enter from account number, to account number and transfer amount.</h3>
	<?php 
	global $errorMessage;
	echo $errorMessage ?>
	<form method="POST" action="transfer.php">
		<p>From Account Number: <input type="text" name="fromAccountNumber" /></p>
		<p>To Account Number: <input type="text" name="toAccountNumber" /></p>
		<p>Transfer Amount: <input type="amount" name="amount" /></p>
		<p><input type="submit" name="Submit" value="Submit" /></p>
	</form>
	<br /><br />
	
	<?php
}

$showForm = TRUE;
$errorCount = 0;
$errorMessage = "";
$fromAccountNumber = 0;
$toAccountNumber = 0;
$amount = 0;
$userName = "";
$userName = $_SESSION['login'];
echo "User Name: ".$userName."<br />";

// if submit button is clicked, get accountNumber and amount
if (isset($_POST['Submit'])) {
	$fromAccountNumber  = validateInput($_POST['fromAccountNumber'],"From Account Number");
	$toAccountNumber  = validateInput($_POST['toAccountNumber'],"To Account Number");
	$amount  = validateInput($_POST['amount'],"Transfer Amount");
	if ($amount <= 0) {
		$errorMessage .= "Invalid amount.<br />";
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
	if ($showForm == TRUE) {
		displayForm();		// new page load
	}
	else {					// make transfer
		transfer($userName,$fromAccountNumber,$toAccountNumber,$amount);
		echo $errorMessage."<br />";
	}
}
?>

</body>
</html>