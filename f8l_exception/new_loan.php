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
            echo "<div class='error'><p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p></div>";
            $errorCount++;
        } else {
            $sql = "INSERT INTO loan (username, amount, balance, interestrate, dateopened, paymentDueDate) 
                    VALUES ('$userName', '$balance', '$balance', .1050, Now(), Now() + INTERVAL 30 DAY)";
            $result = queryMysql($sql);

            //get loan id and insert into transaction table
            $sql = "SELECT max(loanid) FROM loan WHERE username='$userName'";
            $result = queryMysql($sql);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $loanid = $row['max(loanid)'];
            $sql2 = "INSERT INTO transaction(username,transtype, toID, acctype, amount)
                 SELECT username, 'New Loan', '$loanid', 'Loan', '$balance' FROM loan WHERE 
                 username='$userName'";

            $result = queryMysql($sql2);
            /*
            // get loan id
            $SQLstring2 = "SELECT max(loanid) as loanId FROM loan;";
            $QueryResult2 = @mysql_query($SQLstring2, $db_connect);
            $row = mysql_fetch_assoc($QueryResult2);
            $loanId = $row['loanId'];
             * 
             */
	}
	return $loanid;
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