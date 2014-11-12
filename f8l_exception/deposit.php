<?php
session_start(); ?>
<!-- F8L Exception Online Bank | Deposit -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | Deposit</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php include 'includes/inc_header.php'; ?>
	<h1>Deposit -- under construction</h1><hr />
</head>
<body>

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
		<p>User Name <input type="text" name="Login" /></p>
		<p>Password <input type="password" name="Password" /></p>
		<p><input type="submit" value="Log in" /></p>
	</form>
	<br /><br />
	
	<?php
	include 'includes/inc_text_menu.php';
}

$ShowForm = TRUE;
$errorCount = 0;
$errorMessage = "";
$Login = "";
$Password = "";	

// if submit button is clicked, get login and pw and validate login
if (isset($_POST['Login'])) {
	$Login  = validateInput($_POST['Login'],"User Name");
	$Password  = validateInput($_POST['Password'],"Password");
	if ($errorCount == 0)	// validateLogin is slow, so only do that if no errors yet
		$Login = validateLogin($Login,$Password);
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
		$_SESSION['login'] = $Login;
		//header("location:my_documents.php");
		?><script language="JavaScript">window.location = "my_documents.php";</script><?php
		exit();
	}
}
?>

</body>
</html>