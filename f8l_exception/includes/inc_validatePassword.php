<?php
// check if password contains at least 1 upper case letter
function containsUpper($data) {
	return (preg_match('/[A-Z]/', $data));
}
function containsLower($data) {
	return (preg_match('/[a-z]/', $data));
}
function containsNumber($data) {
	return (preg_match('/[0-9]/', $data));
}
function containsOther($data) {
	return TRUE;
}
function containsSpaces($data) {
	return  (preg_match("/\s/",$data));
}
function validatePassword($data, $data2, $fieldName) 
{
	global $errorCount;
	global $errorMessage;
	
	if (empty($data) or empty($data2)) 
	{
		$errorMessage .= $fieldName . " is a required field.<br />\n";
		$errorCount++;
		$retval = "";
	}
	elseif ($data !== $data2)
	{
		$errorMessage .= "Passwords do not match.<br />\n";
		$errorCount++;
		$retval = "";
	}
	elseif (strlen($data) < 8)
	{
		$errorMessage .= "Password must be at least 8 characters, 
		must contain at least one upper case letter, at least one lower case letter, 
		at least one number, and at least one non-alphanumeric character.<br />\n";
		$errorCount++;
		$retval = "";
	}
	elseif (!containsUpper($data) or !containsLower($data) or !containsNumber($data) or 
		!containsOther($data) or containsSpaces($data))
	{
		$errorMessage .= "Password must be at least 8 characters, 
		must contain at least one upper case letter, at least one lower case letter, 
		at least one number, and at least one non-alphanumeric character.<br />\n";
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