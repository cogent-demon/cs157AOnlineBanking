<?php
function validateUserName($data, $fieldName) 
{
	global $errorCount;
	global $errorMessage;
	
	if (empty($data)) {
		$errorMessage .= $fieldName . " is a required field.<br />\n";
		$errorCount++;
		$retval = "";
	}
	
	elseif (strlen($data) < 4 || strlen($data) > 30) {
		$errorMessage .= $fieldName . " must be at least 4 and at most 30 characters.<br />\n";
		$errorCount++;
	}
	
	else {
		include 'includes/inc_dbConnect.php';
		
		// Select database.
		if ($db_connect === FALSE)
			echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p>";
			
		else {
			if (!@mysql_select_db($db_name, $db_connect))
				echo "<p>Connection error. Please try again later.</p>";
			else {
				$SQLstring = "SELECT * FROM user WHERE username = '$data'";
				
				$QueryResult = @mysql_query($SQLstring, $db_connect);
				if (mysql_num_rows($QueryResult) > 0) {
					//echo "Please select a different User Name.<br />\n";
					$errorMessage .= "Please select a different User Name.<br />\n";
					$errorCount++;
					$retval = "";
				}
				else {
					$retval = trim($data);
					$retval = stripslashes($retval);
				}
			}
			mysql_close($db_connect);
		}
	}
	return ($retval);
}
?>