<?php
//session_start(); ?>
<!-- F8L Exception Online Bank | Login -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | Login</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php
        include 'includes/inc_header.php'; 
        ?>
	
</head>
<body>
        <hr />
        <h1>Login</h1>
<?php
include 'includes/inc_validateInput.php';
include 'includes/inc_validateLogin.php';

function displayForm() {
?>
	<h3>Enter your User Name and Password.</h3>
	<?php 
	global $errorMessage;
	echo $errorMessage ?>
	<form method="POST" action="login.php">
		<p>User Name <input type="text" name="userName" /></p>
		<p>Password <input type="password" name="password" /></p>
		<p><input type="submit" name="Submit" value="Log in" /></p>
	</form>
	<br /><br />
	
	<?php
	
}

$ShowForm = TRUE;
$errorCount = 0;
$errorMessage = "";
$userName = "";
$password = "";	

// if submit button is clicked, get login and pw and validate login
if (isset($_POST['Submit'])) {
	$userName  = validateInput($_POST['userName'],"User Name");
	$password  = validateInput($_POST['password'],"Password");
	
	if ($errorCount == 0)	// validateLogin is slow, so only do that if no errors yet
		$userName = validateLogin($userName,$password);
	if ($errorCount == 0)
		$ShowForm = FALSE;
}

if ($errorCount > 0) {		// errors logged
		displayForm();
	}
else {
	if ($ShowForm == TRUE) {
		displayForm();		// new page load
	}
	else {					// login approved
		$_SESSION['login'] = $userName;
		//header("location:my_documents.php");
		?><script language="JavaScript">window.location = "my_accounts.php";</script><?php
		exit();
	}
}
?>

</body>
</html>