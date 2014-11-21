<?php
    include 'includes/inc_header.php';
?>
<!-- PVault | Logout -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>

<?php
	// Unset all of the session variables, and Destroy the session, then redirect to home
	session_unset(); 
	session_destroy();
	?><script language="JavaScript">window.location = "index.php";</script><?php
?>

</body>
</html>