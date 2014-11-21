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
		
            // Select database.
            $result = queryMysql("SELECT * FROM users WHERE username = '$data'");
            $num = $result->num_rows;

            if ($num > 0){
                $errorMessage .= "Please select a different User Name.<br />\n";
                            $errorCount++;
                            $retval = "";
            } else {
                $retval = trim($data);
                $retval = stripslashes($retval);
            }

            $result->close();
	}
	return ($retval);
}
?>