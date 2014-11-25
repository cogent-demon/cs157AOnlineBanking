<!-- F8L Exception Online Bank | New Loan -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | New Loan</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php include 'includes/inc_header.php'; ?>
	
</head>
<body>
    <hr />
    <h1>New Loan</h1>
<?php
include 'includes/inc_validateInput.php';
include 'functions.php';

function openNewLoan($userName,$balance) {
	global $errorCount;
	global $errorMessage;
	global $connection;
	
	// Select database.
	if ($connection->connect_error){
            echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p>";
            $errorCount++;
        } else {
            
            if (!@mysql_select_db($db_name, $db_connect))
                    echo "<p>Connection error. Please try again later.</p>";
            else {
                    $today = date("Ymd");
                    $dueDate = date('Y-m-d', strtotime("+30 days")); // set due date to 30 days after today
                    $SQLstring = "INSERT INTO 
                            loan (username, amount, balance, dateOpened, paymentDueDate) 
                            VALUES ('$userName', '$balance', '$balance', '$today', '$dueDate')";
                    $QueryResult = @mysql_query($SQLstring, $db_connect);

                    // get loan id
                    $SQLstring2 = "SELECT max(loanid) as loanId FROM loan;";
                    $QueryResult2 = @mysql_query($SQLstring2, $db_connect);
                    $row = mysql_fetch_assoc($QueryResult2);
                    $loanId = $row['loanId'];
            }
            mysql_close($db_connect);
	}
	return $loanId;
}

function displayForm() {
	global $errorMessage;
	echo $errorMessage;
	
	?>
	<form name="new_loan" action="new_loan.php" method="post">
	<p>Loan Amount: <input type="text" name="balance"  /></p>	
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
	echo "You must be logged in to open a new loan.<br /><br />";
	$showForm = FALSE;
}
else {	
	echo "User Name: ".$userName."<br />";
	
	if (isset($_POST['Submit'])) {
		$balance  = validateInput($_POST['balance'],"Loan Amount");

		if($balance < 0) {
			$errorMessage .= "Loan amount must be a positive number.<br />";
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
		// create loan in db	
		$loanId = openNewLoan($userName,$balance);
		echo "<p>New loan has been created for ".$userName." with Loan Id ".$loanId." for ".$balance."</p><br /><br />\n";
	}
}
?>

</body>
</html>