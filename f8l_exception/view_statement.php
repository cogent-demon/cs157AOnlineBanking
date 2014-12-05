<!-- F8L Exception Online Bank | View Statement -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | View Statement</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php include 'includes/inc_header.php'; ?>
	
</head>
<body>
        <hr />
        <h1>View Statement</h1>
        
<?php
include 'functions.php';
include 'includes/inc_userFunctions.php';

function displayTable() {
	global $Login;
	echo "User Name: " . $Login ;
	global $connection;
        
	// Select database.
	if ($connection->connect_error){
            echo "<div class='error'><p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p></div>";
            $errorCount++;
        } else {
            //Checking
            getChecking($Login);
            getSavings($Login);
            getCredit($Login);
            getLoan($Login);
            
	}
}
$Login = "";
$Login = $_SESSION['login'];
if ($Login == "") { // redirect to login page if not logged in
	?><script language="JavaScript">window.location = "login.php";</script><?php
}
displayTable();
?>

</body>
</html>