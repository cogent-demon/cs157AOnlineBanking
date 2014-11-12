<?php
function showAccounts($userName) {
	include($_SERVER['DOCUMENT_ROOT']."/f8l_exception/includes/inc_dbConnect.php");
	// Select database.
	if ($db_connect === FALSE)
		echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p>";
		
	else {
		if (!@mysql_select_db($db_name, $db_connect))
			echo "<p>Connection error. Please try again later.</p>";
		else {
			$SQLstring = "SELECT * from account 
				WHERE username='$userName'";
			
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
	return ($retval);
}
?>