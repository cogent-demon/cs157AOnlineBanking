<?php
function validateInput($data, $fieldName) 
{
	global $errorMessage;
	global $errorCount;
	if (empty($data)) 
	{
		$errorMessage .= $fieldName . " is a required field.<br />\n";
		$errorCount++;
		$retval = "";
	}
	else
	{
		// only clean up the input if it isn't empty
		$retval = trim($data);
		$retval = stripslashes($retval);
	}
	return ($retval);
}
?>