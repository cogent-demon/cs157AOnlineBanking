<!-- F8L Exception Online Bank | New Customer -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | Register a New Customer</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php 
        include 'includes/inc_header.php'; 
        ?>
	
</head>
<body>
        <hr />
        <h1>Register a New Customer</h1>
<?php

include 'includes/inc_validatePassword.php';
include 'includes/inc_validateUserName.php';
include 'includes/inc_validateEmail.php';
include 'functions.php';

function createNewCustomer($userName,$pw,$email) {
	global $errorCount;
	global $errorMessage;
	
	// Select database.
        $result = queryMysql("INSERT INTO 
                    users (username,password,email) 
                    VALUES ('$userName','$pw','$email')");
}

function displayForm($userName,$email) {
	global $errorMessage;
	echo $errorMessage;
	?>
	<form name="new_customer" action="new_customer.php" method="post">
	<p>User Name: <input type="text" name="userName" value="<?php echo $userName; ?>" /></p>
	<p>Email: <input type="text" name="email" value="<?php echo $email; ?>" /></p>
	<p>Password: <input type="password" name="password" value="" /></p>
	<p>Confirm Password: <input type="password" name="password2" value="" /></p>
	
	<p><input type="submit" name="Submit" value="Register" /></p>
	</form>
	<br /><br />
	
	<?php
	
}

$showForm = TRUE;
$errorCount = 0;
$errorMessage = "";
$email = "";
$userName = "";
$password = "";
$password2 = "";

if (isset($_POST['Submit'])) {
	$email  = validateEmail($_POST['email'],"E-mail");
	$userName  = validateUserName($_POST['userName'],"User Name");
	$password  = validatePassword($_POST['password'],$_POST['password2'],"Password");
	if($userName == $password) {
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
	displayForm ($userName,$email);
}
else {
	// should add password encryption code here
	
	// create account in db
	createNewCustomer($userName, $password, $email);

	// send confirmation email
	$SenderAddress = "F8L Exception Bank Customer <$email>";
	$Headers = "From: $SenderAddress\nCC:$SenderAddress\n";
	
	$from = "F8L Exception Online Bank"; // sender
    $subject = "F8L Exception Online Bank New Customer Confirmation";
    $message = "You have successfully registered as a new customer for F8L Exception Online Bank. We hope you will enjoy our service and our lack of fees!\n\nThe F8L Exception Online Bank";
    // message lines should not exceed 70 characters (PHP rule), so wrap it
    $message = wordwrap($message, 70);
    
    // send mail
    //mail($email,$subject,$message,"From: $from\n");
	
    echo "<p>You have been set up as a new customer. Welcome to F8L Exception Online Bank!.</p><br /><br />\n";
}	
?>

</body>
</html>