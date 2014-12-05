<!-- F8L Exception Online Bank | New Credit Card -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | New Credit Card</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php include 'includes/inc_header.php'; ?>
	
</head>
<body>
<hr />
<h1>New Credit Card</h1>
<?php
include 'includes/inc_validateInput.php';
include 'functions.php';

function openNewCreditCard($userName,$limit) {
	global $errorCount;
	global $errorMessage;
        global $connection;
        
	//include 'includes/inc_dbConnect.php';
	
	// Select database.
	if ($connection->connect_error){
            echo "<div class='error'><p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p></div>";
            $errorCount++;
        } else {
            $sql = "INSERT INTO creditcard (username, maxLimit, dateopened, paymentDueDate) 
                    VALUES ('$userName', '$limit', Now(), Now() + INTERVAL 30 DAY)";
            $result = queryMysql($sql);

            $sql2 = "INSERT INTO transaction(username, transtype, toID, acctype, amount)
                 SELECT username, 'New Credit Card', creditid, acctype, '$limit' FROM creditcard WHERE 
                 username='$userName'";
            $result = queryMysql($sql2);
            
            // get credit card account number
            $sql2 = "SELECT max(creditid) as accountNumber FROM creditcard;";
            $result = queryMysql($sql2);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $accountNumber = $row['accountNumber'];
	}
	return $accountNumber;
}

function displayForm() {
	global $errorMessage;
	echo $errorMessage;
	
	?>
	<form name="new_credit_card" action="new_credit_card.php" method="post">
	<p>Limit: <input type="text" name="limit"  /></p>	
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
	echo "You must be logged in to open a new credit card.<br /><br />";
	$showForm = FALSE;
}
else {	
	echo "User Name: ".$userName."<br />";
	
	if (isset($_POST['Submit'])) {
		$limit  = validateInput($_POST['limit'],"Limit");

		if($limit < 0) {
			$errorMessage .= "Limit must be a positive number.<br />";
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
		// create credit card account in db	
		$accountNumber = openNewCreditCard($userName,$limit);
		echo "<p>New credit card has been created for ".$userName." with Credit Card Account Number ".$accountNumber.".</p><br /><br />\n";
	}
}
?>

</body>
</html>