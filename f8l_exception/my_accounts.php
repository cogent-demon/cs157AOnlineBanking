<!-- F8L Exception Online Bank | My Accounts -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | My Accounts</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php include 'includes/inc_header.php'; ?>
	
</head>
<body>
        <hr />
        <h1>My Accounts</h1>
<?php
include 'functions.php';
function showAccounts($userName) {
	// Select database.
        $result = queryMysql("SELECT * from account WHERE username='$userName'");
        if ($result->num_rows == 0){
            echo "<p>You have no accounts open.</p>";
        } else {
            echo "<table width='50%' border='1'>";
            echo "<tr>
                    <th>Account Type</th>
                    <th>Account Number</th>
                    <th>Balance</th>
                    </tr>";
            $num = $result->num_rows;
            for ($j = 0; $j < $num; $j++){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                echo "<tr><td>" . $row['username'] . "</td><td>" . $row['acctype'] . "</td><td>$ " . number_format($row['balance'], 2, '.', ',') . "</td></tr>";
            }
            $result->close();
        }
        /*
	if ($db_connect === FALSE)
		echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p>";
		
	else {
		if (!@mysql_select_db($db_name, $db_connect))
			echo "<p>Connection error. Please try again later.</p>";
		else {
         * 
         *
			$SQLstring = "SELECT * from account 
				WHERE username='$userName'";
	*		
			$QueryResult = @mysql_query($SQLstring, $db_connect);
			if (mysql_num_rows($QueryResult) == 0)
				echo "<p>You have no accounts open.</p>";
			else {
				echo "<table width='50%' border='1'>";
				echo "<tr>
					<th>Account Type</th>
					<th>Account Number</th>
					<th>Balance</th>
					</tr>";
         * 
         *
        
				while (($Row = mysql_fetch_assoc($QueryResult)) !== FALSE) 
				{
					echo "<td>{$Row['accounttype']}</td>";
					echo "<td>{$Row['accountid']}</td>";
					echo "<td>{$Row['balance']}</td></tr>";
				}
				echo "</table><br /><br />";
			}
		}
		mysql_close($db_connect);
	}
         * 
         */
	//return ($retval);
}

$userName = "";
$userName = $_SESSION['login'];
echo "User Name: ".$userName."<br />";
showAccounts($userName);

?>

</body>
</html>